<?php
namespace wcf\system\bbcode\highlighter;
use \wcf\util\StringUtil;

/**
 * Highlights syntax of PHP sourcecode.
 * 
 * @author	Tim Düsterhus, Marcel Werk
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode.highlighter
 * @category 	Community Framework
 */
class PhpHighlighter extends Highlighter { 
	public function highlight($code) {
		// add starting php tag
		$phpTagsAdded = false;
		if (StringUtil::indexOf($code, '<?') === false) {
			$phpTagsAdded = true;
			$content = '<?php '.$code.' ?>';
		}
		
		// do highlight
		$highlightedCode = highlight_string($code, true);
		
		// clear code
		$highlightedCode = str_replace('<code>', '', $highlightedCode);
		$highlightedCode = str_replace('</code>', '', $highlightedCode);
		
		// remove added php tags
		if ($phpTagsAdded) {
			$highlightedCode = preg_replace("/([^\\2]*)(&lt;\?php&nbsp;)(.*)(&nbsp;.*\?&gt;)([^\\4]*)/si", "\\1\\3\\5", $highlightedCode);
		}
		
		// remove breaks
		$highlightedCode = str_replace("\n", "", $highlightedCode);
		$highlightedCode = str_replace('<br />', "\n", $highlightedCode);
		// get tabs back
		$highlightedCode = str_replace('&nbsp;&nbsp;&nbsp;&nbsp;', "\t", $highlightedCode);
		
		// replace double quotes by entity 
		return preg_replace('/(?<!\<span style=)"(?!\>)/', '&quot;', $highlightedCode);
	}
}
