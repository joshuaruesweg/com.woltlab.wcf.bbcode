{include file='header' pageTitle='wcf.acp.bbcode.list'}

<header class="boxHeadline">
	<hgroup>
		<h1>{lang}wcf.acp.bbcode.list{/lang}</h1>
	</hgroup>
	
	<script type="text/javascript">
		//<![CDATA[
		$(function() {
			new WCF.Action.Delete('wcf\\data\\bbcode\\BBCodeAction', $('.jsBBCodeRow'), $('.wcf-box.wcf-boxTitle .wcf-badge'));
			new WCF.Action.Toggle('wcf\\data\\bbcode\\BBCodeAction', $('.jsBBCodeRow'));
		});
		//]]>
	</script>
</header>

<div class="contentNavigation">
	{pages print=true assign=pagesLinks controller="BBCodeList" link="pageNo=%d&sortField=$sortField&sortOrder=$sortOrder"}
	
	{if $__wcf->session->getPermission('admin.content.bbcode.canAddBBCode')}
		<nav>
			<ul>
				<li><a href="{link controller='BBCodeAdd'}{/link}" title="{lang}wcf.acp.bbcode.add{/lang}" class="button"><img src="{@$__wcf->getPath()}icon/add.svg" alt="" class="icon24" /> <span>{lang}wcf.acp.bbcode.add{/lang}</span></a></li>
			</ul>
		</nav>
	{/if}
</div>

{hascontent}
	<div class="tabularBox tabularBoxTitle marginTop shadow">
		<hgroup>
			<h1>{lang}wcf.acp.bbcode.list{/lang} <span class="badge badgeInverse" title="{lang}wcf.acp.bbcode.list.count{/lang}">{#$items}</span></h1>
		</hgroup>
		
		<table class="table">
			<thead>
				<tr>
					<th class="columnID columnBBCodeID{if $sortField == 'bbcodeID'} active{/if}" colspan="2"><a href="{link controller='BBCodeList'}pageNo={@$pageNo}&sortField=bbcodeID&sortOrder={if $sortField == 'bbcodeID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.global.objectID{/lang}{if $sortField == 'bbcodeID'} <img src="{@$__wcf->getPath()}icon/sort{@$sortOrder}.svg" alt="" />{/if}</a></th>
					<th class="columnTitle columnBBCode{if $sortField == 'bbcodeTag'} active{/if}"><a href="{link controller='BBCodeList'}pageNo={@$pageNo}&sortField=bbcodeTag&sortOrder={if $sortField == 'bbcodeTag' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.acp.bbcode.bbcodeTag{/lang}{if $sortField == 'bbcodeTag'} <img src="{@$__wcf->getPath()}icon/sort{@$sortOrder}.svg" alt="" />{/if}</a></th>
					<th class="columnText columnClassName{if $sortField == 'className'} active{/if}"><a href="{link controller='BBCodeList'}pageNo={@$pageNo}&sortField=className&sortOrder={if $sortField == 'className' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.acp.bbcode.className{/lang}{if $sortField == 'className'} <img src="{@$__wcf->getPath()}icon/sort{@$sortOrder}.svg" alt="" />{/if}</a></th>
					
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
									<img src="{@$__wcf->getPath()}icon/{if $bbcode->disabled}disabled{else}enabled{/if}.svg" alt="" title="{lang}wcf.global.button.{if $bbcode->disabled}enable{else}disable{/if}{/lang}" class="icon16 jsToggleButton jsTooltip" data-object-id="{@$bbcode->bbcodeID}" data-disable-message="{lang}wcf.global.button.disable{/lang}" data-enable-message="{lang}wcf.global.button.enable{/lang}" />
								{else}
									{if $bbcode->disabled}
										<img src="{@$__wcf->getPath()}icon/disabled.svg" alt="" title="{lang}wcf.global.button.enable{/lang}" class="icon16 disabled" />
									{else}
										<img src="{@$__wcf->getPath()}icon/enabled.svg" alt="" title="{lang}wcf.global.button.disable{/lang}" class="icon16 disabled" />
									{/if}
								{/if}
								{if $__wcf->session->getPermission('admin.content.bbcode.canEditBBCode')}
									<a href="{link controller='BBCodeEdit' id=$bbcode->bbcodeID}{/link}"><img src="{@$__wcf->getPath()}icon/edit.svg" alt="" title="{lang}wcf.global.button.edit{/lang}" class="icon16 jsTooltip" /></a>
								{else}
									<img src="{@$__wcf->getPath()}icon/edit.svg" alt="" title="{lang}wcf.global.button.edit{/lang}" class="icon16 disabled" />
								{/if}
								{if $__wcf->session->getPermission('admin.content.bbcode.canDeleteBBCode')}
									<img src="{@$__wcf->getPath()}icon/delete.svg" alt="" title="{lang}wcf.global.button.delete{/lang}" class="icon16 jsDeleteButton jsTooltip" data-object-id="{@$bbcode->bbcodeID}" data-confirm-message="{lang}wcf.acp.bbcode.delete.sure{/lang}" />
								{else}
									<img src="{@$__wcf->getPath()}icon/delete.svg" alt="" title="{lang}wcf.global.button.delete{/lang}" class="icon16 disabled" />
								{/if}
								
								{event name='buttons'}
							</td>
							<td class="columnID"><p>{@$bbcode->bbcodeID}</p></td>
							<td class="columnTitle columnBBCode"><p>{if $__wcf->session->getPermission('admin.content.bbcode.canEditBBCode')}<a href="{link controller='BBCodeEdit' id=$bbcode->bbcodeID}{/link}">[{$bbcode->bbcodeTag}]</a>{else}[{$bbcode->bbcodeTag}]{/if}</p></td>
							<td class="columnText columnClassName"><p>{$bbcode->className}</p></td>
							
							{event name='columns'}
						</tr>
					{/foreach}
				{/content}
			</tbody>
		</table>
		
	</div>
	
	<div class="contentNavigation">
		{@$pagesLinks}
		
		{if $__wcf->session->getPermission('admin.content.bbcode.canAddBBCode')}
			<nav>
				<ul>
					<li><a href="{link controller='BBCodeAdd'}{/link}" title="{lang}wcf.acp.bbcode.add{/lang}" class="button"><img src="{@$__wcf->getPath()}icon/add.svg" alt="" class="icon24" /> <span>{lang}wcf.acp.bbcode.add{/lang}</span></a></li>
				</ul>
			</nav>
		{/if}
	</div>
{hascontentelse}
	<p class="info">{lang}wcf.acp.bbcode.noneAvailable{/lang}</p>
{/hascontent}

{include file='footer'}
