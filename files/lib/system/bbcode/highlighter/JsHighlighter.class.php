<?php
namespace wcf\system\bbcode\highlighter;

/**
 * Highlights syntax of JavaScript Source-Code
 * 
 * @author	Tim Düsterhus, Michael Schaefer
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode.highlighter
 * @category	Community Framework
 */
class JsHighlighter extends Highlighter {
	// highlighter syntax
	protected $separators = array("(", ")", "{", "}", "[", "]", ";", ".", ",");
	protected $operators = array("=", ">", "<", "!", "~", "?", ":", "==", "<=", ">=", "!=",
		"&&", "||", "++", "--", "+", "-", "*", "/", "&", "|", "^", "%", "<<", ">>", ">>>", "+=", "-=", "*=",
		"/=", "&=", "|=", "^=", "%=", "<<=", ">>=", ">>>=");
	
	protected $keywords1 = array(
		"String",
		"Array",
		"RegExp",
		"Function",
		"Math",
		"Number",
		"Date",
		"Image",
		"window",
		"document",
		"navigator",
		"onAbort",
		"onBlur",
		"onChange",
		"onClick",
		"onDblClick",
		"onDragDrop",
		"onError",
		"onFocus",
		"onKeyDown",
		"onKeyPress",
		"onKeyUp",
		"onLoad",
		"onMouseDown",
		"onMouseOver",
		"onMouseOut",
		"onMouseMove",
		"onMouseUp",
		"onMove",
		"onReset",
		"onResize",
		"onSelect",
		"onSubmit",
		"onUnload"
	);
	protected $keywords2 = array(
		"break",
		"continue",
		"do",
		"while",
		"export",
		"for",
		"in",
		"if",
		"else",
		"import",
		"return",
		"label",
		"switch",
		"case",
		"var",
		"with",
		"delete",
		"new",
		"this",
		"typeof",
		"void",
		"abstract",
		"boolean",
		"byte",
		"catch",
		"char",
		"class",
		"const",
		"debugger",
		"default",
		"double",
		"enum",
		"extends",
		"false",
		"final",
		"finally",
		"float",
		"function",
		"implements",
		"goto",
		"instanceof",
		"int",
		"interface",
		"long",
		"native",
		"null",
		"package",
		"private",
		"protected",
		"public",
		"short",
		"static",
		"super",
		"synchronized",
		"throw",
		"throws",
		"transient",
		"true",
		"try",
		"volatile"
	);
}
