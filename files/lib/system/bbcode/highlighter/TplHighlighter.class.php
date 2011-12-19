<?php
namespace wcf\system\bbcode\highlighter;

/**
 * Highlights syntax of template documents with smarty-syntax.
 * 
 * @author	Tim Düsterhus, Michael Schaefer
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode.highlighter
 * @category 	Community Framework
 */
class TplHighlighter extends HtmlHighlighter {
	/**
	 * @see	Highlighter::highlightComments()
	 */
	protected function highlightComments($string) {
		$string = parent::highlightComments($string);
		
		// highlight template tags
		$string = preg_replace('~\{(?=\S).+?(?<=\S)\}~s', '<span style="'.$this->style['keywords3'].'">\\0</span>', $string);
		
		return $string;
	}
}
