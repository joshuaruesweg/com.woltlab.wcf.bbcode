<?php
namespace wcf\system\bbcode;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Parses the [code] bbcode tag.
 * 
 * @author	Tim Düsterhus, Marcel Werk
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode
 * @category 	Community Framework
 */
class CodeBBCode extends AbstractBBCode {
	/**
	 * @see	wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		if ($parser->getOutputType() == 'text/html') {	
			// encode html
			$content = self::trim($content);
			
			// fetch highlighter-classname
			$className = '\wcf\system\bbcode\highlighter\PlainHighlighter';
			if (!empty($openingTag['attributes'][0]) && !is_numeric($openingTag['attributes'][0])) {
				$className = '\wcf\system\bbcode\highlighter\\'.StringUtil::firstCharToUpperCase($openingTag['attributes'][0]).'Highlighter';
				if ($className == '\wcf\system\bbcode\highlighter\C++Highlighter') $className = '\wcf\system\bbcode\highlighter\CHighlighter';
			}
			else {
				// try to guess highlighter
				if (StringUtil::indexOf($content, '<?php') !== false) $className = '\wcf\system\bbcode\highlighter\PhpHighlighter';
				else if (StringUtil::indexOf($content, '<html') !== false) $className = '\wcf\system\bbcode\highlighter\HtmlHighlighter';
				else if (StringUtil::indexOf($content, '<?xml') === 0) $className = '\wcf\system\bbcode\highlighter\XmlHighlighter';
				else if (StringUtil::indexOf($content, 'SELECT') === 0) $className = '\wcf\system\bbcode\highlighter\SqlHighlighter';
				else if (StringUtil::indexOf($content, 'UPDATE') === 0) $className = '\wcf\system\bbcode\highlighter\SqlHighlighter';
				else if (StringUtil::indexOf($content, 'INSERT') === 0) $className = '\wcf\system\bbcode\highlighter\SqlHighlighter';
				else if (StringUtil::indexOf($content, 'DELETE') === 0) $className = '\wcf\system\bbcode\highlighter\SqlHighlighter';
			}
			
			if (!class_exists($className)) {
				$className = '\wcf\system\bbcode\highlighter\PlainHighlighter';
				// TODO: Language-item, or remove?
				$content = "// Highlighter not found\n".$content;
			}
			
			// show template
			WCF::getTPL()->assign(array(
				'lineNumbers' => self::makeLineNumbers($content, self::getLineNumbersStart($openingTag)),
				'content' => $className::getInstance()->highlight($content),
				'codeBoxName' => $className::getInstance()->getTitle()
			));
			return WCF::getTPL()->fetch('codeBBCodeTag', array(), false);
		}
		else if ($parser->getOutputType() == 'text/plain') {
			return WCF::getLanguage()->getDynamicVariable('wcf.bbcode.code.text', array('content' => $content));
		}
	}
	
	/**
	 * Returns the preferred start of the line numbers.
	 * 
	 * @param	array		$openingTag
	 * @return	integer
	 */
	protected static function getLineNumbersStart(array $openingTag) {
		$start = 1;
		if (!empty($openingTag['attributes'][0])) {
			if (is_numeric($openingTag['attributes'][0])) {
				$start = intval($openingTag['attributes'][0]);
			}
			else if (!empty($openingTag['attributes'][1])) {
				$start = intval($openingTag['attributes'][1]);
			}
		}
		
		if ($start < 1) $start = 1;
		
		return $start;
	}
	
	/**
	 * Returns a string with all line numbers
	 * 
	 * @param	string		$code
	 * @param	integer		$start
	 * @return	string
	 */
	protected static function makeLineNumbers($code, $start, $split = "\n") {
		$lines = explode($split, $code);	
		
		$lineNumbers = '';
		for ($i = 0, $j = count($lines); $i < $j; $i++) {
			$lineNumbers .= ($i + $start) . "\n";
		}
		return $lineNumbers;	
	}
	
	/**
	 * Removes empty lines from the beginning and end of a string.
	 * 
	 * @param	string		$string
	 * @return	string
	 */
	protected static function trim($string) {
		$string = preg_replace('/^\s*\n/', '', $string);
		$string = preg_replace('/\n\s*$/', '', $string);
		return $string;
	}
}
