{block name="title" prepend}{$LNG.winemp_Forum_forum_title}{/block}
{block name="content"}
<script type="text/javascript" src="scripts/jQuery.js?v=1829"></script>


<table style="width:700px; background-color: #000000;">
<tbody>
<tr>

<td>
<table style="width:950px;">
<tbody>
<tr>
	<th colspan="5">
		Space of Legends Forum
	</th>
</tr>
<tr>
	<td colspan="5">
		<img alt="" src="./styles/theme/gow/img/forumpic.jpg">
	</td>
</tr>
<tr>
<th colspan="5">Die Beiträge der letzen 48 Stunden</th>
</tr>
<tr>
	<td>Ersteller</td>
	<td>Kategorie</td>
	<td>Topic </td>
	<td>Datum</td>
	<td>zur Kategorie</td>
</tr>
{foreach item=tops from=$top}
<tr>
	<th>{$tops.top_user}</th>
	<th>{$tops.kat_name}</th>
	<th>{$tops.top_name}</th>
	<th>{$tops.top_last}</th>
	<td>
		<form action="" method=post>
			<input type="hidden" name="menue" value="2">
			<input type="hidden" name="topic_id" value="{$tops.top_id}">
			<input type="submit" name="zum_Forum" value="zur Diskussion">
		</form>
	</td>
</tr>
{/foreach}

</tbody>
</table>
</td>
</tr>
<table width="100%">

</table>
</table>
{/block}