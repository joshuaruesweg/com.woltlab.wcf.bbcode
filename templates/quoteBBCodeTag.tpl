<blockquote class="wcf-quoteBox"{if $quoteLink} cite="{$quoteLink}"{/if}>
	<header>
		<h1>
			<img src="{icon size='S'}quote{/icon}" alt="" />
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
	</header>
	<section>
		{@$content}
	</section>
</blockquote>
