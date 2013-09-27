{include file="overall_header.tpl"}
<table width="90%">
<tr>
	<th colspan="2">Voting Liste</th>
</tr>
<tr>
	<th colspan="2">
	<form action="" method="post">
		<input type="hidden" value="1" name="menue">
		<input type="submit" value="Neuen Vote erstellen" name="vote_create">
	</form>
	</th>
</tr>
{foreach item=vote from=$list}
<tr>
	<td colspan="2"></td>
</tr>
<tr>
	<td colspan="2"></td>
</tr>
<tr>
	<td colspan="2"></td>
</tr>
<tr>
	<th width="95%"><img src='http://test.landoflegends.de/styles/images/red.png' width='{$vote.one}%' height='25px'></img></th>
	<td>{$vote.one}%</td>
</tr>
<tr>
	<th width="95%"><img src='http://test.landoflegends.de/styles/images/blue.png' width='{$vote.two}%' height='25px'></img></th>
	<td>{$vote.two}%</td>
</tr>
<tr>
	<th width="95%"><img src='http://test.landoflegends.de/styles/images/silber.png' width='{$vote.tree}%' height='25px'></img></th>
	<td>{$vote.tree}%</td>
</tr>
<tr>
	<th>{$LNG.winemp_vote_gesamt}</th>
	<td>{$vote.ig}</td>
</tr>
<tr>
	{if $vote.close != 1}
	<th colspan="2">
	<form action="" method="post">
		<input type="hidden" value="2" name="menue">
		<input type="hidden" value="{$vote.id}" name="vote_id">
		<input type="submit" value="Vote schließen" name="vote_close">
	</form>
	</th>
	{/if}
</tr>
<tr>
	<td colspan="2"></td>
</tr>
<tr>
	<td colspan="2"></td>
</tr>
<tr>
	<td colspan="2"></td>
</tr>
{/foreach}
</table>
{include file="overall_footer.tpl"}