<?php
namespace wcf\acp\page;
use wcf\page\MultipleLinkPage;
use wcf\system\menu\acp\ACPMenu;

/**
 * Lists available smiley categories.
 * 
 * @author	Tim Düsterhus
 * @copyright	2011-2012 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	acp.page
 * @category 	Community Framework
 */
class SmileyCategoryListPage extends MultipleLinkPage {
	/**
	 * @see wcf\page\AbstractPage::$templateName
	 */
	public $templateName = 'smileyCategoryList';
	
	/**
	 * @see wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.content.smiley.canEditSmiley', 'admin.content.smiley.canDeleteSmiley');
	
	/**
	 * @see	wcf\page\MultipleLinkPage::$objectListClassName
	 */
	public $objectListClassName = 'wcf\data\smiley\category\SmileyCategoryList';
	
	/**
	 * @see	wcf\page\MultipleLinkPage::$sortField
	 */
	public $sortField = 'showOrder';
	
	/**
	 * @see	wcf\page\MultipleLinkPage::$sortOrder
	 */
	public $sortOrder = 'ASC';
	
	/**
	 * @see	wcf\page\MultipleLinkPage::countItems()
	 */
	public function countItems() {
		// take care of default category
		return parent::countItems() + 1;
	}
	
	/**
	 * @see	wcf\page\MultipleLinkPage::readObjects()
	 */
	protected function readObjects() {
		// take care of default category
		if ($this->pageNo == 1) $this->sqlLimit--;
		$this->sqlOffset--;
		
		return parent::readObjects();
	}
	
	/**
	 * @see wcf\page\IPage::show()
	 */
	public function show() {
		// set active menu item.
		ACPMenu::getInstance()->setActiveMenuItem('wcf.acp.menu.link.smiley.category.list');
		
		parent::show();
	}
}
