<?php
namespace wcf\system\bbcode;
use wcf\data\bbcode\BBCodeCache;
use wcf\system\event\EventHandler;
use wcf\system\SingletonFactory;
use wcf\util\StringUtil;

/**
 * Parses URLs in message text.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode
 * @category 	Community Framework
 */
class URLParser extends SingletonFactory {
	/**
	 * forbidden characters
	 * @var	string
	 */
	protected static $illegalChars = '[^\x0-\x2C\x2E\x2F\x3A-\x40\x5B-\x60\x7B-\x7F]+';
	
	/**
	 * regular expression for source codes
	 * @var	string
	 */
	protected $sourceCodeRegEx = '';
	
	/**
	 * cached codes
	 * @var	array
	 */
	protected $cachedCodes = array();
	
	/**
	 * text
	 * @var	string
	 */
	public $text = '';
	
	/**
	 * @see	wcf\system\SingletonFactory::init()
	 */
	protected function init() {
		$sourceCodeTags = array();
		foreach (BBCodeCache::getInstance()->getBBCodes() as $bbcode) {
			if ($bbcode->isSourceCode) $sourceCodeTags[] = $bbcode->bbcodeTag;
		}
		if (count($sourceCodeTags)) $this->sourceCodeRegEx = implode('|', $sourceCodeTags);
	}
	
	/**
	 * Adds the url and email bbcode tags in a text automatically.
	 * 
	 * @param	string		$text
	 * @return	string
	 */
	public function parse($text) {
		$this->text = $text;
		
		// cache codes
		$this->cacheCodes();
		
		// call event
		EventHandler::getInstance()->fireAction($this, 'beforeParsing');
		
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
			(?:'.self::$illegalChars.'\.)+		# hostname
			(?:[a-z]{2,4}(?=\b))
			(?!"|\'|\[|\-|\.[a-z])
			~ix';
		
		// add url tags
		$this->text = preg_replace($urlPattern, '[url]\\0[/url]', $this->text);
		if (StringUtil::indexOf($this->text, '@') !== false) {
			$this->text = preg_replace($emailPattern, '[email]\\0[/email]', $this->text);
		}
	
		// call event
		EventHandler::getInstance()->fireAction($this, 'afterParsing');
		
		if (count($this->cachedCodes) > 0) {
			// insert cached codes
			$this->insertCachedCodes();
		}
		
		return $this->text;
	}
	
	/**
	 * Caches code bbcodes to avoid parsing of urls inside them.
	 */
	protected function cacheCodes() {
		if (!empty($this->sourceCodeRegEx)) {
			$this->cachedCodes = array();
			$this->text = preg_replace_callback("~(\[(".$this->sourceCodeRegEx.")
				(?:=
					(?:\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'|[^,\]]*)
					(?:,(?:\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'|[^,\]]*))*
				)?\])
				(.*?)
				(?:\[/\\2\])~six", function ($matches) {
					// create hash
					$hash = '@@'.StringUtil::getHash(uniqid(microtime()).$matches[0]).'@@';
					
					// save tag
					$this->cachedCodes[$hash] = $matches[0];
				
					return $hash;
				}, $this->text);
		}
	}
	
	/**
	 * Reinserts cached code bbcodes.
	 */
	protected function insertCachedCodes() {
		foreach ($this->cachedCodes as $hash => $content) {
			$this->text = str_replace($hash, $content, $this->text);
		}
	}
}
