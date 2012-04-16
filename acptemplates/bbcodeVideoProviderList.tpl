{include file='header'}

<header class="boxHeadline">
	<hgroup>
		<h1>{lang}wcf.acp.bbcode.videoprovider.list{/lang}</h1>
	</hgroup>
	
	<script type="text/javascript">
		//<![CDATA[
		$(function() {
			new WCF.Action.Delete('wcf\\data\\bbcode\\video\\VideoProviderAction', $('.jsVideoProviderRow'), $('.wcf-box.wcf-boxTitle .wcf-badge'));
		});
		//]]>
	</script>
</header>

<div class="contentNavigation">
	{pages print=true assign=pagesLinks controller="BBCodeVideoProviderList" link="pageNo=%d"}
	
	{if $__wcf->session->getPermission('admin.content.bbcode.videoprovider.canAddVideoProvider')}
		<nav>
			<ul>
				<li><a href="{link controller='BBCodeVideoProviderAdd'}{/link}" title="{lang}wcf.acp.bbcode.videoprovider.add{/lang}" class="button"><img src="{@$__wcf->getPath()}icon/add1.svg" alt="" class="icon24" /> <span>{lang}wcf.acp.bbcode.videoprovider.add{/lang}</span></a></li>
			</ul>
		</nav>
	{/if}
</div>

{hascontent}
	<div class="tabularBox tabularBoxTitle marginTop shadow">
		<hgroup>
			<h1>{lang}wcf.acp.bbcode.videoprovider.list{/lang} <span class="badge" title="{lang}wcf.acp.bbcode.videoprovider.list.count{/lang}">{#$items}</span></h1>
		</hgroup>
		
		<table class="table">
			<thead>
				<tr>
					<th class="columnID columnVideoProviderID" colspan="2">{lang}wcf.global.objectID{/lang}</th>
					<th class="columnTitle columnVideoProviderTitle">{lang}wcf.acp.bbcode.videoprovider.title{/lang}</th>
					
					{event name='headColumns'}
				</tr>
			</thead>
			
			<tbody>
				{content}
					{foreach from=$objects item=videoProvider}
						<tr class="jsVideoProviderRow">
							<td class="columnIcon">
								{if $__wcf->session->getPermission('admin.content.bbcode.videoprovider.canEditVideoProvider')}
									<a href="{link controller='BBCodeVideoProviderEdit' id=$videoProvider->providerID}{/link}"><img src="{@$__wcf->getPath()}icon/edit1.svg" alt="" title="{lang}wcf.global.button.edit{/lang}" class="icon16 jsTooltip" /></a>
								{else}
									<img src="{@$__wcf->getPath()}icon/edit1D.svg" alt="" title="{lang}wcf.global.button.edit{/lang}" class="icon16" />
								{/if}
								{if $__wcf->session->getPermission('admin.content.bbcode.videoprovider.canDeleteVideoProvider')}
									<img src="{@$__wcf->getPath()}icon/delete1.svg" alt="" title="{lang}wcf.global.button.delete{/lang}" class="icon16 jsDeleteButton jsTooltip" data-object-id="{@$videoProvider->providerID}" data-confirm-message="{lang}wcf.acp.bbcode.videoprovider.delete.sure{/lang}" />
								{else}
									<img src="{@$__wcf->getPath()}icon/delete1D.svg" alt="" title="{lang}wcf.global.button.delete{/lang}" class="icon16" />
								{/if}
								
								{event name='buttons'}
							</td>
							<td class="columnID"><p>{@$videoProvider->providerID}</p></td>
							<td class="columnTitle columnVideoProviderTitle">{if $__wcf->session->getPermission('admin.content.bbcode.videoprovider.canDeleteVideoProvider')}<p><a href="{link controller='BBCodeVideoProviderEdit' id=$videoProvider->providerID}{/link}">{lang}{$videoProvider->title}{/lang}</a>{else}{lang}{$videoProvider->title}{/lang}</p>{/if}</td>
							
							{event name='columns'}
						</tr>
					{/foreach}
				{/content}
			</tbody>
		</table>
		
	</div>
	
	<div class="contentNavigation">
		{@$pagesLinks}
		
		{if $__wcf->session->getPermission('admin.content.bbcode.videoprovider.canAddVideoProvider')}
			<nav>
				<ul>
					<li><a href="{link controller='BBCodeVideoProviderAdd'}{/link}" title="{lang}wcf.acp.bbcode.videoprovider.add{/lang}" class="button"><img src="{@$__wcf->getPath()}icon/add1.svg" alt="" class="icon24" /> <span>{lang}wcf.acp.bbcode.videoprovider.add{/lang}</span></a></li>
				</ul>
			</nav>
		{/if}
	</div>
{hascontentelse}
	<div class="container containerPadding">
		<div>
			<p class="warning">{lang}wcf.acp.bbcode.videoprovider.noneAvailable{/lang}</p>
		</div>
	</div>
{/hascontent}

{include file='footer'}
