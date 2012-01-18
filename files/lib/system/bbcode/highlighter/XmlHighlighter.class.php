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
	protected $quotes = array("'", "\"");
	protected $singleLineComment = array();
	protected $commentStart = array("<!--");
	protected $commentEnd = array("-->");
	protected $separators = array("<", ">");
	protected $operators = array();
	
	/**
	 * @see	Highlighter::highlightKeywords()
	 */
	protected function highlightKeywords($string) {
		$string = parent::highlightKeywords($string);
		
		// find tags
		$regex = new Regex('&lt;(?:/|\!|\?)?[a-z0-9]+(?:\s+[a-z0-9]+(?:=[^\s/\?&]+)?)*(?:/|\?)?&gt;', Regex::CASE_INSENSITIVE);
		$string = $regex->replace($string, new Callback(function ($matches) {
			// highlight attributes
			$tag = Regex::compile('[a-z0-9]+(?:=[^\s/\?&]+)?(?=\s|&)', Regex::CASE_INSENSITIVE)->replace($matches[0], '<span class="keywords2">\\0</span>');
			
			// highlight tag
			return '<span class="keywords1">'.$tag.'</span>';
		}));
		
		return $string;
	}
}
