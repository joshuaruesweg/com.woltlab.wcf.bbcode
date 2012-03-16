{include file='header'}
{if $objects|count}
	<script type="text/javascript">
		//<![CDATA[
		$(function() {
			new WCF.Action.Delete('\\wcf\\data\\smiley\\SmileyAction', $('.jsSmileyRow'));
			new WCF.Sortable.List('smileyList', '\\wcf\\data\\smiley\\SmileyAction', {@$startIndex-1});
			
			var droppable = Class.extend({
				/**
				 * action class name
				 * @var	string
				 */
				_className: '',
				
				/**
				 * list of options
				 * @var	object
				 */
				_options: { },
				
				/**
				 * proxy object
				 * @var	WCF.Action.Proxy
				 */
				_proxy: null,
				
				init: function(dropTarget, accept, className, success, options) {
					this._className = className;
					this._success = success || function(data, textStatus, jqXHR) { }
					this._proxy = new WCF.Action.Proxy({
						success: $.proxy(this._success, this)
					});
					
					var _this = this;
					this._options = $.extend(true, {
						tolerance: 'pointer',
						accept: accept,
						drop: function (event, ui) {
							_this._proxy.setOption('data', {
								actionName: 'drop',
								className: _this._className,
								objectIDs: [ $(this).data('objectID') ],
								parameters: {
									data: {
										draggable: $(ui.draggable).data('objectID')
									}
								}
							});
							_this._proxy.sendRequest();
						}
					}, options || { });
					
					$(dropTarget).droppable(this._options);
				},
				_success: function(data, textStatus, jqXHR) {
					
				}
			});
			
			new droppable($(".jsCategory"), $('.jsSmileyRow'), '\\wcf\\data\\smiley\\category\\SmileyCategoryAction',
				function (data) {
					$('#smiley'+data.returnValues).remove();
				}
			);
		});
		//]]>
	</script>
{/if}
	
<header class="wcf-mainHeading wcf-container">
	<img src="{@$__wcf->getPath('wcf')}icon/smiley1.svg" alt="" class="wcf-containerIcon" />
	<hgroup class="wcf-containerContent">
		<h1>{lang}wcf.acp.smiley.list{/lang}</h1>
	</hgroup>
</header>

<div class="wcf-contentHeader">
	{pages print=true assign=pagesLinks controller="SmileyList" link="pageNo=%d"}
	
	{if $__wcf->session->getPermission('admin.content.smiley.canAddSmiley')}
		<nav>
			<ul class="wcf-largeButtons">
				<li><a href="{link controller='SmileyAdd'}{/link}" title="{lang}wcf.acp.smiley.add{/lang}" class="wcf-button"><img src="{@$__wcf->getPath('wcf')}icon/add1.svg" alt="" /> <span>{lang}wcf.acp.smiley.add{/lang}</span></a></li>
			</ul>
		</nav>
	{/if}
</div>
<a href="{link controller='SmileyList'}{/link}" class="jsCategory" data-object-id="0">{lang}wcf.smiley.category.title0{/lang}</a>
{foreach from=$categories item='category'}
	<a href="{link controller='SmileyList' id=$category->smileyCategoryID}{/link}" class="jsCategory" data-object-id="{$category->smileyCategoryID}">{$category->title|language}</a>
{/foreach}
<section id="smileyList" class="wcf-box wcf-marginTop wcf-boxPadding wcf-shadow1 wcf-sortableListContainer">
	{hascontent}
	<ol class="wcf-sortableList" data-object-id="0" start="{@$startIndex}">
		{content}
			{foreach from=$objects item=smiley}
				<li id="smiley{@$smiley->smileyID}" class="wcf-sortableNode wcf-sortableNoNesting jsSmileyRow" data-object-id="{@$smiley->smileyID}">
					<span class="wcf-sortableNodeLabel">
						<a href="{link controller='SmileyEdit' id=$smiley->smileyID}{/link}"><img src="{$smiley->getURL()}" alt="{$smiley->smileyCode}" title="{$smiley->smileyTitle}" class="jsTooltip" /></a>
						
						<span class="wcf-statusDisplay wcf-sortableButtonContainer">
							{if $__wcf->session->getPermission('admin.content.smiley.canEditSmiley')}
								<a href="{link controller='SmileyEdit' id=$smiley->smileyID}{/link}"><img src="{@$__wcf->getPath('wcf')}icon/edit1.svg" alt="" title="{lang}wcf.global.button.edit{/lang}" class="balloonTooltip" /></a>
							{/if}
							{if $__wcf->session->getPermission('admin.content.smiley.canDeleteSmiley')}
								<img src="{@$__wcf->getPath('wcf')}icon/delete1.svg" alt="" title="{lang}wcf.global.button.delete{/lang}" class="jsDeleteButton jsTooltip" data-object-id="{@$smiley->smileyID}" data-confirm-message="{lang}wcf.acp.smiley.delete.sure{/lang}" />
							{/if}
						</span>
					</span>
					<ol class="wcf-sortableList" data-object-id="{@$smiley->smileyID}"></ol></li>
				</li>
			{/foreach}
		{/content}
	</ol>
	<div class="wcf-formSubmit">
		<button class="wcf-button" data-type="reset">{lang}wcf.global.button.reset{/lang}</button>
		<button class="wcf-button default" data-type="submit">{lang}wcf.global.button.submit{/lang}</button>
	</div>
	{hascontentelse}
		<p class="wcf-warning">{lang}wcf.acp.smiley.noneAvailable{/lang}</p>
	{/hascontent}
</section>


{include file='footer'}