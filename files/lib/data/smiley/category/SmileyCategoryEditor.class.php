<?php
namespace wcf\data\smiley\category;
use wcf\data\DatabaseObjectEditor;

/**
 * Provides functions to edit smiley categories.
 *
 * @author	Alexander Ebert
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.smiley.category
 * @category	Community Framework
 */
class SmileyCategoryEditor extends DatabaseObjectEditor {
	/**
	 * @see	wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	public static $baseClass = 'wcf\data\smiley\category\SmileyCategory';
}
