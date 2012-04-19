<div class="container containerPadding spoilerBox" id="{@$spoilerID}">
	<header class="javascriptOnly">
		<button>{if $buttonTitle}{$buttonTitle}{else}{lang}wcf.bbcode.spoiler.show{/lang}{/if}</button>
	</header>
	
	<div>
		{@$content}
	</div>
</div>

<script type="text/javascript">
	//<![CDATA[
	$(function() {
		$('#{@$spoilerID} > div').hide();
		$('#{@$spoilerID} > header > button').click(function() {
			$(this).toggleClass('active');
			$('#{@$spoilerID} > div').slideToggle();
		});
	});
	//]]>
</script>