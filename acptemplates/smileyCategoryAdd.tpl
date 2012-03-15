{include file='header'}

<header class="wcf-mainHeading wcf-container">
	<img src="{@$__wcf->getPath('wcf')}icon/{$action}1.svg" alt="" class="wcf-containerIcon" />
	<hgroup class="wcf-containerContent">
		<h1>{lang}wcf.acp.smiley.category.{$action}{/lang}</h1>
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
		<ul class="wcf-largeButtons">
			<li><a href="{link controller='SmileyCategoryList'}{/link}" title="{lang}wcf.acp.menu.link.smiley.category.list{/lang}" class="wcf-button"><img src="{@$__wcf->getPath('wcf')}icon/smiley1.svg" alt="" /> <span>{lang}wcf.acp.menu.link.smiley.category.list{/lang}</span></a></li>
		</ul>
	</nav>
</div>

<form method="post" action="{if $action == 'add'}{link controller='SmileyCategoryAdd'}{/link}{else}{link controller='SmileyCategoryEdit'}{/link}{/if}">
	<div class="wcf-box wcf-marginTop wcf-boxPadding wcf-shadow1">
		<fieldset>
			<legend>{lang}wcf.acp.smiley.category.data{/lang}</legend>
			
			<dl{if $errorField == 'title'} class="wcf-formError"{/if}>
				<dt><label for="title">{lang}wcf.acp.smiley.category.title{/lang}</label></dt>
				<dd>
					<input type="text" id="title" name="title" value="{$title}" autofocus="autofocus" class="long" />
					{if $errorField == 'title'}
						<small class="wcf-innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{else}
								{lang}wcf.acp.smiley.category.title.error.{@$errorType}{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
			
			{include file='multipleLanguageInputJavascript' elementIdentifier='title'}
		</fieldset>
	</div>
	
	<div class="wcf-formSubmit">
		<input type="reset" value="{lang}wcf.global.button.reset{/lang}" accesskey="r" />
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{@SID_INPUT_TAG}
 		{if $categoryID|isset}<input type="hidden" name="id" value="{@$categoryID}" />{/if}
	</div>
</form>

{include file='footer'}