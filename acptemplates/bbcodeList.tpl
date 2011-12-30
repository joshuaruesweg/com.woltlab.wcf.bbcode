{include file='header'}

<header class="mainHeading">
	<img src="{@RELATIVE_WCF_DIR}icon/bbcode1.svg" alt="" />
	<hgroup>
		<h1>{lang}wcf.acp.bbcode.list{/lang}</h1>
		<h2>{lang}wcf.acp.bbcode.subtitle{/lang}</h2>
	</hgroup>
	
	<script type="text/javascript">
		//<![CDATA[
		$(function() {
			new WCF.Action.Delete('wcf\\data\\bbcode\\BBCodeAction', $('.bbcodeRow'));
			new WCF.Action.Toggle('wcf\\data\\bbcode\\BBCodeAction', $('.bbcodeRow'));
		});
		//]]>
	</script>
</header>

<div class="contentHeader">
	{pages print=true assign=pagesLinks controller="BBCodeList" link="pageNo=%d"}
	
	{if $__wcf->session->getPermission('admin.content.bbcode.canAddBBCode')}
		<nav>
			<ul class="largeButtons">
				<li><a href="{link controller='BBCodeAdd'}{/link}" title="{lang}wcf.acp.bbcode.add{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/add1.svg" alt="" /> <span>{lang}wcf.acp.bbcode.add{/lang}</span></a></li>
			</ul>
		</nav>
	{/if}
</div>

{hascontent}
	<div class="border boxTitle">
		<hgroup>
			<h1>{lang}wcf.acp.bbcode.list{/lang} <span class="badge" title="{lang}wcf.acp.bbcode.list.count{/lang}">{#$items}</span></h1>
		</hgroup>
		
		<table>
			<thead>
				<tr>
					<th class="columnID columnBBCodeID" colspan="2">{lang}wcf.global.objectID{/lang}</th>
					<th class="columnText columnBBCode">{lang}wcf.acp.bbcode.bbcode{/lang}</th>
					<th class="columnText columnClassName">{lang}wcf.acp.bbcode.className{/lang}</th>
					
					{event name='headColumns'}
				</tr>
			</thead>
			
			<tbody>
				{content}
					{foreach from=$objects item=bbcode}
						<tr class="bbcodeRow">
							<td class="columnIcon">
								{* toggle, edit, delete *}
								{if $__wcf->session->getPermission('admin.content.bbcode.canEditBBCode')}
									<img src="{@RELATIVE_WCF_DIR}icon/{if $bbcode->disabled}disabled{else}enabled{/if}1.svg" alt="" title="{lang}wcf.global.button.{if $bbcode->disabled}enable{else}disable{/if}{/lang}" class="toggleButton balloonTooltip" data-object-id="{@$bbcode->bbcodeID}" data-disable-message="{lang}wcf.global.button.disable{/lang}" data-enable-message="{lang}wcf.global.button.enable{/lang}" />
								{else}
									{if $bbcode->disabled}
										<img src="{@RELATIVE_WCF_DIR}icon/disabled1D.svg" alt="" title="{lang}wcf.global.button.enable{/lang}" />
									{else}
										<img src="{@RELATIVE_WCF_DIR}icon/enabled1D.svg" alt="" title="{lang}wcf.global.button.disable{/lang}" />
									{/if}
								{/if}
								{if $__wcf->session->getPermission('admin.content.bbcode.canEditBBCode')}
									<a href="{link controller='BBCodeEdit' id=$bbcode->bbcodeID}{/link}"><img src="{@RELATIVE_WCF_DIR}icon/edit1.svg" alt="" title="{lang}wcf.global.button.edit{/lang}" class="balloonTooltip" /></a>
								{else}
									<img src="{@RELATIVE_WCF_DIR}icon/edit1D.svg" alt="" title="{lang}wcf.global.button.edit{/lang}" />
								{/if}
								{if $__wcf->session->getPermission('admin.content.bbcode.canDeleteBBCode')}
									<img src="{@RELATIVE_WCF_DIR}icon/delete1.svg" alt="" title="{lang}wcf.global.button.delete{/lang}" class="deleteButton balloonTooltip" data-object-id="{@$bbcode->bbcodeID}" data-confirm-message="{lang}wcf.acp.bbcode.delete.sure{/lang}" />
								{else}
									<img src="{@RELATIVE_WCF_DIR}icon/delete1D.svg" alt="" title="{lang}wcf.global.button.delete{/lang}" />
								{/if}
								
								{event name='buttons'}
							</td>
							<td class="columnID"><p>{@$bbcode->bbcodeID}</p></td>
							<td class="columnText columnBBCode">[{$bbcode->bbcodeTag}]</p></td>
							<td class="columnText columnClassName">{$bbcode->className}</p></td>
							
							{event name='columns'}
						</tr>
					{/foreach}
				{/content}
			</tbody>
		</table>
		
	</div>
	
	<div class="contentFooter">
		{@$pagesLinks}
		
		{if $__wcf->session->getPermission('admin.content.bbcode.canAddBBCode')}
			<nav>
				<ul class="largeButtons">
					<li><a href="{link controller='BBCodeAdd'}{/link}" title="{lang}wcf.acp.bbcode.add{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/add1.svg" alt="" /> <span>{lang}wcf.acp.bbcode.add{/lang}</span></a></li>
				</ul>
			</nav>
		{/if}
	</div>
{hascontentelse}
	<div class="border content">
		<div class="container-1">
			<p class="warning">{lang}wcf.acp.bbcode.noneAvailable{/lang}</p>
		</div>
	</div>
{/hascontent}

{include file='footer'}
