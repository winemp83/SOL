
{block name="title" prepend}Member Einladen{/block}
{block name="content"}<table width="70%">
<tbody>
<tr>
	<th  colspan="9"><center>Einladen</center></th>
</tr>
<tr>
	<th width="60%">Name</th>
	<th width="20%">Rank</th>
</tr>
{foreach	item=winner	from=$winners}
<tr>
    <td><a href="game.php?page=convite&username={$winner.user}">{$winner.user}</a></td>
    <td>{$winner.platz}</td>
</tr>
{/foreach}
</tbody>
</table>
{/block}