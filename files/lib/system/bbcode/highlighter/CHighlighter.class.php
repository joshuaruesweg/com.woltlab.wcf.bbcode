<?php
namespace wcf\system\bbcode\highlighter;
use wcf\util\StringUtil;

/**
 * Highlights syntax of c / c++ source code.
 * 
 * @author	Tim Düsterhus, Michael Schaefer
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode.highlighter
 * @category 	Community Framework
 */
class CHighlighter extends Highlighter {
	// highlighter syntax
	protected $separators = array('(', ')', '{', '}', '[', ']', ';', '.', ',');
	protected $operators = array('=', '>', '<', '!', '~', '?', ':', '==', '<=', '>=', '!=',
		'&&', '||', '++', '--', '+', '-', '*', '/', '&', '|', '^', '%', '<<', '>>', '>>>', '+=', '-=', '*=',
		'/=', '&=', '|=', '^=', '%=', '<<=', '>>=', '>>>=');
	
	protected $keywords1 = array(
		'and',
		'and_eq',
		'asm',
		'bitand',
		'bitor',
		'break',
		'case',
		'catch',
		'compl',
		'const_cast',
		'continue',
		'default',
		'delete',
		'do',
		'dynamic_cast',
		'else',
		'for',
		'fortran',
		'friend',
		'goto',
		'if',
		'new',
		'not',
		'not_eq',
		'operator',
		'or',
		'or_eq',
		'private',
		'protected',
		'public',
		'reinterpret_cast',
		'return',
		'sizeof',
		'static_cast',
		'switch',
		'this',
		'throw',
		'try',
		'typeid',
		'using',
		'while',
		'xor',
		'xor_eq'
	);
	protected $keywords2 = array(
		'auto',
		'bool',
		'char',
		'class',
		'const',
		'double',
		'enum',
		'explicit',
		'export',
		'extern',
		'float',
		'inline',
		'int',
		'long',
		'mutable',
		'namespace',
		'register',
		'short',
		'signed',
		'static',
		'struct',
		'template',
		'typedef',
		'typename',
		'union',
		'unsigned',
		'virtual',
		'void',
		'volatile',
		'wchar_t'
	);
	
	protected $keywords3 = array(
		'#include',
		'#define',
		'#if',
		'#else',
		'#ifdef',
		'#endif'
	);
}
