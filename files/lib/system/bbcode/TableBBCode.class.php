<?php
namespace wcf\system\bbcode;
use wcf\system\Regex;
use wcf\util\StringUtil;

/**
 * Parses the [table] bbcode tag.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2012 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode
 * @category 	Community Framework
 */
class TableBBCode extends AbstractBBCode {
	/**
	 * @see	wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		if ($parser->getOutputType() == 'text/html') {
			$parsedContent = Regex::compile('(?:\s|<br />)*(\[tr\].*\[/tr\])(?:\s|<br />)*', Regex::CASE_INSENSITIVE | Regex::DOT_ALL)->replace($content, '\\1');
			
			// check syntax
			$regex = new Regex("^(\[tr\](?:\s|<br />)*(\[td\].*?\[/td\](?:\s|<br />)*)+\[/tr\](?:\s|<br />)*)+$", Regex::CASE_INSENSITIVE | Regex::DOT_ALL);
			if ($regex->match($parsedContent)) {
				// tr
				$parsedContent = Regex::compile('\[tr\](?:\s|<br />)*', Regex::CASE_INSENSITIVE)->replace($parsedContent, '<tr>');
				// td
				$parsedContent = StringUtil::replaceIgnoreCase('[td]', '<td>', $parsedContent);
				// /td
				$parsedContent = Regex::compile('\[/td\](?:\s|<br />)*', Regex::CASE_INSENSITIVE)->replace($parsedContent, '</td>');
				// /tr
				$parsedContent = Regex::compile('\[/tr\](?:\s|<br />)*', Regex::CASE_INSENSITIVE)->replace($parsedContent, '</tr>');
				
				return '<div class="container bbcodeTable"><table class="table"><tbody>'.$parsedContent.'</tbody></table></div>';
			}
		}
		
		// return bbcode as text
		return $openingTag['source'].$content.$closingTag['source'];
	}
}
