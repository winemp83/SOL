{block name="title" prepend}{$LNG.winemp_Forum_create_title}{/block}
{block name="content"}
<script type="text/javascript" src="scripts/jQuery.js?v=1829"></script>
<table width="100%">
	<form action="" method="post">
		<input name="menue" value="2" type="hidden">
		<input name="step" value="2" type="hidden">
		<tr>
			<th colspan="2">
				{$LNG.winemp_Forum_create_form}
			</th>
		</tr>
		<tr>
			<th width="40%">
				{$LNG.winemp_Forum_create_form}
			</th>
			<td width="60%">
				<input type="text" name="topicName">
			</td>
		</tr>
		<tr>
			<th>
				{$LNG.winemp_Forum_create_form}
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
</table>
{/block}