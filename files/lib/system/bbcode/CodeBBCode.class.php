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
	 * Keeps track of used code-ids to prevent duplicate IDs in Output
	 * 
	 * @var	array<string>
	 */
	private static $codeIDs = array();

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
				$className = '\wcf\system\bbcode\highlighter\\'.StringUtil::firstCharToUpperCase(StringUtil::toLowerCase($openingTag['attributes'][0])).'Highlighter';
				
				switch (StringUtil::substring($className, strlen('\wcf\system\bbcode\highlighter\\'))) {
					case 'C++Highlighter':
						$className = '\wcf\system\bbcode\highlighter\CHighlighter';
					break;
					case 'JavascriptHighlighter':
						$className = '\wcf\system\bbcode\highlighter\JsHighlighter';
					break;
				}
			}
			else {
				// try to guess highlighter
				if (StringUtil::indexOf($content, '<?php') !== false) {
					$className = '\wcf\system\bbcode\highlighter\PhpHighlighter';
				}
				else if (StringUtil::indexOf($content, '<html') !== false) {
					$className = '\wcf\system\bbcode\highlighter\HtmlHighlighter';
				}
				else if (StringUtil::indexOf($content, '<?xml') === 0) {
					$className = '\wcf\system\bbcode\highlighter\XmlHighlighter';
				}
				else if (	StringUtil::indexOf($content, 'SELECT') === 0
					||	StringUtil::indexOf($content, 'UPDATE') === 0
					||	StringUtil::indexOf($content, 'INSERT') === 0
					||	StringUtil::indexOf($content, 'DELETE') === 0) {
					$className = '\wcf\system\bbcode\highlighter\SqlHighlighter';
				}
				else if (StringUtil::indexOf($content, 'import java.') !== false) {
					$className = '\wcf\system\bbcode\highlighter\JavaHighlighter';
				}
				else if (	StringUtil::indexOf($content, "---") !== false 
					&&	StringUtil::indexOf($content, "\n+++") !== false) {
					$className = '\wcf\system\bbcode\highlighter\DiffHighlighter';
				}
				else if (StringUtil::indexOf($content, "\n#include ") !== false) {
					$className = '\wcf\system\bbcode\highlighter\CHighlighter';
				}
				else if (StringUtil::indexOf($content, '#!/usr/bin/perl') === 0) {
					$className = '\wcf\system\bbcode\highlighter\PerlHighlighter';
				}
				else if (StringUtil::indexOf($content, 'def __init__(self') !== false) {
					$className = '\wcf\system\bbcode\highlighter\PythonHighlighter';
				}
			}
			
			if (!class_exists($className)) {
				$className = '\wcf\system\bbcode\highlighter\PlainHighlighter';
			}
			
			// show template
			WCF::getTPL()->assign(array(
				'lineNumbers' => self::makeLineNumbers($content, self::getLineNumbersStart($openingTag)),
				'content' => $className::getInstance()->highlight($content),
				'highlighter' => $className::getInstance()
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
		
		$lineNumbers = array();
		$i = -1;
		// find an unused codeID
		do {
			$codeID = StringUtil::substring(StringUtil::getHash($code), 0, 6).(++$i ? '_'.$i : '');
		}
		while(isset(self::$codeIDs[$codeID]));
		// mark codeID as used
		self::$codeIDs[$codeID] = true;
		
		for ($i = $start, $j = count($lines) + $start; $i < $j; $i++) {
			$lineNumbers[$i] = 'codeLine_'.$i.'_'.$codeID;
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
