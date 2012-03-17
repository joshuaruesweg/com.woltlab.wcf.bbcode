<div class="wcf-box wcf-boxTitle wcf-codeBox wcf-{$highlighter|get_class|substr:30|lcfirst} wcf-marginTop">
	<hgroup>
		<h1>{@$highlighter->getTitle()}{if $filename}: {@$filename}{/if}</h1>
	</hgroup>
	<div>
		<table class="wcf-table">
			<tbody>
				<tr>
					<td class="wcf-codeLineNumbers">
						<pre>
							{foreach from=$lineNumbers key=lineNumber item=lineID}
								<a href="{@$__wcf->getAnchor($lineID)}" id="{@$lineID}">{@$lineNumber}</a>
							{/foreach}
						</pre>
					</td>
					<td class="wcf-codeLines">
						<pre>{@$content}</pre>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
