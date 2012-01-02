<?php
namespace wcf\acp\form;
use wcf\data\bbcode\video\VideoProviderAction;
use wcf\system\exception\SystemException;
use wcf\system\exception\UserInputException;
use wcf\system\Regex;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Shows the video-provider add form.
 *
 * @author	Tim Düsterhus
 * @copyright	2011 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	acp.form
 * @category 	Community Framework
 */
class BBCodeVideoProviderAddForm extends ACPForm {
	/**
	 * @see wcf\page\AbstractPage::$templateName
	 */
	public $templateName = 'bbcodeVideoProviderAdd';
	
	/**
	 * @see wcf\acp\form\ACPForm::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.bbcode.videoprovider.add';
	
	/**
	 * @see wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.content.bbcode.videoprovider.canAddVideoProvider');
	
	/**
	 * title value
	 * @var	string
	 */
	public $title = '';
	 
	/**
	 * regex value
	 * @var	string
	 */
	public $regex = '';
	
	/**
	 * html value
	 * @var	string
	 */
	public $html = '';
	
	/**
	 * @see wcf\form\IForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['title'])) $this->title = StringUtil::trim($_POST['title']);
		if (isset($_POST['regex'])) $this->regex = StringUtil::trim($_POST['regex']);
		if (isset($_POST['html'])) $this->html = StringUtil::trim($_POST['html']);
	}
	
	/**
	 * @see wcf\form\IForm::validate()
	 */
	public function validate() {
		parent::validate();
		
		// validate fields
		if (empty($this->title)) {
			throw new UserInputException('title');
		}
		if (empty($this->regex)) {
			throw new UserInputException('regex');
		}
		if (empty($this->html)) {
			throw new UserInputException('html');
		}
		
		$lines = explode("\n", StringUtil::unifyNewlines($this->regex));
	
		foreach ($lines as $line) {
			if (!Regex::compile($line)->isValid()) throw new UserInputException('regex', 'invalid');
		}
	}
	
	/**
	 * @see wcf\form\IForm::save()
	 */
	public function save() {
		parent::save();
		
		// save video provider
		$videoProviderAction = new VideoProviderAction(array(), 'create', array('data' => array(
			'title' => $this->title,
			'regex' => $this->regex,
			'html' => $this->html
		)));
		$videoProviderAction->executeAction();
		$this->saved();
		
		// reset values
		$this->title = $this->regex = $this->html = '';
		
		// show success
		WCF::getTPL()->assign(array(
			'success' => true
		));
	}
	
	/**
	 * @see wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'action' => 'add',
			'title' => $this->title,
			'regex' => $this->regex,
			'html' => $this->html
		));
	}
}
