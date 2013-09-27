{block name="title" prepend}{$LNG.lm_alliance}{/block}
{block name="content"}
<table class="519">
{if $error == true}
<form action="game.php?page=alliance&mode=buymod" method="post">
<tr>
	<th colspan="4">{$LNG.winemp_alliBonus_buy1}</th>
</tr>
<tr>
	<th width="25%">{$LNG.winemp_alliBonus_name}</th>
	<th width="25%">{$LNG.winemp_alliBonus_akt} / {$LNG.winemp_alliBonus_max}</th>
	<th width="25%">{$LNG.winemp_alliBonus_kosten}</th>
	<th width="25%">{$LNG.winemp_alliBonus_select}</th>
</tr>
<tr>
	<td width="25%" style="text-align:left;">{$LNG.winemp_alliBonus_1}</td>
	<td width="25%">{$one_akt} / {$one_max}</td>
	<td width="25%" style="text-align:right;">{$one_m}{$one_k}{$one_d}</td>
	<td width="25%">{if $deakt_one}<span style="color:red;"><b>{$LNG.winemp_alliBonus_deaktiviert}</b></span>{else}<input type="radio" name="what" value="1">{/if}</td>
</tr>
<tr>
	<td width="25%" style="text-align:left;">{$LNG.winemp_alliBonus_2}</td>
	<td width="25%">{$two_akt} / {$two_max}</td>
	<td width="25%" style="text-align:right;">{$two_m}{$two_k}{$two_d}</td>
	<td width="25%">{if $deakt_two}<span style="color:red;"><b>{$LNG.winemp_alliBonus_deaktiviert}</b></span>{else}<input type="radio" name="what" value="2">{/if}</td>
</tr>
<tr>
	<td width="25%" style="text-align:left;">{$LNG.winemp_alliBonus_3}</td>
	<td width="25%">{$tree_akt} / {$tree_max}</td>
	<td width="25%" style="text-align:right;">{$tree_m}{$tree_k}{$tree_d}</td>
	<td width="25%">{if $deakt_tree}<span style="color:red;"><b>{$LNG.winemp_alliBonus_deaktiviert}</b></span>{else}<input type="radio" name="what" value="3">{/if}</td>
</tr>
<tr>
	<td width="25%" style="text-align:left;">{$LNG.winemp_alliBonus_4}</td>
	<td width="25%">{$four_akt} / {$four_max}</td>
	<td width="25%" style="text-align:right;">{$four_m}{$four_k}{$four_d}</td>
	<td width="25%">{if $deakt_four}<span style="color:red;"><b>{$LNG.winemp_alliBonus_deaktiviert}</b></span>{else}<input type="radio" name="what" value="4">{/if}</td>
</tr>
<tr>
	<td width="25%" style="text-align:left;">{$LNG.winemp_alliBonus_5}</td>
	<td width="25%">{$five_akt} / {$five_max}</td>
	<td width="25%" style="text-align:right;">{$five_m}{$five_k}{$five_d}</td>
	<td width="25%">{if $deakt_five}<span style="color:red;"><b>{$LNG.winemp_alliBonus_deaktiviert}</b></span>{else}<input type="radio" name="what" value="5">{/if}</td>
</tr>
<tr>
	<td width="25%" style="text-align:left;">{$LNG.winemp_alliBonus_6}</td>
	<td width="25%">{$six_akt} / {$six_max}</td>
	<td width="25%" style="text-align:right;">{$six_m}{$six_k}{$six_d}</td>
	<td width="25%">{if $deakt_six}<span style="color:red;"><b>{$LNG.winemp_alliBonus_deaktiviert}</b></span>{else}<input type="radio" name="what" value="6">{/if}</td>
</tr>
<tr>
	<td width="25%" style="text-align:left;">{$LNG.winemp_alliBonus_7}</td>
	<td width="25%">{$seven_akt} / {$seven_max}</td>
	<td width="25%" style="text-align:right;">{$seven_m}{$seven_k}{$seven_d}</td>
	<td width="25%">{if $deakt_seven}<span style="color:red;"><b>{$LNG.winemp_alliBonus_deaktiviert}</b></span>{else}<input type="radio" name="what" value="7">{/if}</td>
</tr>
<tr>
	<th colspan="4"><div width="100%" align="center"><input type="submit" value="{$LNG.winemp_alliBonus_submit2}"></div></th>
</tr>
</form>
{else}
<tr>
	<th>{$LNG.winemp_alliBonus_buy1}</th>
</tr>
<tr>
	<td>{$msg}</td>
</tr>
<tr>
	<th><a href="game.php?page=alliance&amp;mode=buyModul">{$LNG.al_back}</a></th>
</tr>
{/if}
</table>
{/block}