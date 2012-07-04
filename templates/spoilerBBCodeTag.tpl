<div class="container containerPadding spoilerBox" id="{@$spoilerID}">
	<!-- begin:parser_nonessential -->
	<header class="javascriptOnly">
		<button>{if $buttonTitle}{$buttonTitle}{else}{lang}wcf.bbcode.spoiler.show{/lang}{/if}</button>
	</header>
	<!-- end:parser_nonessential -->
	
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