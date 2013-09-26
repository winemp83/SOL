{block name="title" prepend}{$LNG.winemp_vote_title}{/block}
{block name="content"}
<table width="200px">
<tr>
	<th colspan="2">{$LNG.winemp_vote_header}</th>
</tr>
{foreach item=votes from=$vote}
<tr>
	<th colspan="2">{$vote_name}</th>
</tr>
{if $usable}
<form action="" method="post">
<input type="hidden" name="menue" value="1">
<input type="hidden" name="id" value="{$id}">
<tr>
	<th width="95%">{$votes.desc_one}</th>
	<td width="5%"> <input type="checkbox" name="select" value="1"><br/>{$votes.option_one}</td>
</tr>
<tr>
	<th width="95%">{$votes.desc_two}</th>
	<td width="5%"> <input type="checkbox" name="select" value="2"><br/>{$votes.option_two}</td>
</tr>
<tr>
	<th width="95%">{$votes.desc_tree}</th>
	<td width="5%"> <input type="checkbox" name="select" value="3"><br/>{$votes.option_tree}</td>
</tr>
<tr>
	<th colspan="2"><input type="submit" name="{$LNG.winemp_vote_submit}" value="{$LNG.winemp_vote_submit}"></th>
</tr>
<form>
<tr>
	<th width="95%"><img src='http://test.landoflegends.de/styles/images/red.png' width='{$one}%' height='25px'></img></th>
	<th>{$one}%</th>
</tr>
<tr>
	<th width="95%"><img src='http://test.landoflegends.de/styles/images/blue.png' width='{$two}%' height='25px'></img></th>
	<th>{$two}%</th>
</tr>
<tr>
	<th width="95%"><img src='http://test.landoflegends.de/styles/images/silber.png' width='{$tree}%' height='25px'></img></th>
	<th>{$tree}%</th>
</tr>
<tr>
	<th>{$LNG.winemp_vote_gesamt}</th>
	<td>{$ig}</td>
</tr>
{else}
<tr>
	<th width="95%"><img src='http://test.landoflegends.de/styles/images/red.png' width='{$one}%' height='25px'></img></th>
	<th>{$one}%</th>
</tr>
<tr>
	<th width="95%"><img src='http://test.landoflegends.de/styles/images/blue.png' width='{$two}%' height='25px'></img></th>
	<th>{$two}%</th>
</tr>
<tr>
	<th width="95%"><img src='http://test.landoflegends.de/styles/images/silber.png' width='{$tree}%' height='25px'></img></th>
	<th>{$tree}%</th>
</tr>
<tr>
	<th>{$LNG.winemp_vote_gesamt}</th>
	<td>{$ig}</td>
</tr>
{/if}
{/foreach}
</table>
{/block}