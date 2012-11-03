<?php
namespace wcf\system\bbcode;
use wcf\system\application\ApplicationHandler;
use wcf\util\StringUtil;

/**
 * Parses the [url] bbcode tag.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode
 * @category	Community Framework
 */
class URLBBCode extends AbstractBBCode {
	/**
	 * page urls
	 * @var	array<string>
	 */
	protected $pageURLs = null; 
	
	/**
	 * @see	wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		$url = '';
		if (isset($openingTag['attributes'][0])) {
			$url = $openingTag['attributes'][0];
		}
		
		$noTitle = ($content == $url);
		
		// add protocol if necessary
		if (!preg_match("/[a-z]:\/\//si", $url)) $url = 'http://'.$url;
		
		if ($parser->getOutputType() == 'text/html') {
			$external = true;
			if (ApplicationHandler::getInstance()->isInternalURL($url)) {
				$external = false;
			}
			
			// cut visible url
			if ($noTitle) {
				$decodedContent = StringUtil::decodeHTML($content);
				if (StringUtil::length($decodedContent) > 60) {
					$content = StringUtil::encodeHTML(StringUtil::substring($decodedContent, 0, 40)) . '&hellip;' . StringUtil::encodeHTML(StringUtil::substring($decodedContent, -15));
				}
			}
			else {
				$content = StringUtil::trim($content);
			}
			
			return '<a href="'.$url.'"'.($external ? ' class="externalURL"' : '').'>'.$content.'</a>';
		}
		else if ($parser->getOutputType() == 'text/plain') {
			if ($noTitle) {
				return $url;
			}
			
			return $content.': '.$url;
		}
	}
}
?>