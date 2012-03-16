<?php
namespace wcf\data\smiley\category;
use wcf\data\DatabaseObjectList;

/**
 * Represents a list of smiley categories.
 * 
 * @author	Alexander Ebert
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.smiley.category
 * @category 	Community Framework
 */
class SmileyCategoryList extends DatabaseObjectList {
	/**
	 * @see	wcf\data\DatabaseObjectList::$className
	 */
	public $className = 'wcf\data\smiley\category\SmileyCategory';
	
	/**
	 * @see wcf\data\DatabaseObjectList::__construct()
	 */
	public function __construct() {
		parent::__construct();
		$this->sqlSelects .= '(SELECT COUNT(*) FROM wcf'.WCF_N.'_smiley WHERE smileyCategoryID = smiley_category.smileyCategoryID) AS smileyCount';
	}
}
