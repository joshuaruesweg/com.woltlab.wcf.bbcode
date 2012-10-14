{include file='header' pageTitle='wcf.acp.bbcode.mediaprovider.list'}

<header class="boxHeadline">
	<hgroup>
		<h1>{lang}wcf.acp.bbcode.mediaprovider.list{/lang}</h1>
	</hgroup>
	
	<script type="text/javascript">
		//<![CDATA[
		$(function() {
			new WCF.Action.Delete('wcf\\data\\bbcode\\media\\MediaProviderAction', $('.jsMediaProviderRow'), $('.wcf-box.wcf-boxTitle .wcf-badge'));
		});
		//]]>
	</script>
</header>

<div class="contentNavigation">
	{pages print=true assign=pagesLinks controller="BBCodeMediaProviderList" link="pageNo=%d&sortField=$sortField&sortOrder=$sortOrder"}
	
	{if $__wcf->session->getPermission('admin.content.bbcode.mediaprovider.canAddMediaProvider')}
		<nav>
			<ul>
				<li><a href="{link controller='BBCodeMediaProviderAdd'}{/link}" title="{lang}wcf.acp.bbcode.mediaprovider.add{/lang}" class="button"><img src="{@$__wcf->getPath()}icon/add.svg" alt="" class="icon24" /> <span>{lang}wcf.acp.bbcode.mediaprovider.add{/lang}</span></a></li>
			</ul>
		</nav>
	{/if}
</div>

{hascontent}
	<div class="tabularBox tabularBoxTitle marginTop shadow">
		<hgroup>
			<h1>{lang}wcf.acp.bbcode.mediaprovider.list{/lang} <span class="badge badgeInverse" title="{lang}wcf.acp.bbcode.mediaprovider.list.count{/lang}">{#$items}</span></h1>
		</hgroup>
		
		<table class="table">
			<thead>
				<tr>
					<th class="columnID columnMediaProviderID{if $sortField == 'providerID'} active{/if}" colspan="2"><a href="{link controller='BBCodeMediaProviderList'}pageNo={@$pageNo}&sortField=providerID&sortOrder={if $sortField == 'providerID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.global.objectID{/lang}{if $sortField == 'providerID'} <img src="{@$__wcf->getPath()}icon/sort{@$sortOrder}.svg" alt="" />{/if}</a></th>
					<th class="columnTitle columnMediaProviderTitle{if $sortField == 'title'} active{/if}"><a href="{link controller='BBCodeMediaProviderList'}pageNo={@$pageNo}&sortField=title&sortOrder={if $sortField == 'title' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.acp.bbcode.mediaprovider.title{/lang}{if $sortField == 'title'} <img src="{@$__wcf->getPath()}icon/sort{@$sortOrder}.svg" alt="" />{/if}</a></th>
					
					{event name='headColumns'}
				</tr>
			</thead>
			
			<tbody>
				{content}
					{foreach from=$objects item=mediaProvider}
						<tr class="jsMediaProviderRow">
							<td class="columnIcon">
								{if $__wcf->session->getPermission('admin.content.bbcode.mediaprovider.canEditMediaProvider')}
									<a href="{link controller='BBCodeMediaProviderEdit' id=$mediaProvider->providerID}{/link}"><img src="{@$__wcf->getPath()}icon/edit.svg" alt="" title="{lang}wcf.global.button.edit{/lang}" class="icon16 jsTooltip" /></a>
								{else}
									<img src="{@$__wcf->getPath()}icon/edit.svg" alt="" title="{lang}wcf.global.button.edit{/lang}" class="icon16 disabled" />
								{/if}
								{if $__wcf->session->getPermission('admin.content.bbcode.mediaprovider.canDeleteMediaProvider')}
									<img src="{@$__wcf->getPath()}icon/delete.svg" alt="" title="{lang}wcf.global.button.delete{/lang}" class="icon16 jsDeleteButton jsTooltip" data-object-id="{@$mediaProvider->providerID}" data-confirm-message="{lang}wcf.acp.bbcode.mediaprovider.delete.sure{/lang}" />
								{else}
									<img src="{@$__wcf->getPath()}icon/delete.svg" alt="" title="{lang}wcf.global.button.delete{/lang}" class="icon16 disabled" />
								{/if}
								
								{event name='buttons'}
							</td>
							<td class="columnID"><p>{@$mediaProvider->providerID}</p></td>
							<td class="columnTitle columnMediaProviderTitle">{if $__wcf->session->getPermission('admin.content.bbcode.mediaprovider.canDeleteMediaProvider')}<p><a href="{link controller='BBCodeMediaProviderEdit' id=$mediaProvider->providerID}{/link}">{lang}{$mediaProvider->title}{/lang}</a>{else}{lang}{$mediaProvider->title}{/lang}</p>{/if}</td>
							
							{event name='columns'}
						</tr>
					{/foreach}
				{/content}
			</tbody>
		</table>
		
	</div>
	
	<div class="contentNavigation">
		{@$pagesLinks}
		
		{if $__wcf->session->getPermission('admin.content.bbcode.mediaprovider.canAddMediaProvider')}
			<nav>
				<ul>
					<li><a href="{link controller='BBCodeMediaProviderAdd'}{/link}" title="{lang}wcf.acp.bbcode.mediaprovider.add{/lang}" class="button"><img src="{@$__wcf->getPath()}icon/add.svg" alt="" class="icon24" /> <span>{lang}wcf.acp.bbcode.mediaprovider.add{/lang}</span></a></li>
				</ul>
			</nav>
		{/if}
	</div>
{hascontentelse}
	<div class="container containerPadding">
		<div>
			<p class="warning">{lang}wcf.acp.bbcode.mediaprovider.noneAvailable{/lang}</p>
		</div>
	</div>
{/hascontent}

{include file='footer'}
