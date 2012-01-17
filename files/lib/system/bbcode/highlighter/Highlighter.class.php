<?php
namespace wcf\system\bbcode\highlighter;
use \wcf\system\SingletonFactory;
use \wcf\system\WCF;
use \wcf\util\StringUtil;

/**
 * Highlights syntax of source code.
 * 
 * @author	Tim Düsterhus, Michael Schaefer
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode.highlighter
 * @category 	Community Framework
 */
abstract class Highlighter extends SingletonFactory {
	// highlighter syntax
	protected $quotes = array("'", "\"");
	protected $singleLineComment = array("//");
	protected $commentStart = array("/*");
	protected $commentEnd = array("*/");
	protected $escapeSequence = array("\\");
	protected $separators = array();
	protected $operators = array();
	protected $keywords1 = array(), $keywords2 = array(), $keywords3 = array(), $keywords4 = array(), $keywords5 = array();
	protected $allowsNewslinesInQuotes = false;
	
	// regular expressions
	protected $cacheCommentsRegEx = '';
	protected $quotesRegEx = '';
	protected $separatorsRegEx = '';
	
	// cache
	protected $cachedComments = array();
	protected $cachedQuotes = array();
	
	/**
	 * Creates a new Highlighter object.
	 */
	protected function init() {
		$this->buildRegularExpressions();
	}
	
	/**
	 * Returns the title of this highlighter.
	 *
	 * @return	string
	 */
	public function getTitle() {
		return WCF::getLanguage()->get('wcf.bbcode.code.'.preg_replace('/wcf\\\\system\\\\bbcode\\\\highlighter\\\\(.*)Highlighter/i', '\1', strtolower(get_class($this))).'.title');
	}
	
	/**
	 * Highlights syntax of source code.
	 * 
	 * @param	string		$string
	 * @return	string
	 */
	public function highlight($string) {
		$this->cachedComments = $this->cachedQuotes = array();

		// cache comments
		$string = $this->cacheComments($string);
		
		// cache quotes
		$string = $this->cacheQuotes($string);

		// encode html
		$string = StringUtil::encodeHTML($string);
		
		// do highlight
		$string = $this->highlightOperators($string);
		$string = $this->highlightKeywords($string);
		$string = $this->highlightNumbers($string);
		
		// insert and highlight quotes
		$string = $this->highlightQuotes($string);

		// insert and highlight comments
		$string = $this->highlightComments($string);

		return $string;
	}
	
	/**
	 * Builds regular expressions.
	 */
	protected function buildRegularExpressions() {
		// quotes regex
		$this->quotesRegEx;
		$quotedEscapeSequence = preg_quote(implode('', $this->escapeSequence));
		foreach ($this->quotes as $quote) {
			if (!empty($this->quotesRegEx)) $this->quotesRegEx .= '|';
			$quote = preg_quote($quote);
			$this->quotesRegEx .= $quote.'(?:[^'.$quote.$quotedEscapeSequence.']|'.$quotedEscapeSequence.'.)*'.$quote;
		}
		
		if (!empty($this->quotesRegEx)) {
			$this->quotesRegEx = '(?:'.$this->quotesRegEx.')';
		}
		
		// cache comment regex
		if (count($this->singleLineComment) || count($this->commentStart)) {
			$this->cacheCommentsRegEx = "!";
			
			if (count($this->quotes)) {
				$this->cacheCommentsRegEx .= "(".$this->quotesRegEx.")|";
			}
			else {
				$this->cacheCommentsRegEx .= "()";
			}
			
			$this->cacheCommentsRegEx .= "(";
			if (count($this->singleLineComment)) {
				$this->cacheCommentsRegEx .= "(?:".implode('|', array_map('preg_quote', $this->singleLineComment)).")[^\n]*";
				if (count($this->commentStart)) {
					$this->cacheCommentsRegEx .= '|';
				}
			}
			
			if (count($this->commentStart)) {
				$this->cacheCommentsRegEx .= '(?:'.implode('|', array_map('preg_quote', $this->commentStart)).').*?(?:'.implode('|', array_map('preg_quote', $this->commentEnd)).')';
			}
			$this->cacheCommentsRegEx .= ")!se";
		}
		
		$this->separatorsRegEx = StringUtil::encodeHTML(implode('|', array_map('preg_quote', $this->separators))).'|\s|&nbsp;|^|$|>|<';
	}

	/**
	 * Caches comments.
	 */
	protected function cacheComments($string) {
		if (!empty($this->cacheCommentsRegEx)) {
			$string = preg_replace($this->cacheCommentsRegEx, "\$this->cacheComment('\\1', '\\2')", $string);
		}
		
		return $string;
	}
	
	/**
	 * Caches quotes.
	 */
	protected function cacheQuotes($string) {
		if (!empty($this->quotesRegEx)) {
			$string = preg_replace('!'.$this->quotesRegEx.'!e'.($this->allowsNewslinesInQuotes ? 's' : ''), "\$this->cacheQuote('\\0')", $string);
		}
		
		return $string;
	}
	
	/**
	 * Highlights operators.
	 */
	protected function highlightOperators($string) {
		if (count($this->operators)) {
			$string = preg_replace('!('.StringUtil::encodeHTML(implode('|', array_map('preg_quote', $this->operators))).')!i', '<span class="operators">\\0</span>', $string);
		}
		
		return $string;
	}
	
	/**
	 * Highlights keywords.
	 */
	protected function highlightKeywords($string) {
		if (count($this->keywords1)) {
			$string = preg_replace('!(?<='.$this->separatorsRegEx.')('.StringUtil::encodeHTML(implode('|', array_map('preg_quote', $this->keywords1))).')(?='.$this->separatorsRegEx.')!i', '<span class="keywords1">\\0</span>', $string);
		}
		if (count($this->keywords2)) {
			$string = preg_replace('!(?<='.$this->separatorsRegEx.')('.StringUtil::encodeHTML(implode('|', array_map('preg_quote', $this->keywords2))).')(?='.$this->separatorsRegEx.')!i', '<span class="keywords2">\\0</span>', $string);
		}
		if (count($this->keywords3)) {
			$string = preg_replace('!(?<='.$this->separatorsRegEx.')('.StringUtil::encodeHTML(implode('|', array_map('preg_quote', $this->keywords3))).')(?='.$this->separatorsRegEx.')!i', '<span class="keywords3">\\0</span>', $string);
		}
		if (count($this->keywords4)) {
			$string = preg_replace('!(?<='.$this->separatorsRegEx.')('.StringUtil::encodeHTML(implode('|', array_map('preg_quote', $this->keywords4))).')(?='.$this->separatorsRegEx.')!i', '<span class="keywords4">\\0</span>', $string);
		}
		if (count($this->keywords5)) {
			$string = preg_replace('!(?<='.$this->separatorsRegEx.')('.StringUtil::encodeHTML(implode('|', array_map('preg_quote', $this->keywords5))).')(?='.$this->separatorsRegEx.')!i', '<span class="keywords5">\\0</span>', $string);
		}
		
		return $string;
	}
	
	/**
	 * Highlights numbers.
	 */
	protected function highlightNumbers($string) {
		$string = preg_replace('!(?<='.$this->separatorsRegEx.')(-?\d+)(?='.$this->separatorsRegEx.')!i', '<span class="numbers">\\0</span>', $string);
		
		return $string;
	}
	
	/**
	 * Highlights quotes.
	 */
	protected function highlightQuotes($string) {
		if (count($this->cachedQuotes)) {
			foreach ($this->cachedQuotes as $hash => $html) {
				$string = str_replace($hash, $html, $string);
			}
		}
		
		return $string;
	}
	
	/**
	 * Highlights comments.
	 */
	protected function highlightComments($string) {
		if (count($this->cachedComments)) {
			foreach ($this->cachedComments as $hash => $html) {
				$string = str_replace($hash, $html, $string);
			}
		}
		
		return $string;
	}
	
	/**
	 * Caches a source code comment.
	 */
	protected function cacheComment($string, $comment) {
		// strip slashes
		$string = str_replace("\\\"", "\"", $string);
		$hash = '';
		if (!empty($comment)) {
			$comment = str_replace("\\\"", "\"", $comment);
			
			// create hash
			$hash = '@@'.StringUtil::getHash(uniqid(microtime()).$comment).'@@';
			
			// save
			$this->cachedComments[$hash] = '<span class="comments">'.StringUtil::encodeHTML($comment).'</span>';
		}
			
		return $string.$hash;
	}
	
	/**
	 * Caches a quote.
	 */
	protected function cacheQuote($quote) {
		// strip slashes
		$quote = str_replace("\\\"", "\"", $quote);
		
		// create hash
		$hash = '@@'.StringUtil::getHash(uniqid(microtime()).$quote).'@@';
		
		// save
		$this->cachedQuotes[$hash] = '<span class="quotes">'.StringUtil::encodeHTML($quote).'</span>';
		
		return $hash;
	}
}
