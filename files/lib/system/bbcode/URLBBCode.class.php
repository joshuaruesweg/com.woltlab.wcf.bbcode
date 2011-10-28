<?php
namespace wcf\system\bbcode;
use wcf\util\ArrayUtil;
use wcf\util\StringUtil;

/**
 * Parses the [url] bbcode tag.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode
 * @category 	Community Framework
 */
class URLBBCode extends AbstractBBCode {
	/**
	 * page urls
	 * @var array<string>
	 */
	protected $pageURLs = null; 
	
	/**
	 * @see wcf\system\bbcode\IBBCode::getParsedTag()
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
			if (($newURL = $this->isInternalURL($url)) !== false) {
				$url = $newURL;
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
	
	/**
	 * Checks whether a URL is an internal URL.
	 * 
	 * @param	string		$url
	 * @return	mixed	
	 */
	protected function isInternalURL($url) {
		if ($this->pageURLs == null) {
			$this->pageURLs = $this->getPageURLs();
		}
		
		foreach ($this->pageURLs as $pageURL) {
			if (stripos($url, $pageURL) === 0) {
				return str_ireplace($pageURL.'/', '', $url);
			}
		}
		
		return false;
	}
	
	/**
	 * Gets the page URLs.
	 * 
	 * @return	array
	 */
	protected function getPageURLs() {
		$urlString = '';
		if (defined('PAGE_URL')) $urlString .= PAGE_URL;
		if (defined('PAGE_URLS')) $urlString .= "\n".PAGE_URLS;
		
		$urlString = StringUtil::unifyNewlines($urlString);
		return ArrayUtil::trim(explode("\n", $urlString));
	}
}
?>