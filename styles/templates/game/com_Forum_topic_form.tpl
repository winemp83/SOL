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
		<div width="100%" align="right">Kategorie: {$kat_name}</div>
	</th>
</tr>
<tr>
	<td colspan="5">
		<img alt="" src="./styles/theme/gow/img/forumpic.jpg">
	</td>
</tr>
<tr>
	<td colspan="5">
	<table style="width:950px;">
		<tbody>
		<form action="" method="post">
		<input name="menue" value="3" type="hidden">
		<input name="step" value="2" type="hidden">
		<input name="kat_id" value="{$kat}" type="hidden">
		<input name="kat_name" value"{$kat_name}" type="hidden">
		<tr>
			<th colspan="2">
				{$LNG.winemp_Forum_create_formA}
			</th>
		</tr>
		<tr>
			<th width="40%">
				{$LNG.winemp_Forum_create_formB}
			</th>
			<td width="60%">
				<input type="text" name="topicName">
			</td>
		</tr>
		<tr>
			<th>
				{$LNG.winemp_Forum_create_formC}
			</th>
			<td width="60%">
				<textarea name="text" cols="50" rows="10"></textarea>
			</td>
		</tr>
		<tr>
			<th colspan="2">
				<input type="submit" value="{$LNG.winemp_Forum_create_submit}" name="{$LNG.winemp_Forum_create_submit}">
			</th>
		</tr>
	</form>
		</tbody>
	</table>
	</td>
</tr>
<table width="100%">

</table>
</table>
{/block}