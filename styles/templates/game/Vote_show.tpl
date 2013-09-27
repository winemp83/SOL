{block name="title" prepend}{$LNG.winemp_vote_title}{/block}
{block name="content"}
<table width="200px">
<tbody>
<tr>
<td>

<table>
<tbody>
<tr>
	<th colspan="6">{$LNG.winemp_vote_header}</th>
</tr>



<tr>
	<td>
		<img src="./styles/theme/gow/img/vote.jpg">
	</td>
</tr>
</tbody>
</table>


<table>
<tbody


</tr>
{foreach item=votes from=$vote}
<tr>
	<th colspan="6">{$vote_name}</th>

</tr>
{if $usable}
<form action="" method="post">
<input type="hidden" name="menue" value="1">
<input type="hidden" name="id" value="{$id}">
<tr>
<th width="1%" id=vote_style ><img src='./styles/images/red.png' ></img></th>
	<th width="93%">{$votes.desc_one}</th>
	<td width="5%"> <input type="checkbox" name="select" value="1"><br/>{$votes.option_one}</td>
</tr>
<tr>
<th width="1%" id=vote_style ><img src='./styles/images/blue.png' ></img></th>
	<th width="93%">{$votes.desc_two}</th>
	<td width="5%"> <input type="checkbox" name="select" value="2"><br/>{$votes.option_two}</td>
</tr>
<tr>
<th width="1%" id=vote_style ><img src='./styles/images/silber.png' ></img></th>
	<th width="93%">{$votes.desc_tree}</th>
	<td width="5%"> <input type="checkbox" name="select" value="3"><br/>{$votes.option_tree}</td>
</tr>
<tr>
	<th colspan="6"><input type="submit" name="{$LNG.winemp_vote_submit}" value="{$LNG.winemp_vote_submit}"></th>
</tr>
<form>


{else}
<tr>
<td style="text-align: left;" width="100%">{$votes.desc_one}
	</td>
<th>&nbsp;</th>
</tr>
<tr>
	
	<th width="70%"><img src='./styles/images/red.png' width='{$one}%' height='25px'></img></th>
	<th>{$one}%</th>
</tr>
<tr>
<td style="text-align: left;" width="100%">{$votes.desc_two}
	</td>
<th>&nbsp;</th>
</tr>
<tr>
	
	<th width="70%"><img src='./styles/images/blue.png' width='{$two}%' height='25px'></img></th>
	<th>{$two}%</th>
</tr>
<tr>
<td style="text-align: left;" width="95%">{$votes.desc_tree}
	</td>
<th>&nbsp;</th>
</tr>
<tr>
	
	<th width="70%"><img src='./styles/images/silber.png' width='{$tree}%' height='25px'></img></th>
	<th>{$tree}%</th>
</tr>
<tr>
	<th>{$LNG.winemp_vote_gesamt}</th>
	<td>{$ig}</td>
</tr>
{/if}
{/foreach}
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
{/block}