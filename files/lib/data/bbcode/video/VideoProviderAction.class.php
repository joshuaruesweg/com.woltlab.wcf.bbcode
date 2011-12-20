<?php
namespace wcf\data\bbcode\video;
use wcf\data\AbstractDatabaseObjectAction;

/**
 * Executes video-provider-related actions.
 * 
 * @author	Tim Düsterhus
 * @copyright	2011 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.bbcode.video
 * @category 	Community Framework
 */
class VideoProviderAction extends AbstractDatabaseObjectAction {
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'wcf\data\bbcode\video\VideoProviderEditor';
	
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$permissionsDelete
	 */
	protected $permissionsDelete = array('admin.content.bbcode.videoprovider.canDeleteVideoProvider');
}
