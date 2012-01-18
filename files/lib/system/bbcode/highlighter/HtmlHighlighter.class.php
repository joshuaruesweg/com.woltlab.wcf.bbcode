<?php
namespace wcf\system\bbcode\highlighter;
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
		$string = preg_replace('!(<script[^>]*>)(.*?)(</script>)!sie', "\$this->cacheScript('\\2', '\\1', '\\3')", $string);
		
		return $string;
	}
	
	protected function cacheStyles($string) {
		$string = preg_replace('!(<style[^>]*>)(.*?)(</style>)!sie', "\$this->cacheStyle('\\2', '\\1', '\\3')", $string);
		
		return $string;
	}
	
	/**
	 * Caches a script block.
	 */
	protected function cacheScript($content, $openingTag, $closingTag) {
		// strip slashes
		$content = str_replace("\\\"", "\"", $content);
		$openingTag = str_replace("\\\"", "\"", $openingTag);
		$closingTag = str_replace("\\\"", "\"", $closingTag);
		
		// create hash
		$hash = '@@'.StringUtil::getHash(uniqid(microtime()).$content).'@@';
		
		// save
		$this->cachedScripts[$hash] = '<span class="JsHighlighter">'.JsHighlighter::getInstance()->highlight($content).'</span>';
		
		return $openingTag.$hash.$closingTag;
	}
	
	/**
	 * Caches a style block.
	 */
	protected function cacheStyle($content, $openingTag, $closingTag) {
		// strip slashes
		$content = str_replace("\\\"", "\"", $content);
		$openingTag = str_replace("\\\"", "\"", $openingTag);
		$closingTag = str_replace("\\\"", "\"", $closingTag);
		
		// create hash
		$hash = '@@'.StringUtil::getHash(uniqid(microtime()).$content).'@@';
		
		// save
		$this->cachedStyles[$hash] = '<span class="CssHighlighter">'.CssHighlighter::getInstance()->highlight($content).'</span>';
		
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
		if (count($this->cachedScripts)) {
			foreach ($this->cachedScripts as $hash => $html) {
				$string = str_replace($hash, $html, $string);
			}
		}
	
		return $string;
	}
	
	protected function highlightStyles($string) {
		if (count($this->cachedStyles)) {
			foreach ($this->cachedStyles as $hash => $html) {
				$string = str_replace($hash, $html, $string);
			}
		}
		
		return $string;
	}
}
