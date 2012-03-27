<?php
namespace wcf\system\bbcode\highlighter;
use \wcf\system\Callback;
use \wcf\system\Regex;

/**
 * Highlights syntax of xml sourcecode.
 * 
 * @author	Tim Düsterhus, Michael Schaefer
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode.highlighter
 * @category 	Community Framework
 */
class XmlHighlighter extends Highlighter {
	// highlighter syntax
	protected $allowsNewslinesInQuotes = true;
	protected $quotes = array('"');
	protected $singleLineComment = array();
	protected $commentStart = array("<!--");
	protected $commentEnd = array("-->");
	protected $separators = array("<", ">");
	protected $operators = array();
	const XML_ATTRIBUTE_NAME = '[a-z0-9](?:(?<!-)[a-z0-9-]?[a-z0-9]+)*';
	
	/**
	 * @see	Highlighter::highlightKeywords()
	 */
	protected function highlightKeywords($string) {
		$string = parent::highlightKeywords($string);
		
		// find tags
		$regex = new Regex('&lt;(?:/|\!|\?)?[a-z0-9]+(?:\s+'.self::XML_ATTRIBUTE_NAME.'(?:=[^\s/\?&]+)?)*(?:\s+/|\?)?&gt;', Regex::CASE_INSENSITIVE);
		$string = $regex->replace($string, new Callback(function ($matches) {
			// highlight attributes
			$tag = Regex::compile(XmlHighlighter::XML_ATTRIBUTE_NAME.'(?:=[^\s/\?&]+)?(?=\s|&)', Regex::CASE_INSENSITIVE)->replace($matches[0], '<span class="hlKeywords2">\\0</span>');
			
			// highlight tag
			return '<span class="hlKeywords1">'.$tag.'</span>';
		}));
		
		return $string;
	}
	
	/**
	 * Highlight CDATA-Tags as quotes.
	 *
	 * @see	Highlighter::cacheQuotes()
	 */
	protected function cacheQuotes($string) {
		$string = Regex::compile('<!\[CDATA\[.*?\]\]>', Regex::DOT_ALL)->replace($string, new Callback(array($this, 'cacheQuote')));
		
		$string = parent::cacheQuotes($string);
		
		return $string;
	}
}
