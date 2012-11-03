<?php
namespace wcf\system\bbcode\highlighter;
use \wcf\util\StringUtil;

/**
 * Does no highlighting.
 * 
 * @author	Tim Düsterhus
 * @copyright	2011 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode.highlighter
 * @category	Community Framework
 */
class PlainHighlighter extends Highlighter {
	public function highlight($code) {
		return StringUtil::encodeHTML($code);
	}
}
