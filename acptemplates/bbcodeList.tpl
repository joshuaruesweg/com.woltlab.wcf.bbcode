{include file='header'}

<header class="wcf-mainHeading">
	<img src="{@RELATIVE_WCF_DIR}icon/bbCode1.svg" alt="" />
	<hgroup>
		<h1>{lang}wcf.acp.bbcode.list{/lang}</h1>
	</hgroup>
	
	<script type="text/javascript">
		//<![CDATA[
		$(function() {
			new WCF.Action.Delete('wcf\\data\\bbcode\\BBCodeAction', $('.jsBBCodeRow'));
			new WCF.Action.Toggle('wcf\\data\\bbcode\\BBCodeAction', $('.jsBBCodeRow'));
		});
		//]]>
	</script>
</header>

<div class="wcf-contentHeader">
	{pages print=true assign=pagesLinks controller="BBCodeList" link="pageNo=%d"}
	
	{if $__wcf->session->getPermission('admin.content.bbcode.canAddBBCode')}
		<nav>
			<ul class="wcf-largeButtons">
				<li><a href="{link controller='BBCodeAdd'}{/link}" title="{lang}wcf.acp.bbcode.add{/lang}" class="wcf-button"><img src="{@RELATIVE_WCF_DIR}icon/add1.svg" alt="" /> <span>{lang}wcf.acp.bbcode.add{/lang}</span></a></li>
			</ul>
		</nav>
	{/if}
</div>

{hascontent}
	<div class="wcf-border wcf-boxTitle">
		<hgroup>
			<h1>{lang}wcf.acp.bbcode.list{/lang} <span class="wcf-badge" title="{lang}wcf.acp.bbcode.list.count{/lang}">{#$items}</span></h1>
		</hgroup>
		
		<table class="wcf-table">
			<thead>
				<tr>
					<th class="columnID columnBBCodeID" colspan="2">{lang}wcf.global.objectID{/lang}</th>
					<th class="columnTitle columnBBCode">{lang}wcf.acp.bbcode.bbcodeTag{/lang}</th>
					<th class="columnText columnClassName">{lang}wcf.acp.bbcode.className{/lang}</th>
					
					{event name='headColumns'}
				</tr>
			</thead>
			
			<tbody>
				{content}
					{foreach from=$objects item=bbcode}
						<tr class="jsBBCodeRow">
							<td class="columnIcon">
								{* toggle, edit, delete *}
								{if $__wcf->session->getPermission('admin.content.bbcode.canEditBBCode')}
									<img src="{@RELATIVE_WCF_DIR}icon/{if $bbcode->disabled}disabled{else}enabled{/if}1.svg" alt="" title="{lang}wcf.global.button.{if $bbcode->disabled}enable{else}disable{/if}{/lang}" class="jsToggleButton wcf-balloonTooltip" data-object-id="{@$bbcode->bbcodeID}" data-disable-message="{lang}wcf.global.button.disable{/lang}" data-enable-message="{lang}wcf.global.button.enable{/lang}" />
								{else}
									{if $bbcode->disabled}
										<img src="{@RELATIVE_WCF_DIR}icon/disabled1D.svg" alt="" title="{lang}wcf.global.button.enable{/lang}" />
									{else}
										<img src="{@RELATIVE_WCF_DIR}icon/enabled1D.svg" alt="" title="{lang}wcf.global.button.disable{/lang}" />
									{/if}
								{/if}
								{if $__wcf->session->getPermission('admin.content.bbcode.canEditBBCode')}
									<a href="{link controller='BBCodeEdit' id=$bbcode->bbcodeID}{/link}"><img src="{@RELATIVE_WCF_DIR}icon/edit1.svg" alt="" title="{lang}wcf.global.button.edit{/lang}" class="wcf-balloonTooltip" /></a>
								{else}
									<img src="{@RELATIVE_WCF_DIR}icon/edit1D.svg" alt="" title="{lang}wcf.global.button.edit{/lang}" />
								{/if}
								{if $__wcf->session->getPermission('admin.content.bbcode.canDeleteBBCode')}
									<img src="{@RELATIVE_WCF_DIR}icon/delete1.svg" alt="" title="{lang}wcf.global.button.delete{/lang}" class="jsDeleteButton wcf-balloonTooltip" data-object-id="{@$bbcode->bbcodeID}" data-confirm-message="{lang}wcf.acp.bbcode.delete.sure{/lang}" />
								{else}
									<img src="{@RELATIVE_WCF_DIR}icon/delete1D.svg" alt="" title="{lang}wcf.global.button.delete{/lang}" />
								{/if}
								
								{event name='buttons'}
							</td>
							<td class="columnID"><p>{@$bbcode->bbcodeID}</p></td>
							<td class="columnTitle columnBBCode">{if $__wcf->session->getPermission('admin.content.bbcode.canEditBBCode')}<p><a href="{link controller='BBCodeEdit' id=$bbcode->bbcodeID}{/link}">[{$bbcode->bbcodeTag}]</a>{else}[{$bbcode->bbcodeTag}]</p>{/if}</td>
							<td class="columnText columnClassName"><p>{$bbcode->className}</p></td>
							
							{event name='columns'}
						</tr>
					{/foreach}
				{/content}
			</tbody>
		</table>
		
	</div>
	
	<div class="wcf-contentFooter">
		{@$pagesLinks}
		
		{if $__wcf->session->getPermission('admin.content.bbcode.canAddBBCode')}
			<nav>
				<ul class="wcf-largeButtons">
					<li><a href="{link controller='BBCodeAdd'}{/link}" title="{lang}wcf.acp.bbcode.add{/lang}" class="wcf-button"><img src="{@RELATIVE_WCF_DIR}icon/add1.svg" alt="" /> <span>{lang}wcf.acp.bbcode.add{/lang}</span></a></li>
				</ul>
			</nav>
		{/if}
	</div>
{hascontentelse}
	<div class="wcf-border wcf-content">
		<div>
			<p class="wcf-warning">{lang}wcf.acp.bbcode.noneAvailable{/lang}</p>
		</div>
	</div>
{/hascontent}

{include file='footer'}
