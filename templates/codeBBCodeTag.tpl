<div class="container codeBox {$highlighter|get_class|substr:30|lcfirst}">
	<hgroup>
		<h1>{@$highlighter->getTitle()}{if $filename}: {@$filename}{/if}</h1>
	</hgroup>
	
	<dl>
		<dt><pre>{foreach from=$lineNumbers key=lineNumber item=lineID}<a href="{@$__wcf->getAnchor($lineID)}" id="{@$lineID}">{@$lineNumber}</a>{/foreach}</pre></dt>
		<dd><pre>{@$content}</pre></dd>
	</dl>
</div>
