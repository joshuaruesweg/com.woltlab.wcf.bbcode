{include file='header'}

<header class="mainHeading">
	<img src="{@RELATIVE_WCF_DIR}icon/{$action}1.svg" alt="" />
	<hgroup>
		<h1>{lang}wcf.acp.bbcode.videoprovider.{$action}{/lang}</h1>
		<h2>{lang}wcf.acp.bbcode.videoprovider.subtitle{/lang}</h2>
	</hgroup>
</header>

{if $errorField}
	<p class="error">{lang}wcf.global.form.error{/lang}</p>
{/if}

{if $success|isset}
	<p class="success">{lang}wcf.global.form.{$action}.success{/lang}</p>	
{/if}

<div class="contentHeader">
	<nav>
		<ul class="largeButtons">
			<li><a href="{link controller='BBCodeVideoProviderList'}{/link}" title="{lang}wcf.acp.menu.link.bbcode.videoprovider.list{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/bbcode1.svg" alt="" /> <span>{lang}wcf.acp.menu.link.bbcode.videoprovider.list{/lang}</span></a></li>
		</ul>
	</nav>
</div>

<form method="post" action="{if $action == 'add'}{link controller='BBCodeVideoProviderAdd'}{/link}{else}{link controller='BBCodeVideoProviderEdit'}{/link}{/if}">
	<div class="border content">
		<fieldset>
			<legend>{lang}wcf.acp.bbcode.videoprovider.data{/lang}</legend>
			
			<dl{if $errorField == 'regex'} class="formError"{/if}>
				<dt><label for="regex">{lang}wcf.acp.bbcode.videoprovider.regex{/lang}</label></dt>
				<dd>
					<textarea id="regex" name="regex" cols="40" rows="10" required="required">{$regex}</textarea>
					<small>{lang}wcf.acp.bbcode.videoprovider.regex.description{/lang}<br />
					Suggestion: Geben Sie hier das Link-Format als <a href="javascript:alert('Passender Link hier');">Regulären Ausdruck</a> an. Sie können mehrere Ausdrücke zeilenweise angeben.<br />
					Beispiele für Video-ID Erkennungen:
					<ul><li>(?&lt;ID&gt;[0-9]+) - Erkennt eine Video-ID aus Zahlen</li>
					<li>(?&lt;ID&gt;[0-9a-zA-Z]+) - Erkennt eine alphanumerische Video-ID</li></ul><br />
					Beachten Sie, dass eine fehlerhafte Angabe dazu führt, dass der Link nicht korrekt erkannt wird.</small>
					{if $errorField == 'regex'}
						<small class="innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{elseif $errorType == 'invalid'}
								{lang}wcf.acp.bbcode.videoprovider.error.regex.invalid{/lang}
							{/if}
						</small>
					{/if}
					<input id="url" />
					<pre id="validateResult">
					
					</pre>
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
							$('#url').change(checkRegex);
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
					<small>{lang}wcf.acp.bbcode.videoprovider.html.description{/lang}<br />
					Suggestion: Geben Sie hier den HTML-Code für das Video an. Variablen im Format {ldelim}$variable} werden durch die entsprechende Untergruppe des regulären Ausdrucks ersetzt.<br />
					Beispiel:<br />
					<ul><li>{ldelim}$ID} - Wird durch die Beispielhaften Video-IDs der Erklärung oberhalb ersetzt.</li></ul></small>
					{if $errorField == 'html'}
						<small class="innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{/if}
						</small>
					{/if}
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