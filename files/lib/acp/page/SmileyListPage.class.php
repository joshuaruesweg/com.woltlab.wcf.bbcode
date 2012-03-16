<?php
namespace wcf\acp\page;
use wcf\data\smiley\category\SmileyCategory;
use wcf\data\smiley\category\SmileyCategoryList;
use wcf\page\MultipleLinkPage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\menu\acp\ACPMenu;
use wcf\system\WCF;

/**
 * Lists available smileys.
 * 
 * @author	Tim Düsterhus
 * @copyright	2011-2012 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	acp.page
 * @category 	Community Framework
 */
class SmileyListPage extends MultipleLinkPage {
	/**
	 * @see wcf\page\AbstractPage::$templateName
	 */
	public $templateName = 'smileyList';
	
	/**
	 * @see wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.content.smiley.canEditSmiley', 'admin.content.smiley.canDeleteSmiley');
	
	/**
	 * @see	wcf\page\MultipleLinkPage::$objectListClassName
	 */
	public $objectListClassName = 'wcf\data\smiley\SmileyList';
	
	/**
	 * @see	wcf\page\MultipleLinkPage::$sortField
	 */
	public $sortField = 'showOrder';
	
	/**
	 * @see	wcf\page\MultipleLinkPage::$sortOrder
	 */
	public $sortOrder = 'ASC';
	
	/**
	 * category id
	 * @var	integer
	 */
	public $categoryID = null;
	
	/**
	 * categories
	 * @var wcf\data\smiley\category\SmileyCategoryList
	 */
	public $categories = null;
	
	/**
	 * @see wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['id'])) {
			$this->categoryID = intval($_REQUEST['id']);
			$categoryObj = new SmileyCategory($this->categoryID);
			if (!$categoryObj->smileyCategoryID) {
				throw new IllegalLinkException();
			}
		}
	}
	
	/**
	 * @see wcf\page\IPage::readData()
	 */
	public function readData() {
		parent::readData();
		
		$this->categories = new SmileyCategoryList();
		$this->categories->sqlLimit = 0;
		$this->categories->readObjects();
	}
	
	/**
	 * @see wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'categories' => $this->categories
		));
	}
	
	/**
	 * @see wcf\page\MultipleLinkPage::initObjectList()
	 */
	protected function initObjectList() {
		parent::initObjectList();
		
		if ($this->categoryID) {
			$this->objectList->getConditionBuilder()->add('smileyCategoryID = ?', array($this->categoryID));
		}
		else {
			$this->objectList->getConditionBuilder()->add('smileyCategoryID IS NULL', array());
		}
	}
	
	/**
	 * @see wcf\page\IPage::show()
	 */
	public function show() {
		// set active menu item.
		ACPMenu::getInstance()->setActiveMenuItem('wcf.acp.menu.link.smiley.list');
		
		parent::show();
	}
}
