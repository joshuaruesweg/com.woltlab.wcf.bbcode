<?php
namespace wcf\system\bbcode;
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
			if (preg_match('~^https?://(?:.+\.)?youtu(?:\.be/|be\.com/watch\?(?:.*)v=)([a-zA-Z0-9_-]+?)~', $content, $matches)) {
				// matches *.youtube.com/watch?[...]v=ID
				// matches youtu.be/ID
				$provider = 'youtube';
				$videoID = $matches[1];
			}
			else if (preg_match('~^http://www\.myvideo.de/watch/(\d+)/~', $content, $matches)) {
				// matches www.myvideo.de/watch/ID/title
				$provider = 'myvideo';
				$videoID = $matches[1];
			}
			else if (preg_match('~^http://www\.clipfish.de/.*/(\d+)/.+/~', $content, $matches)) {
				// matches www.clipfish.de/category/ID/title
				$provider = 'clipfish';
				$videoID = $matches[1];
			}
			else if (preg_match('~^http://vimeo.com/(\d+)', $content, $matches)) {
				// matches vimeo.com/ID
				$provider = 'vimeo';
				$videoID = $matches[1];
			}
			else if (preg_match('^~http://www\.veoh.com/watch/v([a-zA-Z0-9]+)', $content, $matches)) {
				// matches www.veoh.com/watch/vID
				$provider = 'veoh';
				$videoID = $matches[1];
			}
			
			
			// show template
			WCF::getTPL()->assign(array(
				'videoID' => $videoID,
				'provider' => $provider
			));
			return WCF::getTPL()->fetch('videoBBCodeTag', array(), false);
		}
		else if ($parser->getOutputType() == 'text/plain') {
			return WCF::getLanguage()->getDynamicVariable('wcf.bbcode.code.text', array('content' => $content));
		}
	}
}
