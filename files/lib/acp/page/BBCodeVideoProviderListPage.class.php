<?php
namespace wcf\acp\page;
use wcf\page\MultipleLinkPage;
use wcf\system\menu\acp\ACPMenu;

/**
 * Lists available video-providers
 * 
 * @author	Tim Düsterhus
 * @copyright	2011 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	acp.page
 * @category 	Community Framework
 */
class BBCodeVideoProviderListPage extends MultipleLinkPage {
	/**
	 * @see wcf\page\AbstractPage::$templateName
	 */
	public $templateName = 'bbcodeVideoProviderList';
	
	/**
	 * @see wcf\page\AbstractPage::$neededPermissions
	 */
	//public $neededPermissions = array('admin.content.bbcode.videoprovider.canEditVideoProvider', 'admin.content.bbcode.videoprovider.canDeleteVideoProvider');
	
	/**
	 * @see	wcf\page\MultipleLinkPage::$objectListClassName
	 */
	public $objectListClassName = 'wcf\data\bbcode\video\VideoProviderList';
	
	/**
	 * @see wcf\page\IPage::show()
	 */
	public function show() {
		// set active menu item.
		ACPMenu::getInstance()->setActiveMenuItem('wcf.acp.menu.link.bbcode.videoprovider.list');
		
		parent::show();
	}
}
