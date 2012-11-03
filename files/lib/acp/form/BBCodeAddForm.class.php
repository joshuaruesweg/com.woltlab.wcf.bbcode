<?php
namespace wcf\acp\form;
use wcf\data\bbcode\attribute\BBCodeAttributeAction;
use wcf\data\bbcode\BBCode;
use wcf\data\bbcode\BBCodeAction;
use wcf\system\exception\UserInputException;
use wcf\system\package\PackageDependencyHandler;
use wcf\system\Regex;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Shows the bbcode add form.
 *
 * @author	Tim Düsterhus
 * @copyright	2011 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	acp.form
 * @category	Community Framework
 */
class BBCodeAddForm extends ACPForm {
	/**
	 * @see	wcf\page\AbstractPage::$templateName
	 */
	public $templateName = 'bbcodeAdd';
	
	/**
	 * @see	wcf\acp\form\ACPForm::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.bbcode.add';
	
	/**
	 * @see	wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.content.bbcode.canAddBBCode');
	
	/**
	 * bbcode-tag value
	 * @var	string
	 */
	public $bbcodeTag = '';
	
	/**
	 * html-open value
	 * @var	string
	 */
	public $htmlOpen = '';
	
	/**
	 * html-Close value
	 * @var	string
	 */
	public $htmlClose = '';
	
	/**
	 * text-open value
	 * @var	string
	 */
	public $textOpen = '';
	
	/**
	 * text-close value
	 * @var	string
	 */
	public $textClose = '';
	
	/**
	 * allowed-children value
	 * @var	string
	 */
	public $allowedChildren = 'all';
	
	/**
	 * is-source-code value
	 * @var	boolean
	 */
	public $isSourceCode = false;
	
	/**
	 * class-name value
	 * @var	string
	 */
	public $className = '';
	
	/**
	 * Attributes
	 * @var	array<object>
	 */
	public $attributes = array();
	
	/**
	 * @see	wcf\form\IForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['bbcodeTag'])) $this->bbcodeTag = StringUtil::trim($_POST['bbcodeTag']);
		if (isset($_POST['htmlOpen'])) $this->htmlOpen = StringUtil::trim($_POST['htmlOpen']);
		if (isset($_POST['htmlClose'])) $this->htmlClose = StringUtil::trim($_POST['htmlClose']);
		if (isset($_POST['textOpen'])) $this->textOpen = StringUtil::trim($_POST['textOpen']);
		if (isset($_POST['textClose'])) $this->textClose = StringUtil::trim($_POST['textClose']);
		if (isset($_POST['allowedChildren'])) $this->allowedChildren = StringUtil::trim($_POST['allowedChildren']);
		if (isset($_POST['isSourceCode'])) $this->isSourceCode = true;
		if (isset($_POST['className'])) $this->className = StringUtil::trim($_POST['className']);
		if (isset($_POST['attributes'])) $this->attributes = $_POST['attributes'];
		
		$attributeNo = 0;
		foreach ($this->attributes as $key => $val) {
			$val['attributeNo'] = $attributeNo++;
			$val['required'] = (int) isset($val['required']);
			$val['useText'] = (int) isset($val['useText']);
			$this->attributes[$key] = (object) $val;
		}
	}
	
	/**
	 * @see	wcf\form\IForm::validate()
	 */
	public function validate() {
		parent::validate();
		
		// validate fields
		// Tag must not be empty
		if (empty($this->bbcodeTag)) {
			throw new UserInputException('bbcodeTag');
		}
		
		// Tag may only contain alphanumeric chars
		if (!Regex::compile('^[a-z0-9]+$', Regex::CASE_INSENSITIVE)->match($this->bbcodeTag)) {
			throw new UserInputException('bbcodeTag', 'invalid');
		}
		
		// Disallow the Pseudo-BBCodes all and none
		if ($this->bbcodeTag == 'all' || $this->bbcodeTag == 'none') {
			throw new UserInputException('bbcodeTag', 'invalid');
		}
		
		// Check whether the tag is in use
		$bbcode = BBCode::getBBCodeByTag($this->bbcodeTag);
		if ((!isset($this->bbcodeObj) && $bbcode->bbcodeID) || (isset($this->bbcodeObj) && $bbcode->bbcodeID != $this->bbcodeObj->bbcodeID)) {
			throw new UserInputException('bbcodeTag', 'inUse');
		}
		
		// Handle empty case first
		if (empty($this->allowedChildren)) {
			throw new UserInputException('allowedChildren');
		}
		
		// Validate syntax of allowedChildren: Optional all|none^ followed by a comma-separated list of bbcodes
		if (!empty($this->allowedChildren) && !Regex::compile('^(?:(?:all|none)\^)?(?:[a-zA-Z0-9]+,)*[a-zA-Z0-9]+$')->match($this->allowedChildren)) {
			throw new UserInputException('allowedChildren', 'invalid');
		}
		
		// Validate class
		if (!empty($this->className) && !class_exists($this->className)) {
			throw new UserInputException('className', 'notFound');
		}
		
		// Validate attributes
		foreach ($this->attributes as $attribute) {
			// Check whether the pattern is a valid regex
			if (!Regex::compile($attribute->validationPattern)->isValid()) {
				throw new UserInputException('attributeValidationPattern'.$attribute->attributeNo, 'invalid');
			}
		}
	}
	
	/**
	 * @see	wcf\form\IForm::save()
	 */
	public function save() {
		parent::save();
		
		// save bbcode
		$this->objectAction = new BBCodeAction(array(), 'create', array('data' => array(
			'bbcodeTag' => $this->bbcodeTag,
			'htmlOpen' => $this->htmlOpen,
			'htmlClose' => $this->htmlClose,
			'textOpen' => $this->textOpen,
			'textClose' => $this->textClose,
			'allowedChildren' => $this->allowedChildren,
			'isSourceCode' => (int) $this->isSourceCode,
			'className' => $this->className,
			'packageID' => PackageDependencyHandler::getInstance()->getPackageID('com.woltlab.wcf.bbcode')
		)));
		$returnValues = $this->objectAction->executeAction();
		foreach ($this->attributes as $attribute) {
			$attributeAction = new BBCodeAttributeAction(array(), 'create', array('data' => array(
				'bbcodeID' => $returnValues['returnValues']->bbcodeID,
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
		
		// reset values
		$this->bbcodeTag = $this->htmlOpen = $this->htmlClose = $this->textOpen = $this->textClose = $this->className = '';
		$this->allowedChildren = 'all';
		$this->attributes = array();
		
		// show success
		WCF::getTPL()->assign(array(
			'success' => true
		));
	}
	
	/**
	 * @see	wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'action' => 'add',
			'bbcodeTag' => $this->bbcodeTag,
			'htmlOpen' => $this->htmlOpen,
			'htmlClose' => $this->htmlClose,
			'textOpen' => $this->textOpen,
			'textClose' => $this->textClose,
			'allowedChildren' => $this->allowedChildren,
			'isSourceCode' => $this->isSourceCode,
			'className' => $this->className,
			'attributes' => $this->attributes
		));
	}
}
