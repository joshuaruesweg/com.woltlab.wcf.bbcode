<?php
namespace wcf\system\bbcode;
use wcf\data\bbcode\video\VideoProvider;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Parses the [video] bbcode tag.
 * 
 * @author	Tim Düsterhus
 * @copyright	2011 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode
 * @category 	Community Framework
 */
class VideoBBCode extends AbstractBBCode {
	/**
	 * @see	wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		if ($parser->getOutputType() == 'text/html') {	
			$content = StringUtil::trim($content);
			$providers = VideoProvider::getCache();
			foreach ($providers as $provider) {
				if ($provider->matches($content)) {
					return $provider->getOutput($content);
				}
			}
			
			return '';
		}
		else if ($parser->getOutputType() == 'text/plain') {
			return WCF::getLanguage()->getDynamicVariable('wcf.bbcode.code.text', array('content' => $content));
		}
	}
}
