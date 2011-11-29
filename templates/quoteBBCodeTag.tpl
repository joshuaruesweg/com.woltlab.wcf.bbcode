<blockquote class="quoteBox"{if $quoteLink} cite="{$quoteLink}"{/if}>
	<div class="quoteHeader">
		<h1>
			<img src="{icon size='S'}quote1{/icon}" alt="" />
			{if $quoteAuthor}
				{if $quoteLink}
					<a href="{@$quoteLink}">{lang}wcf.bbcode.quote.title{/lang}</a>
				{else}
					{lang}wcf.bbcode.quote.title{/lang}
				{/if}
			{else}
				{lang}wcf.bbcode.quote.title{/lang}
			{/if}
		</h1>
	</div>
	<div class="quoteBody">
		{@$content}
	</div>
</blockquote>
