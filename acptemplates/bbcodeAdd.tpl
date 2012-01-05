{include file='header'}
{capture assign='attributeTemplate'}
	<fieldset><legend>{lang}wcf.acp.bbcode.attribute{/lang} {ldelim}#$attributeNo} <img src="{@RELATIVE_WCF_DIR}icon/delete1.svg" alt="" class="deleteButton" /></legend>
		<dl>
			<dt><label for="attributeHtml[{ldelim}@$attributeNo}]">{lang}wcf.acp.bbcode.attribute.attributeHtml{/lang}</label></dt>
			<dd>
				<input type="text" id="attributes[{ldelim}@$attributeNo}][attributeHtml]" name="attributes[{ldelim}@$attributeNo}][attributeHtml]" value="" class="long" />
			</dd>
		</dl>
		
		<dl>
			<dt><label for="attributeText[{ldelim}@$attributeNo}]">{lang}wcf.acp.bbcode.attribute.attributeText{/lang}</label></dt>
			<dd>
				<input type="text" id="attributes[{ldelim}@$attributeNo}][attributeText]" name="attributes[{ldelim}@$attributeNo}][attributeText]" value="" class="long" />
			</dd>
		</dl>
		
		<dl>
			<dt><label for="attributeValidationPattern[{ldelim}$attributeNo}]">{lang}wcf.acp.bbcode.attribute.validationPattern{/lang}</label></dt>
			<dd>
				<input type="text" id="attributes[{ldelim}@$attributeNo}][validationPattern]" name="attributes[{ldelim}@$attributeNo}][validationPattern]" value="" class="long" />
			</dd>
		</dl>
		
		<dl>
			<dd>
				<label><input type="checkbox" id="attributes[{ldelim}@$attributeNo}][validationPattern]" name="attributes[{ldelim}@$attributeNo}][validationPattern]" value="1" /> {lang}wcf.acp.bbcode.attribute.required{/lang}</label>
			</dd>
		</dl>
		
		<dl>
			<dd>
				<label><input type="checkbox" id="attributes[{ldelim}@$attributeNo}][useText]" name="attributes[{ldelim}@$attributeNo}][useText]" value="1" /> {lang}wcf.acp.bbcode.attribute.useText{/lang}</label>
				<small>{lang}wcf.acp.bbcode.attribute.useText.description{/lang}</small>
			</dd>
		</dl>
	</fieldset>
{/capture}
<script type="text/javascript">
//<![CDATA[
	$(function() {
		$('.deleteButton').click(function (event) {
			$(event.target).parent().parent().remove();
		});
		
		var attributeNo = {if !$attributes|count}0{else}{assign var='lastAttribute' value=$attributes|end}{$lastAttribute->attributeNo+1}{/if};
		var attributeTemplate = new WCF.Template('{@$attributeTemplate|encodeJS}');
		
		$('.addButton').click(function (event) {
			html = $(attributeTemplate.fetch({ attributeNo: attributeNo++ }));
			html.find('.deleteButton').click(function (event) {
				$(event.target).parent().parent().remove();
			});
			$('#attributeFieldset').append(html);
		});
	});
//]]>
</script>

<header class="mainHeading">
	<img src="{@RELATIVE_WCF_DIR}icon/{$action}1.svg" alt="" />
	<hgroup>
		<h1>{lang}wcf.acp.bbcode.{$action}{/lang}</h1>
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
			<li><a href="{link controller='BBCodeList'}{/link}" title="{lang}wcf.acp.menu.link.bbcode.list{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/bbcode1.svg" alt="" /> <span>{lang}wcf.acp.menu.link.bbcode.list{/lang}</span></a></li>
		</ul>
	</nav>
</div>

<form method="post" action="{if $action == 'add'}{link controller='BBCodeAdd'}{/link}{else}{link controller='BBCodeEdit'}{/link}{/if}">
	<div class="border content">
		<fieldset>
			<legend>{lang}wcf.acp.bbcode.data{/lang}</legend>
			
			<dl{if $errorField == 'bbcodeTag'} class="formError"{/if}>
				<dt><label for="bbcodeTag">{lang}wcf.acp.bbcode.bbcodeTag{/lang}</label></dt>
				<dd>
					<input type="text" id="bbcodeTag" name="bbcodeTag" value="{$bbcodeTag}" class="medium" required="required" pattern="^[a-zA-Z0-9]+$" />
					{if $errorField == 'bbcodeTag'}
						<small class="innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{elseif $errorType == 'invalid'}
								{lang}wcf.acp.bbcode.error.bbcodeTag.invalid{/lang}
							{elseif $errorType == 'inUse'}
								{lang}wcf.acp.bbcode.error.bbcodeTag.inUse{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
			
			<dl{if $errorField == 'htmlOpen'} class="formError"{/if}>
				<dt><label for="htmlOpen">{lang}wcf.acp.bbcode.htmlOpen{/lang}</label></dt>
				<dd>
					<input type="text" id="htmlOpen" name="htmlOpen" value="{$htmlOpen}" class="long" />
				</dd>
			</dl>
			
			<dl{if $errorField == 'htmlClose'} class="formError"{/if}>
				<dt><label for="htmlClose">{lang}wcf.acp.bbcode.htmlClose{/lang}</label></dt>
				<dd>
					<input type="text" id="htmlClose" name="htmlClose" value="{$htmlClose}" class="long" />
				</dd>
			</dl>
			
			<dl{if $errorField == 'textOpen'} class="formError"{/if}>
				<dt><label for="textOpen">{lang}wcf.acp.bbcode.textOpen{/lang}</label></dt>
				<dd>
					<input type="text" id="textOpen" name="textOpen" value="{$textOpen}" class="long" />
				</dd>
			</dl>
			
			<dl{if $errorField == 'textClose'} class="formError"{/if}>
				<dt><label for="textClose">{lang}wcf.acp.bbcode.textClose{/lang}</label></dt>
				<dd>
					<input type="text" id="textClose" name="textClose" value="{$textClose}" class="long" />
				</dd>
			</dl>
			
			<dl{if $errorField == 'allowedChildren'} class="formError"{/if}>
				<dt><label for="allowedChildren">{lang}wcf.acp.bbcode.allowedChildren{/lang}</label></dt>
				<dd>
					<input type="text" id="allowedChildren" name="allowedChildren" value="{$allowedChildren}" class="long" required="required" pattern="^((all|none)\^)?([a-zA-Z0-9]+,?)*[a-zA-Z0-9]+$" />
					{if $errorField == 'allowedChildren'}
						<small class="innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{elseif $errorType == 'invalid'}
								{lang}wcf.acp.bbcode.error.allowedChildren.invalid{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
			
			<dl{if $errorField == 'className'} class="formError"{/if}>
				<dt><label for="className">{lang}wcf.acp.bbcode.className{/lang}</label></dt>
				<dd>
					<input type="text" id="className" name="className" value="{$className}" class="long" pattern="^\\?([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*\\)*[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$" />
					{if $errorField == 'className'}
						<small class="innerError">
							{if $errorType == 'notFound'}
								{lang}wcf.acp.bbcode.error.className.notFound{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
		</fieldset>
		
		<fieldset id="attributeFieldset">
			<legend>{lang}wcf.acp.bbcode.attributes{/lang} <img src="{@RELATIVE_WCF_DIR}icon/add1.svg" alt="" class="addButton" /></legend>
			
			{foreach from=$attributes item='attribute'}
				<fieldset><legend>{lang}wcf.acp.bbcode.attribute{/lang} {#$attribute->attributeNo} <img src="{@RELATIVE_WCF_DIR}icon/delete1.svg" alt="" class="deleteButton" /></legend>
					<dl{if $errorField == 'attributeHtml'|concat:$attribute->attributeNo} class="formError"{/if}>
						<dt><label for="attributeHtml[{@$attribute->attributeNo}]">{lang}wcf.acp.bbcode.attribute.attributeHtml{/lang}</label></dt>
						<dd>
							<input type="text" id="attributes[{@$attribute->attributeNo}][attributeHtml]" name="attributes[{@$attribute->attributeNo}][attributeHtml]" value="{$attribute->attributeHtml}" class="long" />
						</dd>
					</dl>
					
					<dl{if $errorField == 'attributeText'|concat:$attribute->attributeNo} class="formError"{/if}>
						<dt><label for="attributeText[{@$attribute->attributeNo}]">{lang}wcf.acp.bbcode.attribute.attributeText{/lang}</label></dt>
						<dd>
							<input type="text" id="attributes[{@$attribute->attributeNo}][attributeText]" name="attributes[{@$attribute->attributeNo}][attributeText]" value="{$attribute->attributeText}" class="long" />
						</dd>
					</dl>
					
					<dl{if $errorField == 'attributeValidationPattern'|concat:$attribute->attributeNo} class="formError"{/if}>
						<dt><label for="attributeValidationPattern[{$attribute->attributeNo}]">{lang}wcf.acp.bbcode.attribute.validationPattern{/lang}</label></dt>
						<dd>
							<input type="text" id="attributes[{@$attribute->attributeNo}][validationPattern]" name="attributes[{@$attribute->attributeNo}][validationPattern]" value="{$attribute->validationPattern}" class="long" />
							{if $errorField == 'attributeValidationPattern'|concat:$attribute->attributeNo}
								<small class="innerError">
									{if $errorType == 'invalid'}
										{lang}wcf.acp.bbcode.attribute.error.validationPattern.invalid{/lang}
									{/if}
								</small>
							{/if}
						</dd>
					</dl>
					
					<dl{if $errorField == 'attributeRequired'|concat:$attribute->attributeNo} class="formError"{/if}>
						<dd>
							<label><input type="checkbox" id="attributes[{@$attribute->attributeNo}][validationPattern]" name="attributes[{@$attribute->attributeNo}][validationPattern]" value="1"{if $attribute->required} checked="checked"{/if} /> {lang}wcf.acp.bbcode.attribute.required{/lang}</label>
						</dd>
					</dl>
					
					<dl{if $errorField == 'attributeUseText'|concat:$attribute->attributeNo} class="formError"{/if}>
						<dd>
							<label><input type="checkbox" id="attributes[{@$attribute->attributeNo}][useText]" name="attributes[{@$attribute->attributeNo}][useText]" value="1"{if $attribute->useText} checked="checked"{/if} /> {lang}wcf.acp.bbcode.attribute.useText{/lang}</label>
							<small>{lang}wcf.acp.bbcode.attribute.useText.description{/lang}</small>
						</dd>
					</dl>
				</fieldset>
			{/foreach}
		</field>
	</div>
	
	<div class="formSubmit">
		<input type="reset" value="{lang}wcf.global.button.reset{/lang}" accesskey="r" />
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{@SID_INPUT_TAG}
 		{if $bbcodeID|isset}<input type="hidden" name="id" value="{@$bbcodeID}" />{/if}
	</div>
</form>

{include file='footer'}