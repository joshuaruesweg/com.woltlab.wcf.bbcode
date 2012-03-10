<?php
namespace wcf\system\bbcode\highlighter;

/**
 * Highlights syntax of Bash-Scripts.
 *
 * @author	Tim Düsterhus
 * @copyright	2011 - 2012 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode.highlighter
 * @category 	Community Framework
 */
class BashHighlighter extends Highlighter {
	// highlighter syntax
	protected $separators = array(';', '=');
	protected $quotes = array('"', "'", '`');
	protected $singleLineComment = array('#');
	protected $commentStart = array();
	protected $commentEnd = array();
	protected $operators = array('||', '&&', '&', '|', '<<=', '>>=', '<<', '+=', '-=', '*=', '/=', '%=',
					'-gt', '-lt', '-n', '-a', '-o',
					'+', '-', '*', '/', '%', '<', '?', ':', '==', '!=', '=', '!', '>', '2>', '>>');
	
	protected $keywords1 = array(
		'true',
		'false'
	);
	
	protected $keywords2 = array(
		'if',
		'then',
		'else',
		'fi',
		'for',
		'until',
		'while',
		'do',
		'done',
		'case',
		'in',
		'esac'
	);
	
	protected $keywords3 = array(
		'echo',
		'exit',
		'unset',
		'read',
		'[', ']', 'test',
		'let',
		'sed',
		'grep',
		'awk'
	);
	
	protected $keywords4 = array(
		'$?'
	);
}
