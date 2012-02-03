{include file='header'}

<header class="wcf-mainHeading">
	<img src="{@RELATIVE_WCF_DIR}icon/videoProvider1.svg" alt="" />
	<hgroup>
		<h1>{lang}wcf.acp.bbcode.videoprovider.list{/lang}</h1>
	</hgroup>
	
	<script type="text/javascript">
		//<![CDATA[
		$(function() {
			new WCF.Action.Delete('wcf\\data\\bbcode\\video\\VideoProviderAction', $('.videoProviderRow'));
		});
		//]]>
	</script>
</header>

<div class="wcf-contentHeader">
	{pages print=true assign=pagesLinks controller="BBCodeVideoProviderList" link="pageNo=%d"}
	
	{if $__wcf->session->getPermission('admin.content.bbcode.videoprovider.canAddVideoProvider')}
		<nav>
			<ul class="wcf-largeButtons">
				<li><a href="{link controller='BBCodeVideoProviderAdd'}{/link}" title="{lang}wcf.acp.bbcode.videoprovider.add{/lang}" class="wcf-button"><img src="{@RELATIVE_WCF_DIR}icon/add1.svg" alt="" /> <span>{lang}wcf.acp.bbcode.videoprovider.add{/lang}</span></a></li>
			</ul>
		</nav>
	{/if}
</div>

{hascontent}
	<div class="wcf-border wcf-boxTitle">
		<hgroup>
			<h1>{lang}wcf.acp.bbcode.videoprovider.list{/lang} <span class="wcf-badge" title="{lang}wcf.acp.bbcode.videoprovider.list.count{/lang}">{#$items}</span></h1>
		</hgroup>
		
		<table class="wcf-bigList">
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
						<tr class="videoProviderRow">
							<td class="columnIcon">
								{if $__wcf->session->getPermission('admin.content.bbcode.videoprovider.canEditVideoProvider')}
									<a href="{link controller='BBCodeVideoProviderEdit' id=$videoProvider->providerID}{/link}"><img src="{@RELATIVE_WCF_DIR}icon/edit1.svg" alt="" title="{lang}wcf.global.button.edit{/lang}" class="wcf-balloonTooltip" /></a>
								{else}
									<img src="{@RELATIVE_WCF_DIR}icon/edit1D.svg" alt="" title="{lang}wcf.global.button.edit{/lang}" />
								{/if}
								{if $__wcf->session->getPermission('admin.content.bbcode.videoprovider.canDeleteVideoProvider')}
									<img src="{@RELATIVE_WCF_DIR}icon/delete1.svg" alt="" title="{lang}wcf.global.button.delete{/lang}" class="deleteButton balloonTooltip" data-object-id="{@$videoProvider->providerID}" data-confirm-message="{lang}wcf.acp.bbcode.videoprovider.delete.sure{/lang}" />
								{else}
									<img src="{@RELATIVE_WCF_DIR}icon/delete1D.svg" alt="" title="{lang}wcf.global.button.delete{/lang}" />
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
	
	<div class="wcf-contentFooter">
		{@$pagesLinks}
		
		{if $__wcf->session->getPermission('admin.content.bbcode.videoprovider.canAddVideoProvider')}
			<nav>
				<ul class="wcf-largeButtons">
					<li><a href="{link controller='BBCodeVideoProviderAdd'}{/link}" title="{lang}wcf.acp.bbcode.videoprovider.add{/lang}" class="wcf-button"><img src="{@RELATIVE_WCF_DIR}icon/add1.svg" alt="" /> <span>{lang}wcf.acp.bbcode.videoprovider.add{/lang}</span></a></li>
				</ul>
			</nav>
		{/if}
	</div>
{hascontentelse}
	<div class="wcf-border wcf-content">
		<div>
			<p class="wcf-warning">{lang}wcf.acp.bbcode.videoprovider.noneAvailable{/lang}</p>
		</div>
	</div>
{/hascontent}

{include file='footer'}
