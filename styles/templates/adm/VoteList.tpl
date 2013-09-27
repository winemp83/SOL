{include file="overall_header.tpl"}
<table width="90%">
<tr>
	<th colspan="3">Voting Liste</th>
</tr>
<tr>
	<th colspan="3">
	<form action="" method="post">
		<input type="hidden" value="1" name="menue">
		<input type="hidden" value="1" name="step">
		<input type="submit" value="Neuen Vote erstellen" name="vote_create">
	</form>
	</th>
</tr>
{foreach item=vote from=$list}
<tr>
	<td colspan="3"></td>
</tr>
<tr>
	<td colspan="3"></td>
</tr>
<tr>
	<td colspan="3"></td>
</tr>
<tr>
	<td colspan="3">{$vote.question}</td>
</tr>
<tr>
	<th width="20%">Antwort</th>
	<th width="70%">Grafik</th>
	<th width="10%">Prozente</th>
</tr>
<tr>
	<td>{$vote.option_one}</td>
	<th width="70%"><img src='http://test.landoflegends.de/styles/images/red.png' width='{$vote.one}%' height='25px'></img></th>
	<td>{$vote.one}%</td>
</tr>
<tr>
	<td>{$vote.option_two}</td>
	<th width="70%"><img src='http://test.landoflegends.de/styles/images/blue.png' width='{$vote.two}%' height='25px'></img></th>
	<td>{$vote.two}%</td>
</tr>
<tr>
	<td>{$vote.option_tree}</td>
	<th width="70%"><img src='http://test.landoflegends.de/styles/images/silber.png' width='{$vote.tree}%' height='25px'></img></th>
	<td>{$vote.tree}%</td>
</tr>
<tr>
	<th colspan="2">{$LNG.winemp_vote_gesamt}</th>
	<td>{$vote.ig}</td>
</tr>
<tr>
	{if $vote.close != 1}
	<th colspan="3">
	<form action="" method="post">
		<input type="hidden" value="2" name="menue">
		<input type="hidden" value="{$vote.id}" name="vote_id">
		<input type="submit" value="Vote schließen" name="vote_close">
	</form>
	</th>
	{/if}
</tr>
<tr>
	<td colspan="3"></td>
</tr>
<tr>
	<td colspan="3"></td>
</tr>
<tr>
	<td colspan="3"></td>
</tr>
{/foreach}
</table>
{include file="overall_footer.tpl"}