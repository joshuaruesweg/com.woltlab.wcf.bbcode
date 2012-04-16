{include file='header'}
	
{if $objects|count}
	<script type="text/javascript">
		//<![CDATA[
		$(function() {
			new WCF.Action.Delete('\\wcf\\data\\smiley\\category\\SmileyCategoryAction', $('.jsSmileyCategoryRow'));
			new WCF.Action.Toggle('\\wcf\\data\\smiley\\category\\SmileyCategoryAction', $('.jsSmileyCategoryRow'));
			new WCF.Sortable.List('smileyCategoryList', '\\wcf\\data\\smiley\\category\\SmileyCategoryAction', {if $startIndex == 1}0{else}{@$startIndex-2}{/if});
		});
		//]]>
	</script>
{/if}
	
<header class="boxHeadline">
	<hgroup>
		<h1>{lang}wcf.acp.smiley.category.list{/lang}</h1>
	</hgroup>
</header>

<div class="contentNavigation">
	{pages print=true assign=pagesLinks controller="SmileyCategoryList" link="pageNo=%d"}
	
	{if $__wcf->session->getPermission('admin.content.smiley.canAddSmiley')}
		<nav>
			<ul>
				<li><a href="{link controller='SmileyCategoryAdd'}{/link}" title="{lang}wcf.acp.smiley.category.add{/lang}" class="button"><img src="{@$__wcf->getPath('wcf')}icon/add1.svg" alt="" class="icon24" /> <span>{lang}wcf.acp.smiley.category.add{/lang}</span></a></li>
			</ul>
		</nav>
	{/if}
</div>

<section id="smileyCategoryList" class="container containerPadding sortableListContainer marginTop shadow">
	<ol class="sortableList" data-object-id="0" start="{$startIndex}">
		{if $startIndex-1 == 0}
			<li class="sortableNode sortableNoSorting sortableNoNesting jsSmileyCategoryRow">
				<span class="sortableNodeLabel">
					{lang}wcf.smiley.category.title0{/lang}
					
					<span class="statusDisplay sortableButtonContainer">
						{if $__wcf->session->getPermission('admin.content.smiley.canEditSmiley')}
							<img src="{@$__wcf->getPath()}icon/enabled1D.svg" alt="" title="{lang}wcf.global.button.disable{/lang}" class="icon16" />
							<img src="{@$__wcf->getPath('wcf')}icon/edit1D.svg" alt="" title="{lang}wcf.global.button.edit{/lang}" class="icon16" /></a>
						{/if}
						{if $__wcf->session->getPermission('admin.content.smiley.canDeleteSmiley')}
							<img src="{@$__wcf->getPath('wcf')}icon/delete1D.svg" alt="" title="{lang}wcf.global.button.delete{/lang}" class="icon16" />
						{/if}
					</span>
				</span>
				<ol class="sortableList"></ol></li>
			</li>
		{/if}
		{foreach from=$objects item=smileyCategory}
			<li class="sortableNode sortableNoNesting jsSmileyCategoryRow" data-object-id="{@$smileyCategory->smileyCategoryID}">
				<span class="sortableNodeLabel">
					<a href="{link controller='SmileyCategoryEdit' id=$smileyCategory->smileyCategoryID}{/link}">{$smileyCategory->title|language}</a>
					
					<span class="statusDisplay sortableButtonContainer">
						{if $__wcf->session->getPermission('admin.content.smiley.canEditSmiley')}
							<img src="{@$__wcf->getPath()}icon/{if $smileyCategory->disabled}disabled{else}enabled{/if}1.svg" alt="" title="{lang}wcf.global.button.{if $smileyCategory->disabled}enable{else}disable{/if}{/lang}" class="jsToggleButton jsTooltip icon16" data-object-id="{@$smileyCategory->smileyCategoryID}" data-disable-message="{lang}wcf.global.button.disable{/lang}" data-enable-message="{lang}wcf.global.button.enable{/lang}" />
							<a href="{link controller='SmileyCategoryEdit' id=$smileyCategory->smileyCategoryID}{/link}"><img src="{@$__wcf->getPath('wcf')}icon/edit1.svg" alt="" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip icon16" /></a>
						{/if}
						{if $__wcf->session->getPermission('admin.content.smiley.canDeleteSmiley')}
							<img src="{@$__wcf->getPath('wcf')}icon/delete1.svg" alt="" title="{lang}wcf.global.button.delete{/lang}" class="jsDeleteButton jsTooltip icon16" data-object-id="{@$smileyCategory->smileyCategoryID}" data-confirm-message="{lang}wcf.acp.smiley.category.delete.sure{/lang}" />
						{/if}
					</span>
				</span>
				<ol class="sortableList" data-object-id="{@$smileyCategory->smileyCategoryID}"></ol></li>
			</li>
		{/foreach}
	</ol>
	{if $objects|count}
	<div class="formSubmit">
		<button class="button" data-type="submit">{lang}wcf.global.button.submit{/lang}</button>
	</div>
	{/if}
</section>


{include file='footer'}