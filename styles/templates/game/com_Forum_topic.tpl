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
	<th colspan="3">
		Space of Legends Forum 
	</th>
	<th>
	<form action="" method="post">
		<input type="hidden" name="menue" value="3">
		<input type="hidden" name="kat_id" value="{$kat}">
		<input type="hidden" name="kat_name" value="{$kat_name}">
		<input type="submit" name="new_topic" value="Neues Thema">
	</form>
	</th>
	<th>
		<div width="100%" align="right">Kategorie: {$kat_name}</div>
	</th>
</tr>
<tr>
	<td colspan="5">
		<img alt="" src="./styles/theme/gow/img/forumpic.jpg">
	</td>
</tr>
<tr>
	<th width="45%">Thema</th>
	<th width="15%">Ersteller </th>
	<th width="15%">Datum</th>
	<th width="10%">Antworten</th>
	<th width="15%">zur Diskussion</th>
</tr>
{foreach item=topic from=$top}
	<tr>
	<td>
		{$topic.top_name}
	</td>
	<td>
		{$topic.top_name}
	</td>
	<td>
		{$topic.top_last}
	</td>
	<td>
		{$topic.top_ans}
	</td>
	<td>
		{if $topic.top_close}
			Geschlossen
		{else}
			<form action="" method="post">
				<input type="hidden" name="topic_id" value="{$topic.top_id}">
				<input type="hidden" name="menue" value="2">
				<input type="submit" name="get_answer" value="zur Diskussion">
			</form>
		{/if}
	</td>
	</tr>
	<tr>
	{if $adm}
	<th colspan="2">
	<form action="" method="post">
		<input type="hidden" name="menue" value="3">
		<input type="hidden" name="kat_id" value="{$kat}">
		<input type="hidden" name="kat_name" value="{$kat_name}">
		<input type="submit" name="new_topic" value="Neues Thema">
	</form>
	</th>
	<th>
	<form action="" method="post">
		<input type="hidden" name="menue" value="7">
		<input type="hidden" name="topic_id" value="{$topic.top_id}">
		<input type="submit" name="topic_close" value="Thema schliessen">
	</form>
	</th>
	<th>
	<form action="" method="post">
		<input type="hidden" name="menue" value="5">
		<input type="hidden" name="topic_id" value="{$topic.top_id}">
		<input type="submit" name="topic_del" value="Thema Löschen">
	</form>
	</th>
	<th>
	<div width="100%" align="right">
	<form action="" method="post">
		<input type="hidden" name="menue" value="0">
		<input type="hidden" name="topic_id" value="{$topic.top_id}">
		<input type="submit" name="back" value="zurück">
	</form>
	</div>
	</th>
	{else}
	<td colspan="3">
	</td>
	{/if}
	</tr>
{/foreach}
<tr>
	<th colspan="2">
	<form action="" method="post">
		<input type="hidden" name="menue" value="3">
		<input type="hidden" name="kat_id" value="{$kat}">
		<input type="hidden" name="kat_name" value="{$kat_name}">
		<input type="submit" name="new_topic" value="Neues Thema">
	</form>
	</th>
	<td>
	</td>
	<th colspan="2">
	<div width="100%" align="right">
	<form action="" method="post">
		<input type="hidden" name="menue" value="0">
		<input type="submit" name="back" value="zurück">
	</form>
	</div>
	</th>
</tr>
</tbody>
</table>
</td>
</tr>
<table width="100%">

</table>
</table>
{/block}