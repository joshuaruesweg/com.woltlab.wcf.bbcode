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
	
<header class="boxHeadline">
	<hgroup>
		<h1>{lang}wcf.acp.smiley.list{/lang}</h1>
	</hgroup>
</header>

<div class="contentNavigation">
	{pages print=true assign=pagesLinks controller="SmileyList" link="pageNo=%d"}
	
	{if $__wcf->session->getPermission('admin.content.smiley.canAddSmiley')}
		<nav>
			<ul>
				<li><a href="{link controller='SmileyAdd'}{/link}" title="{lang}wcf.acp.smiley.add{/lang}" class="button"><img src="{@$__wcf->getPath('wcf')}icon/add1.svg" alt="" class="icon24" /> <span>{lang}wcf.acp.smiley.add{/lang}</span></a></li>
			</ul>
		</nav>
	{/if}
</div>
<a href="{link controller='SmileyList'}{/link}" class="jsCategory" data-object-id="0">{lang}wcf.smiley.category.title0{/lang}</a>
{foreach from=$categories item='category'}
	<a href="{link controller='SmileyList' id=$category->smileyCategoryID}{/link}" class="jsCategory" data-object-id="{$category->smileyCategoryID}">{$category->title|language}</a>
{/foreach}
{hascontent}
	<section id="smileyList" class="container containerPadding sortableListContainer marginTop shadow">
		<ol class="sortableList" data-object-id="0" start="{@$startIndex}">
			{content}
				{foreach from=$objects item=smiley}
					<li id="smiley{@$smiley->smileyID}" class="sortableNode sortableNoNesting jsSmileyRow" data-object-id="{@$smiley->smileyID}">
						<span class="sortableNodeLabel">
							<a href="{link controller='SmileyEdit' id=$smiley->smileyID}{/link}"><img src="{$smiley->getURL()}" alt="{$smiley->smileyCode}" title="{$smiley->smileyTitle}" class="jsTooltip" /></a>
							
							<span class="statusDisplay sortableButtonContainer">
								{if $__wcf->session->getPermission('admin.content.smiley.canEditSmiley')}
									<a href="{link controller='SmileyEdit' id=$smiley->smileyID}{/link}"><img src="{@$__wcf->getPath('wcf')}icon/edit1.svg" alt="" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip icon16" /></a>
								{/if}
								{if $__wcf->session->getPermission('admin.content.smiley.canDeleteSmiley')}
									<img src="{@$__wcf->getPath('wcf')}icon/delete1.svg" alt="" title="{lang}wcf.global.button.delete{/lang}" class="jsDeleteButton jsTooltip icon16" data-object-id="{@$smiley->smileyID}" data-confirm-message="{lang}wcf.acp.smiley.delete.sure{/lang}" />
								{/if}
							</span>
						</span>
						<ol class="sortableList" data-object-id="{@$smiley->smileyID}"></ol></li>
					</li>
				{/foreach}
			{/content}
		</ol>
		<div class="formSubmit">
			<button class="button" data-type="submit">{lang}wcf.global.button.submit{/lang}</button>
		</div>
	</section>
{hascontentelse}
	<p class="wcf-warning">{lang}wcf.acp.smiley.noneAvailable{/lang}</p>
{/hascontent}


{include file='footer'}