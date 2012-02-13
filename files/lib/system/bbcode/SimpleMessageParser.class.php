<?php
namespace wcf\system\bbcode;
use wcf\data\smiley\SmileyCache;
use wcf\system\event\EventHandler;
use wcf\system\SingletonFactory;
use wcf\util\ArrayUtil;
use wcf\util\StringUtil;

/**
 * Parses urls and smilies in simple messages.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode
 * @category 	Community Framework
 */
class SimpleMessageParser extends SingletonFactory {
	/**
	 * forbidden characters
	 * @var	string
	 */
	protected static $illegalChars = '[^\x0-\x2C\x2E\x2F\x3A-\x40\x5B-\x60\x7B-\x7F]+';
	
	/**
	 * page urls
	 * @var	array<string>
	 */
	protected $pageURLs = null;
	
	/**
	 * list of smilies
	 * @var	array<wcf\data\smiley\Smiley>
	 */
	protected $smilies = array();
	
	/**
	 * @see	wcf\system\SingletonFactory::init()
	 */
	protected function init() {
		parent::init();
		
		if (MODULE_SMILEY == 1) {
			// get smilies
			$smilies = SmileyCache::getInstance()->getSmilies();
			foreach ($smilies as $categoryID => $categorySmilies) {
				foreach ($categorySmilies as $smiley) {
					$this->smilies[$smiley->smileyCode] = '<img src="'.$smiley->getURL().'" alt="'.StringUtil::encodeHTML($smiley->smileyCode).'" />';
				}
			}
			krsort($this->smilies);
		}
		
		// get page urls
		$urlString = '';
		if (defined('PAGE_URL')) $urlString .= PAGE_URL;
		if (defined('PAGE_URLS')) $urlString .= "\n".PAGE_URLS;
		
		$urlString = StringUtil::unifyNewlines($urlString);
		$this->pageURLs = ArrayUtil::trim(explode("\n", $urlString));
	}
	
	/**
	 * Parses a message.
	 * 
	 * @param	string		$message
	 * @param	boolean		$parseURLs
	 * @param	boolean		$parseSmilies
	 * @return	string		parsed message
	 */
	public function parse($message, $parseURLs = true, $parseSmilies = true) {		
		// call event
		EventHandler::getInstance()->fireAction($this, 'beforeParsing');
		
		// encode html
		$message = StringUtil::encodeHTML($message);
		
		// converts newlines to <br />'s
		$message = nl2br($message);
		
		// parse urls
		if ($parseURLs) {
			$message = $this->parseURLs($message);
		}
		
		// parse smilies
		if ($parseSmilies) {
			$message = $this->parseSmilies($message);
		}
		
		$badSearch = array('/(javascript):/i', '/(about):/i', '/(vbscript):/i');
		$badReplace = array('$1<b></b>:', '$1<b></b>:', '$1<b></b>:');
		$message = preg_replace($badSearch, $badReplace, $message);
		
		// call event
		EventHandler::getInstance()->fireAction($this, 'afterParsing');
		
		return $message;
	}
	
	/**
	 * Parses urls.
	 * 
	 * @param	string		$text
	 * @return	string		text
	 */
	public function parseURLs($text) {
		// define pattern
		$urlPattern = '~(?<!\B|"|\'|=|/|\]|,|\?)
			(?:						# hostname
				(?:ftp|https?)://'.static::$illegalChars.'(?:\.'.static::$illegalChars.')*
				|
				www\.(?:'.static::$illegalChars.'\.)+
				(?:[a-z]{2,4}(?=\b))
			)

			(?::\d+)?					# port

			(?:
				/
				[^!.,?;"\'<>()\[\]{}\s]*
				(?:
					[!.,?;(){}]+ [^!.,?;"\'<>()\[\]{}\s]+
				)*
			)?
			~ix';
		$emailPattern = '~(?<!\B|"|\'|=|/|\]|,|:)
			(?:)
			\w+(?:[\.\-]\w+)*
			@
			(?:'.static::$illegalChars.'\.)+		# hostname
			(?:[a-z]{2,4}(?=\b))
			(?!"|\'|\[|\-)
			~ix';
		
		// parse urls
		$text = preg_replace_callback($urlPattern, array($this, 'parseURLsCallback'), $text);
		
		// parse emails
		if (StringUtil::indexOf($text, '@') !== false) {
			$text = preg_replace($emailPattern, '<a href="mailto:\\0">\\0</a>', $text);
		}
	
		return $text;
	}
	
	/**
	 * Callback for preg_replace.
	 *
	 * @see	\wcf\system\bbcode\SimpleMessageParser::parseURLs()
	 */
	protected function parseURLsCallback($matches) {
		$url = $title = $matches[0];
		$decodedTitle = StringUtil::decodeHTML($title);
		if (StringUtil::length($decodedTitle) > 60) {
			$title = StringUtil::encodeHTML(StringUtil::substring($decodedTitle, 0, 40)) . '&hellip;' . StringUtil::encodeHTML(StringUtil::substring($decodedTitle, -15));
		}
		// add protocol if necessary
		if (!preg_match("~[a-z]://~si", $url)) $url = 'http://'.$url;
		
		$external = true;
		if (($newURL = $this->isInternalURL($url)) !== false) {
			$url = $newURL;
			$external = false;
		}
		
		return '<a href="'.$url.'"'.($external ? ' class="wcf-externalURL"' : '').'>'.$title.'</a>';
	}
	
	/**
	 * Parses smiley codes.
	 * 
	 * @param	string		$text
	 * @return	string		text
	 */
	public function parseSmilies($text) {
		foreach ($this->smilies as $code => $html) {
			//$text = preg_replace('~(?<!&\w{2}|&\w{3}|&\w{4}|&\w{5}|&\w{6}|&#\d{2}|&#\d{3}|&#\d{4}|&#\d{5})'.preg_quote(StringUtil::encodeHTML($code), '~').'(?![^<]*>)~', $html, $text);
			$text = preg_replace('~(?<=^|\s)'.preg_quote(StringUtil::encodeHTML($code), '~').'(?=$|\s|<br />)~', $html, $text);
		}
		
		return $text;
	}
	
	/**
	 * Checks whether a URL is an internal URL.
	 * 
	 * @param	string		$url
	 * @return	mixed	
	 */
	protected function isInternalURL($url) {
		foreach ($this->pageURLs as $pageURL) {
			if (stripos($url, $pageURL) === 0) {
				return str_ireplace($pageURL.'/', '', $url);
			}
		}
		
		return false;
	}
}
