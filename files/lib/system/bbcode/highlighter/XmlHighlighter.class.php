<?php
namespace wcf\system\bbcode\highlighter;

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
		$string = preg_replace('~&lt;(?:/|\!|\?)?[a-z0-9]+(?:\s+[a-z0-9]+(?:=[^\s/\?&]+)?)*(?:/|\?)?&gt;~ie', "\$this->highlightTag('\\0')", $string);
		
		return $string;
	}
	
	/**
	 * Highlights an XML tag.
	 */
	protected function highlightTag($tag) {
		// highlight attributes
		$tag = preg_replace('~[a-z0-9]+(?:=[^\s/\?&]+)?(?=\s|&)~i', '<span class="keywords2">\\0</span>', $tag);
		
		// highlight tag
		return '<span class="keywords1">'.$tag.'</span>';
	}
}
