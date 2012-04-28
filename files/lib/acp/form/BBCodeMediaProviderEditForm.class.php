<?php
namespace wcf\acp\form;
use wcf\data\bbcode\media\MediaProvider;
use wcf\data\bbcode\media\MediaProviderAction;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

/**
 * Shows the media-provider edit form.
 * 
 * @author	Tim Düsterhus
 * @copyright	2011 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	acp.form
 * @category 	Community Framework
 */
class BBCodeMediaProviderEditForm extends BBCodeMediaProviderAddForm {
	/**
	 * @see wcf\acp\form\ACPForm::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.bbcode.mediaprovider.list';
	
	/**
	 * @see wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.content.bbcode.mediaprovider.canEditMediaProvider');
	
	/**
	 * media-provider id
	 * @var	integer
	 */
	public $providerID = 0;
	
	/**
	 * media-provider object
	 * @var	wcf\data\bbcode\media\MediaProvider
	 */
	public $mediaProviderObj = null;
	
	/**
	 * @see wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['id'])) $this->providerID = intval($_REQUEST['id']);
		$this->mediaProviderObj = new MediaProvider($this->providerID);
		if (!$this->mediaProviderObj->providerID) {
			throw new IllegalLinkException();
		}
	}
	
	/**
	 * @see wcf\form\IForm::save()
	 */
	public function save() {
		ACPForm::save();
		
		// update media-provider
		$this->objectAction = new MediaProviderAction(array($this->providerID), 'update', array('data' => array(
			'title' => $this->title,
			'regex' => $this->regex,
			'html' => $this->html
		)));
		$this->objectAction->executeAction();
		
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
			$this->title = $this->mediaProviderObj->title;
			$this->regex = $this->mediaProviderObj->regex;
			$this->html = $this->mediaProviderObj->html;
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
