{block name="title" prepend}{$LNG.winemp_Forum_topic_title}{$topic_name}{/block}
{block name="content"}
<script type="text/javascript" src="scripts/jQuery.js?v=1829"></script>
<table>
<tr>
	<th colspan="3">
		<form action="" method="post">
		<input name="menue" value="3" type="hidden">
		<input name="do_it" value="yes" type="hidden">
		<input name="id" value="{$topic_id}" type="hidden">
		<textarea name="text" cols="50" rows="10"></textarea>
		<input type="submit" value="{$LNG.winemp_Forum_topic_answer}" name="{$LNG.winemp_Forum_topic_answer}">
		</form>
	</th>
</tr>
</table>
{/block}