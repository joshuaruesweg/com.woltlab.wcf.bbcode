{include file='header'}

<header class="boxHeadline">
	<hgroup>
		<h1>{lang}wcf.acp.bbcode.mediaprovider.{$action}{/lang}</h1>
	</hgroup>
</header>

{if $errorField}
	<p class="error">{lang}wcf.global.form.error{/lang}</p>
{/if}

{if $success|isset}
	<p class="success">{lang}wcf.global.form.{$action}.success{/lang}</p>	
{/if}

<div class="contentNavigation">
	<nav>
		<ul>
			<li><a href="{link controller='BBCodeMediaProviderList'}{/link}" title="{lang}wcf.acp.menu.link.bbcode.mediaprovider.list{/lang}" class="button"><img src="{@$__wcf->getPath()}icon/list.svg" alt="" class="icon24" /> <span>{lang}wcf.acp.menu.link.bbcode.mediaprovider.list{/lang}</span></a></li>
		</ul>
	</nav>
</div>

<form method="post" action="{if $action == 'add'}{link controller='BBCodeMediaProviderAdd'}{/link}{else}{link controller='BBCodeMediaProviderEdit'}{/link}{/if}">
	<div class="container containerPadding marginTop shadow">
		<fieldset>
			<legend>{lang}wcf.acp.bbcode.mediaprovider.data{/lang}</legend>
			
			<dl{if $errorField == 'title'} class="formError"{/if}>
				<dt><label for="title">{lang}wcf.acp.bbcode.mediaprovider.title{/lang}</label></dt>
				<dd>
					<input type="text" id="title" name="title" value="{$title}" required="required" autofocus="autofocus" class="long" />
					{if $errorField == 'title'}
						<small class="innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
			
			<dl{if $errorField == 'regex'} class="formError"{/if}>
				<dt><label for="regex">{lang}wcf.acp.bbcode.mediaprovider.regex{/lang}</label></dt>
				<dd>
					<textarea id="regex" name="regex" cols="40" rows="10" required="required">{$regex}</textarea>
					{if $errorField == 'regex'}
						<small class="innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{elseif $errorType == 'invalid'}
								{lang}wcf.acp.bbcode.mediaprovider.error.regex.invalid{/lang}
							{/if}
						</small>
					{/if}
					<small>{lang}wcf.acp.bbcode.mediaprovider.regex.description{/lang}</small>
					<input type="url" id="url" class="long" />
					<pre id="validateResult"></pre>
					<script type="text/javascript">
					// <![CDATA[
						(function ($) {
							function checkRegex() {
								$.ajax('{link controller='BBCodeMediaProviderValidateRegex'}{/link}', {
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
							$('#url').keydown(checkRegex).keyup(checkRegex).keypress(checkRegex);
							
							$('#regex').change(checkRegex);
						})(jQuery);
					// ]]>
					</script>
				</dd>
			</dl>
			
			<dl{if $errorField == 'html'} class="formError"{/if}>
				<dt><label for="html">{lang}wcf.acp.bbcode.mediaprovider.html{/lang}</label></dt>
				<dd>
					<textarea id="html" name="html" cols="40" rows="10" required="required">{$html}</textarea>
					{if $errorField == 'html'}
						<small class="innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{/if}
						</small>
					{/if}
					<small>{lang}wcf.acp.bbcode.mediaprovider.html.description{/lang}</small>
				</dd>
			</dl>
		</fieldset>
	</div>
	
	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{if $providerID|isset}<input type="hidden" name="id" value="{@$providerID}" />{/if}
	</div>
</form>

{include file='footer'}