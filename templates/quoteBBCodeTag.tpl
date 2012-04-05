<blockquote class="quoteBox container"{if $quoteLink} cite="{$quoteLink}"{/if}>
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
	{else}
		<header class="invisible">
			<h1>
				{lang}wcf.bbcode.quote{/lang}
			</h1>
		</header>
	{/if}
	
	<div>
		{@$content}
	</div>
</blockquote>