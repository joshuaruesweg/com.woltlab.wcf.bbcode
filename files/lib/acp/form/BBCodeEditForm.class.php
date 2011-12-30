<?php
namespace wcf\acp\form;
use wcf\data\bbcode\attribute\BBCodeAttribute;
use wcf\data\bbcode\attribute\BBCodeAttributeAction;
use wcf\data\bbcode\BBCode;
use wcf\data\bbcode\BBCodeAction;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

/**
 * Shows the bbcode edit form.
 * 
 * @author	Tim Düsterhus
 * @copyright	2011 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	acp.form
 * @category 	Community Framework
 */
class BBCodeEditForm extends BBCodeAddForm {
	/**
	 * @see wcf\acp\form\ACPForm::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.bbcode.list';
	
	/**
	 * @see wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.content.bbcode.canEditBBCode');
	
	/**
	 * bbcode id
	 * @var	integer
	 */
	public $bbcodeID = 0;
	
	/**
	 * bbcode object
	 * @var	wcf\data\bbcode\BBCode
	 */
	public $bbcodeObj = null;
	
	/**
	 * @see wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['id'])) $this->bbcodeID = intval($_REQUEST['id']);
		$this->bbcodeObj = new BBCode($this->bbcodeID);
		if (!$this->bbcodeObj->bbcodeID) {
			throw new IllegalLinkException();
		}
	}
	
	/**
	 * @see wcf\form\IForm::save()
	 */
	public function save() {
		ACPForm::save();
		
		// update bbcode
		$bbcodeAction = new BBCodeAction(array($this->bbcodeID), 'update', array('data' => array(
			'bbcodeTag' => $this->bbcodeTag,
			'htmlOpen' => $this->htmlOpen,
			'htmlClose' => $this->htmlClose,
			'textOpen' => $this->textOpen,
			'textClose' => $this->textClose,
			'allowedChildren' => $this->allowedChildren,
			'className' => $this->className
		)));
		$bbcodeAction->executeAction();
		
		// clear existing attributes
		$sql = "DELETE FROM	wcf".WCF_N."_bbcode_attribute
			WHERE		bbcodeID = ?";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($this->bbcodeID));
		
		foreach ($this->attributes as $attribute) {
			$attributeAction = new BBCodeAttributeAction(array(), 'create', array('data' => array(
				'bbcodeID' => $this->bbcodeID,
				'attributeNo' => $attribute->attributeNo,
				'attributeHtml' => $attribute->attributeHtml,
				'attributeText' => $attribute->attributeText,
				'validationPattern' => $attribute->validationPattern,
				'required' => $attribute->required,
				'useText' => $attribute->useText,
			)));
			$attributeAction->executeAction();
		}
		
		$this->saved();
		
		// show success
		WCF::getTPL()->assign(array(
			'success' => true
		));
	}
	
	/**
	 * @see wcf\page\IPage::readData()
	 */
	public function readData() {
		parent::readData();
		
		if (!count($_POST)) {
			$this->attributes = BBCodeAttribute::getAttributesByBBCode($this->bbcodeObj);
			$this->bbcodeTag = $this->bbcodeObj->bbcodeTag;
			$this->htmlOpen = $this->bbcodeObj->htmlOpen;
			$this->htmlClose = $this->bbcodeObj->htmlClose;
			$this->textOpen = $this->bbcodeObj->textOpen;
			$this->textClose = $this->bbcodeObj->textClose;
			$this->allowedChildren = $this->bbcodeObj->allowedChildren;
			$this->className = $this->bbcodeObj->className;
		}
	}
	
	/**
	 * @see wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'bbcodeID' => $this->bbcodeID,
			'action' => 'edit'
		));
	}
}
