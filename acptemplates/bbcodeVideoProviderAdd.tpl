{include file='header'}

<header class="wcf-mainHeading">
	<img src="{@RELATIVE_WCF_DIR}icon/{$action}1.svg" alt="" />
	<hgroup>
		<h1>{lang}wcf.acp.bbcode.videoprovider.{$action}{/lang}</h1>
	</hgroup>
</header>

{if $errorField}
	<p class="wcf-error">{lang}wcf.global.form.error{/lang}</p>
{/if}

{if $success|isset}
	<p class="wcf-success">{lang}wcf.global.form.{$action}.success{/lang}</p>	
{/if}

<div class="wcf-contentHeader">
	<nav>
		<ul class="largeButtons">
			<li><a href="{link controller='BBCodeVideoProviderList'}{/link}" title="{lang}wcf.acp.menu.link.bbcode.videoprovider.list{/lang}" class="button"><img src="{@RELATIVE_WCF_DIR}icon/videoProvider1.svg" alt="" /> <span>{lang}wcf.acp.menu.link.bbcode.videoprovider.list{/lang}</span></a></li>
		</ul>
	</nav>
</div>

<form method="post" action="{if $action == 'add'}{link controller='BBCodeVideoProviderAdd'}{/link}{else}{link controller='BBCodeVideoProviderEdit'}{/link}{/if}">
	<div class="wcf-border wcf-content">
		<fieldset>
			<legend>{lang}wcf.acp.bbcode.videoprovider.data{/lang}</legend>
			
			<dl{if $errorField == 'title'} class="formError"{/if}>
				<dt><label for="title">{lang}wcf.acp.bbcode.videoprovider.title{/lang}</label></dt>
				<dd>
					<input type="text" id="title" name="title" value="{$title}" required="required" autofocus="autofocus" class="long" />
					{if $errorField == 'title'}
						<small class="wcf-innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
			
			<dl{if $errorField == 'regex'} class="formError"{/if}>
				<dt><label for="regex">{lang}wcf.acp.bbcode.videoprovider.regex{/lang}</label></dt>
				<dd>
					<textarea id="regex" name="regex" cols="40" rows="10" required="required">{$regex}</textarea>
					{if $errorField == 'regex'}
						<small class="wcf-innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{elseif $errorType == 'invalid'}
								{lang}wcf.acp.bbcode.videoprovider.error.regex.invalid{/lang}
							{/if}
						</small>
					{/if}
					<small>{lang}wcf.acp.bbcode.videoprovider.regex.description{/lang}</small>
					<input type="url" id="url" class="long" />
					<pre id="validateResult"></pre>
					<script type="text/javascript">
					// <![CDATA[
						(function ($) {
							function checkRegex() {
								$.ajax('{link controller='BBCodeVideoProviderValidateRegex'}{/link}', {
									dataType: 'json',
									type: 'POST',
									data: {
										regex: $('#regex').val(),
										url: $('#url').val()
									},
									success: function (data) {
										var result = '';
										for (item in data) {
											result += item + ': '+data[item]+"\n";
										}
										$('#validateResult').text(result);
									}
								});
							}
							$('#url').keydown(checkRegex);
							$('#url').keyup(checkRegex);
							$('#url').keypress(checkRegex);
							
							$('#regex').change(checkRegex);
						})(jQuery);
					// ]]>
					</script>
				</dd>
			</dl>
			
			<dl{if $errorField == 'html'} class="formError"{/if}>
				<dt><label for="html">{lang}wcf.acp.bbcode.videoprovider.html{/lang}</label></dt>
				<dd>
					<textarea id="html" name="html" cols="40" rows="10" required="required">{$html}</textarea>
					{if $errorField == 'html'}
						<small class="wcf-innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{/if}
						</small>
					{/if}
					<small>{lang}wcf.acp.bbcode.videoprovider.html.description{/lang}</small>
				</dd>
			</dl>
		</fieldset>
	</div>
	
	<div class="formSubmit">
		<input type="reset" value="{lang}wcf.global.button.reset{/lang}" accesskey="r" />
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{@SID_INPUT_TAG}
 		{if $providerID|isset}<input type="hidden" name="id" value="{@$providerID}" />{/if}
	</div>
</form>

{include file='footer'}