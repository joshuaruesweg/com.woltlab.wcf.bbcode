<?php
namespace wcf\acp\form;
use \wcf\data\smiley\category\SmileyCategory;
use \wcf\data\smiley\category\SmileyCategoryAction;
use \wcf\system\exception\IllegalLinkException;
use \wcf\system\language\I18nHandler;
use \wcf\system\package\PackageDependencyHandler;
use \wcf\system\WCF;

/**
 * Shows the smiley category edit form.
 *
 * @author	Tim Düsterhus
 * @copyright	2011-2012 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	acp.form
 * @category 	Community Framework
 */
class SmileyCategoryEditForm extends SmileyCategoryAddForm {
	/**
	 * @see	\wcf\page\AbstractPage::$templateName
	 */
	public $templateName = 'smileyCategoryAdd';
	
	/**
	 * @see	\wcf\acp\form\ACPForm::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.smiley.category.list';
	
	/**
	 * @see	\wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.content.smiley.canEditSmiley');
	
	/**
	 * room id
	 * 
	 * @var	integer
	 */
	public $categoryID = 0;
	
	/**
	 * room object
	 * 
	 * @var	\wcf\data\smiley\category\SmileyCategory
	 */
	public $categoryObj = null;
	
	/**
	 * @see	\wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['id'])) $this->categoryID = intval($_REQUEST['id']);
		$this->categoryObj = new SmileyCategory($this->categoryID);
		if (!$this->categoryObj->smileyCategoryID) {
			throw new IllegalLinkException();
		}
	}
	
	/**
	 * @see	\wcf\form\IForm::save()
	 */
	public function save() {
		ACPForm::save();
		$packageID = PackageDependencyHandler::getInstance()->getPackageID('com.woltlab.wcf.bbcode');
		
		$this->title = 'wcf.smiley.category.title'.$this->categoryObj->smileyCategoryID;
		if (I18nHandler::getInstance()->isPlainValue('title')) {
			I18nHandler::getInstance()->remove($this->title, $packageID);
			$this->title = I18nHandler::getInstance()->getValue('title');
		}
		else {
			I18nHandler::getInstance()->save('title', $this->title, 'wcf.smiley.category', $packageID);
		}
		
		// update category
		$this->objectAction = new SmileyCategoryAction(array($this->categoryID), 'update', array('data' => array(
			'title' => $this->title,
		)));
		$this->objectAction->executeAction();
		
		$this->saved();
		
		// show success
		WCF::getTPL()->assign(array(
			'success' => true
		));
	}
	
	/**
	 * @see	\wcf\page\IPage::readData()
	 */
	public function readData() {
		parent::readData();
		
		$packageID = PackageDependencyHandler::getInstance()->getPackageID('com.woltlab.wcf.bbcode');
		if (!count($_POST)) {
			I18nHandler::getInstance()->setOptions('title', $packageID, $this->categoryObj->title, 'wcf.smiley.category.title\d+');
			
			$this->title = $this->categoryObj->title;
		}
	}
	
	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		I18nHandler::getInstance()->assignVariables((bool) count($_POST));
		
		WCF::getTPL()->assign(array(
			'categoryID' => $this->categoryID,
			'action' => 'edit'
		));
	}
}