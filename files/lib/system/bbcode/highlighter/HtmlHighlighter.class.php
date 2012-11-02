<?php
namespace wcf\system\bbcode\highlighter;
use \wcf\system\Callback;
use \wcf\system\Regex;
use \wcf\util\StringUtil;

/**
 * Highlights syntax of (x)html documents including style and script blocks.
 * 
 * @author	Tim Düsterhus, Michael Schaefer
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode.highlighter
 * @category 	Community Framework
 */
class HtmlHighlighter extends XmlHighlighter {
	// cache
	protected $cachedScripts = array();
	protected $cachedStyles = array();
	
	/**
	 * @see Highlighter::cacheComments()
	 */
	protected function cacheComments($string) {
		$this->cachedScripts = $this->cachedStyles = array();

		// cache inline scripts
		$string = $this->cacheScripts($string);
		
		// cache inline css
		$string = $this->cacheStyles($string);
		
		return parent::cacheComments($string);
	}
	
	protected function cacheScripts($string) {
		$regex = new Regex('(<script[^>]*>)(.*?)(</script>)', Regex::CASE_INSENSITIVE | Regex::DOT_ALL);
		return $regex->replace($string, new Callback(array($this, 'cacheScript')));
	}
	
	protected function cacheStyles($string) {
		$regex = new Regex('(<style[^>]*>)(.*?)(</style>)', Regex::CASE_INSENSITIVE | Regex::DOT_ALL);
		return $regex->replace($string, new Callback(array($this, 'cacheStyle')));
	}
	
	/**
	 * Caches a script block.
	 */
	public function cacheScript($matches) {
		// strip slashes
		$content = str_replace("\\\"", "\"", $matches[2]);
		$openingTag = str_replace("\\\"", "\"", $matches[1]);
		$closingTag = str_replace("\\\"", "\"", $matches[3]);
		
		if (StringUtil::trim($content) == '') return $matches[0];
		
		// create hash
		$hash = '@@'.StringUtil::getHash(uniqid(microtime()).$content).'@@';
		
		// save
		$this->cachedScripts[$hash] = '<span class="jsHighlighter">'.JsHighlighter::getInstance()->highlight($content).'</span>';
		
		return $openingTag.$hash.$closingTag;
	}
	
	/**
	 * Caches a style block.
	 */
	public function cacheStyle($matches) {
		// strip slashes
		$content = str_replace("\\\"", "\"", $matches[2]);
		$openingTag = str_replace("\\\"", "\"", $matches[1]);
		$closingTag = str_replace("\\\"", "\"", $matches[3]);
		
		if (StringUtil::trim($content) == '') return $matches[0];
		
		// create hash
		$hash = '@@'.StringUtil::getHash(uniqid(microtime()).$content).'@@';
		
		// save
		$this->cachedStyles[$hash] = '<span class="cssHighlighter">'.CssHighlighter::getInstance()->highlight($content).'</span>';
		
		return $openingTag.$hash.$closingTag;
	}
	
	/**
	 * @see Highlighter::highlightComments()
	 */
	protected function highlightComments($string) {
		$string = parent::highlightComments($string);
		
		// highlight script and style blocks
		$string = $this->highlightStyles($string);
		$string = $this->highlightScripts($string);
		
		return $string;
	}
	
	protected function highlightScripts($string) {
		if (!empty($this->cachedScripts)) {
			foreach ($this->cachedScripts as $hash => $html) {
				$string = str_replace($hash, $html, $string);
			}
		}
		
		return $string;
	}
	
	protected function highlightStyles($string) {
		if (!empty($this->cachedStyles)) {
			foreach ($this->cachedStyles as $hash => $html) {
				$string = str_replace($hash, $html, $string);
			}
		}
		
		return $string;
	}
}
