{include file='header'}
	
<script type="text/javascript">
	//<![CDATA[
	$(function() {
		new WCF.Action.Delete('\\wcf\\data\\smiley\\category\\SmileyCategoryAction', $('.jsSmileyCategoryRow'));
		new WCF.Action.Toggle('\\wcf\\data\\smiley\\category\\SmileyCategoryAction', $('.jsSmileyCategoryRow'));
		new WCF.Sortable.List('smileyCategoryList', '\\wcf\\data\\smiley\\category\\SmileyCategoryAction');
	});
	//]]>
</script>
	
<header class="wcf-mainHeading wcf-container">
	<img src="{@$__wcf->getPath('wcf')}icon/smileyCategory1.svg" alt="" class="wcf-containerIcon" />
	<hgroup class="wcf-containerContent">
		<h1>{lang}wcf.acp.smiley.category.list{/lang}</h1>
	</hgroup>
</header>

<div class="wcf-contentHeader">
	{pages print=true assign=pagesLinks controller="SmileyCategoryList" link="pageNo=%d"}
	
	{if $__wcf->session->getPermission('admin.content.smiley.canAddSmiley')}
		<nav>
			<ul class="wcf-largeButtons">
				<li><a href="{link controller='SmileyCategoryAdd'}{/link}" title="{lang}wcf.acp.smiley.category.add{/lang}" class="wcf-button"><img src="{@$__wcf->getPath('wcf')}icon/add1.svg" alt="" /> <span>{lang}wcf.acp.smiley.category.add{/lang}</span></a></li>
			</ul>
		</nav>
	{/if}
</div>

<section id="smileyCategoryList" class="wcf-box wcf-marginTop wcf-boxPadding wcf-shadow1 wcf-sortableListContainer">
	{hascontent}
	<ol class="wcf-sortableList" data-object-id="0">
		{content}
			{foreach from=$objects item=smileyCategory}
				<li class="wcf-sortableNode wcf-sortableNoNesting jsSmileyCategoryRow" data-object-id="{@$smileyCategory->smileyCategoryID}">
					<span class="wcf-sortableNodeLabel">
						<a href="{link controller='SmileyCategoryEdit' id=$smileyCategory->smileyCategoryID}{/link}">{$smileyCategory->title|language}</a>
						
						<span class="wcf-statusDisplay wcf-sortableButtonContainer">
							{if $__wcf->session->getPermission('admin.content.smiley.canEditSmiley')}
								<img src="{@$__wcf->getPath()}icon/{if $smileyCategory->disabled}disabled{else}enabled{/if}1.svg" alt="" title="{lang}wcf.global.button.{if $smileyCategory->disabled}enable{else}disable{/if}{/lang}" class="jsToggleButton jsTooltip" data-object-id="{@$smileyCategory->smileyCategoryID}" data-disable-message="{lang}wcf.global.button.disable{/lang}" data-enable-message="{lang}wcf.global.button.enable{/lang}" />
								<a href="{link controller='SmileyCategoryEdit' id=$smileyCategory->smileyCategoryID}{/link}"><img src="{@$__wcf->getPath('wcf')}icon/edit1.svg" alt="" title="{lang}wcf.global.button.edit{/lang}" class="balloonTooltip" /></a>
							{/if}
							{if $__wcf->session->getPermission('admin.content.smiley.canDeleteSmiley')}
								<img src="{@$__wcf->getPath('wcf')}icon/delete1.svg" alt="" title="{lang}wcf.global.button.delete{/lang}" class="jsDeleteButton jsTooltip" data-object-id="{@$smileyCategory->smileyCategoryID}" data-confirm-message="{lang}wcf.acp.smiley.category.delete.sure{/lang}" />
							{/if}
						</span>
					</span>
					<ol class="wcf-sortableList" data-object-id="{@$smileyCategory->smileyCategoryID}"></ol></li>
				</li>
			{/foreach}
		{/content}
	</ol>
	<div class="wcf-formSubmit">
		<button class="wcf-button" data-type="reset">{lang}wcf.global.button.reset{/lang}</button>
		<button class="wcf-button default" data-type="submit">{lang}wcf.global.button.submit{/lang}</button>
	</div>
	{hascontentelse}
		<p class="wcf-warning">{lang}wcf.acp.smiley.category.noneAvailable{/lang}</p>
	{/hascontent}
</section>


{include file='footer'}