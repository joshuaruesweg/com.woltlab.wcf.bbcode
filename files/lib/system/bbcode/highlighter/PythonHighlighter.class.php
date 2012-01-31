<?php
namespace wcf\system\bbcode\highlighter;

/**
 * Highlights syntax of Python sourcecode.
 *
 * @author	Tim Düsterhus
 * @copyright	2011 - 2012 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode.highlighter
 * @category 	Community Framework
 */
class PythonHighlighter extends Highlighter {
	// highlighter syntax
	protected $separators = array('(', ')',/* from __future__ import braces '{', '}', */'[', ']', ';', '.', ',', ':');
	protected $singleLineComment = array('#');
	protected $commentStart = array();
	protected $commentEnd = array();
	protected $operators = array('+=', '-=', '**=', '*=', '//=', '/=', '%=', '~=', '+', '-', '**', '*', '//', '/', '%', 
					'&=', '<<=', '>>=', '^=', '~', '&', '^', '|', '<<', '>>', '=', '!=', '<', '>', '<=', '>=');

	protected $keywords1 = array(
		'print',
		'del',
		'str',
		'len',
		'repr',
		'raise',
		'pass',
		'continue',
		'break',
		'return'
	);
	protected $keywords2 = array(
		'if',
		'elif',
		'else',
		'try',
		'except',
		'finally',
		'for',
		'in',
		'while'
	);

	protected $keywords3 = array(
		'from',
		'import',
		'as',
		'class',
		'def'
	);
	
	protected $keywords4 = array(
		'__name__',
		'__init__',
		'__str__',
		'__del__',
		'self',
		'True',
		'False',
		'None',
		'and',
		'or',
		'not',
		'is'
	);
}
