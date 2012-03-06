<blockquote class="wcf-quoteBox wcf-box wcf-marginTop wcf-boxPadding"{if $quoteLink} cite="{$quoteLink}"{/if}>
	{if $quoteAuthor}
		<header>
			<h1>
				{if $quoteLink}
					<a href="{@$quoteLink}">{lang}wcf.bbcode.quote.title{/lang}</a>
				{else}
					{lang}wcf.bbcode.quote.title{/lang}
				{/if}
			</h1>
		</header>
	{/if}
	
	<div>
		{@$content}
	</div>
</blockquote>
