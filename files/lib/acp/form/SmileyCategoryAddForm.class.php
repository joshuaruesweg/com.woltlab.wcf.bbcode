<?php
namespace wcf\acp\form;
use \wcf\data\smiley\category\SmileyCategoryAction;
use \wcf\data\smiley\category\SmileyCategoryEditor;
use \wcf\system\exception\UserInputException;
use \wcf\system\language\I18nHandler;
use \wcf\system\package\PackageDependencyHandler;
use \wcf\system\WCF;

// TODO: Add Field for sorting as Drag'n'drop does not work over multiple pages

/**
 * Shows the smileycategory add form.
 *
 * @author	Tim Düsterhus
 * @copyright	2011-2012 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	acp.form
 * @category 	Community Framework
 */
class SmileyCategoryAddForm extends ACPForm {
	/**
	 * @see	\wcf\acp\form\ACPForm::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.smiley.category.add';
	
	/**
	 * @see	\wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.content.smiley.canAddSmiley');
	
	/**
	 * Title of the room
	 * 
	 * @var	string
	 */
	public $title = '';
	
	/**
	 * @see	\wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		I18nHandler::getInstance()->register('title');
	}
	
	/**
	 * @see	\wcf\form\IForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		I18nHandler::getInstance()->readValues();
		
		if (I18nHandler::getInstance()->isPlainValue('title')) $this->title = I18nHandler::getInstance()->getValue('title');
	}
	
	/**
	 * @see	\wcf\form\IForm::validate()
	 */
	public function validate() {
		parent::validate();
		
		// validate title
		if (!I18nHandler::getInstance()->validateValue('title')) {
			throw new UserInputException('title');
		}
	}
	
	/**
	 * @see	\wcf\form\IForm::save()
	 */
	public function save() {
		parent::save();

		// save category
		$this->objectAction = new SmileyCategoryAction(array(), 'create', array('data' => array(
			'title' => $this->title,
		)));
		$this->objectAction->executeAction();
		$returnValues = $this->objectAction->getReturnValues();
		$categoryEditor = new SmileyCategoryEditor($returnValues['returnValues']);
		$categoryID = $returnValues['returnValues']->smileyCategoryID;
		
		if (!I18nHandler::getInstance()->isPlainValue('title')) {
			I18nHandler::getInstance()->save('title', 'wcf.smiley.category.title'.$categoryID, 'wcf.smiley.category', PackageDependencyHandler::getInstance()->getPackageID('com.woltlab.wcf.bbcode'));
		
			// update title
			$categoryEditor->update(array(
				'title' => 'wcf.smiley.category.title'.$categoryID
			));
		}
		
		$this->saved();
		
		// reset values
		$this->title = '';
		I18nHandler::getInstance()->disableAssignValueVariables();
		
		// show success
		WCF::getTPL()->assign(array(
			'success' => true
		));
	}
	
	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		I18nHandler::getInstance()->assignVariables();
		
		WCF::getTPL()->assign(array(
			'action' => 'add',
			'title' => $this->title
		));
	}
}
