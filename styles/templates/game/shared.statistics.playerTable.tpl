<tr>
	<th style="width:60px;">{$LNG.st_position}</th>
	<th>{$LNG.st_player}</th>
	<th>&nbsp;</th>
	<th>{$LNG.st_alliance}</th>
	<th>{$LNG.st_points}</th>
	<th>Onlinestatus</th>
</tr>
{foreach name=RangeList item=RangeInfo from=$RangeList}
<tr>
	<td><a class="tooltip" data-tooltip-content="{if $RangeInfo.ranking == 0}<span style='color:#87CEEB'>*</span>{elseif $RangeInfo.ranking < 0}<span style='color:red'>-{$RangeInfo.ranking}</span>{elseif $RangeInfo.ranking > 0}<span style='color:green'>+{$RangeInfo.ranking}</span>{/if}">{$RangeInfo.rank}</a></td>
	<td><a href="#" onclick="return Dialog.Playercard({$RangeInfo.id}, '{$RangeInfo.name}');"{if $RangeInfo.id == $CUser_id} style="color:lime"{/if}>{$RangeInfo.name}</a></td>
	<td>{if $RangeInfo.id != $CUser_id}<a href="#" onclick="return Dialog.PM({$RangeInfo.id});"><img src="{$dpath}img/m.gif" title="{$LNG.st_write_message}" alt="{$LNG.st_write_message}"></a>{/if}</td>
	<td>{if $RangeInfo.allyid != 0}<a href="game.php?page=alliance&amp;mode=info&amp;id={$RangeInfo.allyid}">{if $RangeInfo.allyid == $CUser_ally}<span style="color:#33CCFF">{$RangeInfo.allyname}</span>{else}{$RangeInfo.allyname}{/if}</a>{else}-{/if}</td>
	<td>{$RangeInfo.points}</td>
	{if $RangeInfo.authlvl != 3}
	<td>{if $RangeInfo.allyid != 0}{if $RangeInfo.online == "-"}-{else}{if $RangeInfo.online > ($RangeInfo.TIMESTAMP - 15 * 60 )}<span style="color:lime">Online</span>{else}<span style="color:red">Offline</span>{/if}{/if}{else}-{/if}</td>
	{else}
	<td>{if $RangeInfo.online > ($RangeInfo.TIMESTAMP - 15 * 60 )}<span style="color:lime">Online</span>{else}<span style="color:red">Offline</span>{/if}</td>
	{/if}
</tr>
{/foreach}