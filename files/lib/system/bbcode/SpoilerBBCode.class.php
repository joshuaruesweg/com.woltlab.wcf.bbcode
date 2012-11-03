<?php
namespace wcf\system\bbcode;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Parses the [spoiler] bbcode tag.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2012 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode
 * @category	Community Framework
 */
class SpoilerBBCode extends AbstractBBCode {
	/**
	 * @see	wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		if ($parser->getOutputType() == 'text/html') {
			WCF::getTPL()->assign(array(
				'content' => $content,
				'buttonTitle' => (!empty($openingTag['attributes'][0]) ? $openingTag['attributes'][0] : ''),
				'spoilerID' => 'spoiler_'.StringUtil::getRandomID()
			));
			return WCF::getTPL()->fetch('spoilerBBCodeTag', array(), false);
		}
		else if ($parser->getOutputType() == 'text/plain') {
			return $content;
		}
	}
}
