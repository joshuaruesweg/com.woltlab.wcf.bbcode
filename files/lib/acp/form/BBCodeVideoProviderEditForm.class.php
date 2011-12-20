<?php
namespace wcf\acp\form;
use wcf\data\bbcode\video\VideoProvider;
use wcf\data\bbcode\video\VideoProviderAction;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

/**
 * Shows the label edit form.
 * 
 * @author	Tim Düsterhus
 * @copyright	2011 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	acp.form
 * @category 	Community Framework
 */
class BBCodeVideoProviderEditForm extends BBCodeVideoProviderAddForm {
	/**
	 * @see wcf\acp\form\ACPForm::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.bbcode.videoprovider.list';
	
	/**
	 * @see wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.content.bbcode.videoprovider.canEditVideoProvider');
	
	/**
	 * video-provider id
	 * @var	integer
	 */
	public $providerID = 0;
	
	/**
	 * video-provider object
	 * @var	wcf\data\bbcode\video\VideoProvider
	 */
	public $videoProviderObj = null;
	
	/**
	 * @see wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['id'])) $this->providerID = intval($_REQUEST['id']);
		$this->videoProviderObj = new VideoProvider($this->providerID);
		if (!$this->videoProviderObj->providerID) {
			throw new IllegalLinkException();
		}
	}
	
	/**
	 * @see wcf\form\IForm::save()
	 */
	public function save() {
		ACPForm::save();
		
		// update video-provider
		$videoProviderAction = new VideoProviderAction(array($this->providerID), 'update', array('data' => array(
			'regex' => $this->regex,
			'html' => $this->html
		)));
		$videoProviderAction->executeAction();
		
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
			$this->regex = $this->videoProviderObj->regex;
			$this->html = $this->videoProviderObj->html;
		}
	}
	
	/**
	 * @see wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'providerID' => $this->providerID,
			'action' => 'edit'
		));
	}
}
