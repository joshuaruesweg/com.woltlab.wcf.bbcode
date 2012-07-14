<?php
namespace wcf\system\bbcode;
use wcf\data\bbcode\media\MediaProvider;
use wcf\util\StringUtil;

/**
 * Parses the [media] bbcode tag.
 * 
 * @author	Tim Düsterhus
 * @copyright	2011 - 2012 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode
 * @category 	Community Framework
 */
class MediaBBCode extends AbstractBBCode {
	/**
	 * @see	wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		if ($parser->getOutputType() == 'text/html') {
			$content = StringUtil::trim($content);
			$providers = MediaProvider::getCache();
			foreach ($providers as $provider) {
				if ($provider->matches($content)) {
					return $provider->getOutput($content);
				}
			}
		}
		
		return $content;
	}
}
