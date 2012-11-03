<?php
namespace wcf\system\bbcode;
use wcf\system\WCF;

/**
 * Parses the [quote] bbcode tag.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode
 * @category	Community Framework
 */
class QuoteBBCode extends AbstractBBCode {
	/**
	 * @see	wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		if ($parser->getOutputType() == 'text/html') {
			WCF::getTPL()->assign(array(
				'content' => $content,
				'quoteLink' => (!empty($openingTag['attributes'][1]) ? $openingTag['attributes'][1] : ''),
				'quoteAuthor' => (!empty($openingTag['attributes'][0]) ? $openingTag['attributes'][0] : '')
			));
			return WCF::getTPL()->fetch('quoteBBCodeTag', array(), false);
		}
		else if ($parser->getOutputType() == 'text/plain') {
			$cite = '';
			if (!empty($openingTag['attributes'][0])) $cite = WCF::getLanguage()->getDynamicVariable('wcf.bbcode.quote.cite.text', array('name' => $openingTag['attributes'][0]));
			
			return WCF::getLanguage()->getDynamicVariable('wcf.bbcode.quote.text', array('content' => $content, 'cite' => $cite));
		}
	}
}
