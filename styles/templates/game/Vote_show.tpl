{block name="title" prepend}{$LNG.winemp_vote_title}{/block}
{block name="content"}
<table>
<tr>
	<th colspan="2">{$LNG.winemp_vote_header}</th>
</tr>
{foreach item=votes form=$vote}
<tr>
	<th colspan="2">{$vote_name}<th>
</tr>
{if useable}
<form action="" method="post">
<input type="hidden" name="menue" value="2">
<input type="hidden" name="id" value="{$id}">
<tr>
	<th width="95%">{$votes.desc_one}</th>
	<td width="5%"> <input type="checkbox" name="select" value="1">{$votes.option_one}</td>
</tr>
<tr>
	<th width="95%">{$votes.desc_two}</th>
	<td width="5%"> <input type="checkbox" name="select" value="2">{$votes.option_two}</td>
</tr>
<tr>
	<th width="95%">{$votes.desc_tree}</th>
	<td width="5%"> <input type="checkbox" name="select" value="3">{$votes.option_tree}</td>
</tr>
<tr>
	<th colspan="2"><input type="submit" name="{$LNG.winemp_vote_submit}" value="{$LNG.winemp_vote_submit}"></th>
</tr>
<form>
{else}
<tr>
	<td width="100%"><div style="background:red;color:gold;" width="{$one}%"></div></td>
</tr>
<tr>
	<td width="100%"><div style="background:silver;color:gold;" width="{$two}%"></div></td>
</tr>
<tr>
	<td width="100%"><div style="background:green;color:gold;" width="{$tree}%"></div></td>
</tr>
</tr>
{/if}
{/foreach}
</table>
{/block}