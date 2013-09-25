{block name="title" prepend}{$LNG.winemp_Forum_topic_title}{$topic_name}{/block}
{block name="content"}
<script type="text/javascript" src="scripts/jQuery.js?v=1829"></script>
<table style="width:950px; background-color: #000000;">
<tbody>
<tr>

<td>
<table style="width:950px;">
<tbody>
<tr>
	<th colspan="5">
		Allianz Forum
	</th>
</tr>
<tr>
	<td colspan="5">
		<img alt="" src="./styles/theme/gow/img/forumpic.jpg">
	</td>
</tr>
<tr>
	<th colspan="5">
		
</th>
</tr>
<th "width:500px;">
		<form action="" method="post">
		<input name="menue" value="4" type="hidden">
		<input name="do_it" value="yes" type="hidden">
		<input name="topic_id" value="{$topic_id}" type="hidden">
		<input name="tread_id" value="{$tread_id}" type="hidden">
		<textarea name="text" cols="50" rows="10">{$tread_text}</textarea>
		<input type="submit" value="{$LNG.winemp_Forum_topic_answer}" name="{$LNG.winemp_Forum_topic_answer}">
		</form>
	</th>


</tbody>
</table>
{/block}