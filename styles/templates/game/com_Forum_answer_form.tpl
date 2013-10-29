{block name="title" prepend}{$LNG.winemp_Forum_forum_title}{/block}
{block name="content"}
<script type="text/javascript" src="scripts/jQuery.js?v=1829"></script>


<table style="width:700px; background-color: #000000;">
<tbody>
<tr>
	<th colspan="2">
		Space of Legends Forum 
	</th>
	<th>
	<form action="" method="post">
		<input type="hidden" name="menue" value="0">
		<input type="submit" name="back" value="Zurück">
	</form>
	</th>
	<th>
		<div width="100%" align="center"></div>
	</th>
	<th>
		<div width="100%" align="right">Thema: {$top_name}</div>
	</th>
</tr>
<tr>
	<td colspan="5">
		<img alt="" src="./styles/theme/gow/img/forumpic.jpg">
	</td>
</tr>
<tr>
{if $edit}
	<td colspan="5">
	<table style="width:950px;">
		<tbody>
		<form action="" method="post">
		<input name="menue" value="8" type="hidden">
		<input name="step" value="2" type="hidden">
		<input type="hidden" name="ans_id" value="{$ans_id}">
		<input name="topic_id" value="{$top_id}" type="hidden">
		<tr>
			<th colspan="2">
				{$LNG.winemp_Forum_create_formA}
			</th>
		</tr>
		<tr>
			<th>
				{$LNG.winemp_Forum_create_formC}
			</th>
			<td width="60%">
				<textarea name="text" cols="50" rows="10">{$text}</textarea>
			</td>
		</tr>
		{if $adm}
		<tr>
			<th>Als Admin schreiben </th>
			<td><input type="checkbox" name="team" value="1"></td>
		</tr>
		{/if}
		<tr>
			<th colspan="2">
				<input type="submit" value="{$LNG.winemp_Forum_create_submit}" name="{$LNG.winemp_Forum_create_submit}">
			</th>
		</tr>
	</form>
		</tbody>
	</table>
	</td>
{else}
	<td colspan="5">
	<table style="width:950px;">
		<tbody>
		<form action="" method="post">
		<input name="menue" value="4" type="hidden">
		<input name="step" value="2" type="hidden">
		<input type="hidden" name="ans_id" value="{$ans_id}">
		<input name="topic_id" value="{$top_id}" type="hidden">
		<tr>
			<th colspan="2">
				{$LNG.winemp_Forum_create_formA}
			</th>
		</tr>
		<tr>
			<th>
				{$LNG.winemp_Forum_create_formC}
			</th>
			<td width="60%">
				<textarea name="text" cols="50" rows="10"></textarea>
			</td>
		</tr>
		{if $adm}
		<tr>
			<th>Als Admin schreiben </th>
			<td><input type="checkbox" name="team" value="1"></td>
		</tr>
		{/if}
		<tr>
			<th colspan="2">
				<input type="submit" value="{$LNG.winemp_Forum_create_submit}" name="{$LNG.winemp_Forum_create_submit}">
			</th>
		</tr>
	</form>
		</tbody>
	</table>
	</td>
	{/if}
</tr>
<table width="100%">

</table>
</table>
{/block}