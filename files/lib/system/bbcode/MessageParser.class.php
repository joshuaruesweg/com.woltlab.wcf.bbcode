<?php
namespace wcf\system\bbcode;
use wcf\data\bbcode\attribute\BBCodeAttribute;
use wcf\data\smiley\SmileyCache;
use wcf\util\StringUtil;

/**
 * Parses bbcode tags, smilies etc. in messages.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode
 * @category 	Community Framework
 */
class MessageParser extends BBCodeParser {
	/**
	 * list of smilies
	 * @var	array<wcf\data\smiley\Smiley>
	 */
	protected $smilies = array();
	
	/**
	 * cached bbcodes
	 * @var	array
	 */
	protected $cachedCodes = array();
	
	/**
	 * regular expression for source code tags
	 * @var	string
	 */
	protected $sourceCodeRegEx = '';
	
	/**
	 * @see	wcf\system\SingletonFactory::init()
	 */
	protected function init() {
		parent::init();
		
		// TODO: add setting MODULE_SMILEY
		//if (MODULE_SMILEY == 1) {
			// handle source codes
			$sourceCodeTags = array();
			foreach ($this->bbcodes as $bbcode) {
				if ($bbcode->isSourceCode) $sourceCodeTags[] = $bbcode->bbcodeTag;
			}
			if (count($sourceCodeTags)) $this->sourceCodeRegEx = implode('|', $sourceCodeTags);
			
			// get smilies
			$smilies = SmileyCache::getInstance()->getSmilies();
			foreach ($smilies as $categoryID => $categorySmilies) {
				foreach ($categorySmilies as $smiley) {
					$this->smilies[$smiley->smileyCode] = '<img src="'.$smiley->getURL().'" alt="'.StringUtil::encodeHTML($smiley->smileyCode).'" />';
				}
			}
		//}
	}
	
	/**
	 * Parses a message.
	 * 
	 * @param	string		$message
	 * @param	boolean		$enableSmilies
	 * @param	boolean		$enableHtml
	 * @param	boolean		$enableBBCodes
	 * @param	boolean		$doKeywordHighlighting
	 * @return	string		parsed message
	 */
	public function parse($message, $enableSmilies = true, $enableHtml = false, $enableBBCodes = true, $doKeywordHighlighting = true) {
		$this->cachedCodes = array();
		
		if ($this->getOutputType() != 'text/plain') {
			if ($enableBBCodes) {
				// cache codes
				$message = $this->cacheCodes($message);
			}
			
			if (!$enableHtml) {
				// encode html
				$message = StringUtil::encodeHTML($message);
				
				// converts newlines to <br />'s
				$message = nl2br($message);
			}
		}
		
		// parse bbcodes
		if ($enableBBCodes) {
			$message = parent::parse($message);
		}
		
		if ($this->getOutputType() != 'text/plain') {
			// parse smilies
			if ($enableSmilies) {
				$message = $this->parseSmilies($message, $enableHtml);
			}
			
			if ($enableBBCodes && count($this->cachedCodes) > 0) {
				// insert cached codes
				$message = $this->insertCachedCodes($message);
			}
			
			// highlight search query
			if ($doKeywordHighlighting) {
				// TODO: add keyword highlighting
				//$message = KeywordHighlighter::doHighlight($message);
			}
			
			// replace bad html tags (script etc.)
			$badSearch = array('/(javascript):/i', '/(about):/i', '/(vbscript):/i');
			$badReplace = array('$1<b></b>:', '$1<b></b>:', '$1<b></b>:');
			$message = preg_replace($badSearch, $badReplace, $message);
		}
		
		return $message;
	}
	
	/**
	 * Parses smiley codes.
	 * 
	 * @param	string		$text
	 * @return	string		text
	 */
	protected function parseSmilies($text, $enableHtml = false) {
		foreach ($this->smilies as $code => $html) {
			$text = preg_replace('~(?<!&\w{2}|&\w{3}|&\w{4}|&\w{5}|&\w{6}|&#\d{2}|&#\d{3}|&#\d{4}|&#\d{5})'.preg_quote((!$enableHtml ? StringUtil::encodeHTML($code) : $code), '~').'(?![^<]*>)~', $html, $text);
		}
		
		return $text;
	}
	
	/**
	 * Caches code bbcodes to avoid parsing of smileys and other bbcodes inside them.
	 * 
	 * @param	string		$text
	 * @return	string
	 */
	protected function cacheCodes($text) {
		if (!empty($this->sourceCodeRegEx)) {
			$text = preg_replace_callback("~(\[(".$this->sourceCodeRegEx.")
				(?:=
					(?:\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'|[^,\]]*)
					(?:,(?:\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'|[^,\]]*))*
				)?\])
				(.*?)
				(?:\[/\\2\])~six", array($this, 'cacheCodesCallback'), $text);
		}
		return $text;
	}
	
	protected function cacheCodesCallback($matches) {
		// create hash
		$hash = '@@'.StringUtil::getHash(uniqid(microtime()).$matches[3]).'@@';
		
		// build tag
		$tag = $this->buildTag($matches[1]);
		$tag['content'] = $matches[3];
		
		// save tag
		$this->cachedCodes[$hash] = $tag;
		
		return $hash;
	}
	
	/**
	 * Reinserts cached code bbcodes.
	 * 
	 * @param	string		$text
	 * @return	string
	 */
	protected function insertCachedCodes($text) {
		foreach ($this->cachedCodes as $hash => $tag) {
			// build code and insert
			$text = str_replace($hash, $this->bbcodes[$tag['name']]->getProcessor()->getParsedTag($tag, $tag['content'], $tag, $this), $text);
		}
		
		return $text;
	}
	
	/**
	 * @see	wcf\system\bbcode\BBCodeParser::isValidTagAttribute()
	 */
	protected function isValidTagAttribute(array $tagAttributes, BBCodeAttribute $definedTagAttribute) {
		if (!parent::isValidTagAttribute($tagAttributes, $definedTagAttribute)) {
			return false;
		}
		
		// check for cached codes
		if (isset($tagAttributes[$definedTagAttribute->attributeNo]) && preg_match('/@@[a-f0-9]{40}@@/', $tagAttributes[$definedTagAttribute->attributeNo])) {
			return false;
		}
		
		return true;
	}
}
