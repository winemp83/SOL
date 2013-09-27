{block name="title" prepend}{$LNG.lm_alliance}{/block}
{block name="content"}
<table class="519">
{if $error == true}
{$LNG.winemp_alliBonus_error}
{else}
<form action="game.php?page=alliance&mode=buymod" method="post">
<input type="hidden" name="buy" value="true">
<tr>
	<th colspan="3">{$LNG.winemp_alliBonus_buy}</th>
</tr>
<tr>
	<td width="35%">{$LNG.winemp_alliBonus_name}</td>
	<td width="20%">{$LNG.winemp_alliBonus_akt} / {$LNG.winemp_alliBonus_max}</td>
	<td width="45%">{$LNG.winemp_alliBonus_kosten}</td>
</tr>
<tr>
	<td width="35%">{$LNG.winemp_alliBonus_1}</td>
	<td width="20%">{$one_akt} / {$one_max}</td>
	<td width="45%">{if $deakt_one} <span style="color:red;"><b>{$LNG.winemp_alliBonus_deaktiviert}</b></span>{else}{$one_m}{$one_k}{$one_d}{/if}</td>
</tr>
<tr>
	<td width="35%">{$LNG.winemp_alliBonus_2}</td>
	<td width="20%">{$two_akt} / {$two_max}</td>
	<td width="45%">{if $deakt_two} <span style="color:red;"><b>{$LNG.winemp_alliBonus_deaktiviert}</b></span>{else}{$two_m}{$two_k}{$two_d}{/if}</td>
</tr>
<tr>
	<td width="35%">{$LNG.winemp_alliBonus_3}</td>
	<td width="20%">{$tree_akt} / {$tree_max}</td>
	<td width="45%">{if $deakt_tree} <span style="color:red;"><b>{$LNG.winemp_alliBonus_deaktiviert}</b></span>{else}{$tree_m}{$tree_k}{$tree_d}{/if}</td>
</tr>
<tr>
	<td width="35%">{$LNG.winemp_alliBonus_4}</td>
	<td width="20%">{$four_akt} / {$four_max}</td>
	<td width="45%">{if $deakt_four} <span style="color:red;"><b>{$LNG.winemp_alliBonus_deaktiviert}</b></span>{else}{$four_m}{$four_k}{$four_d}{/if}</td>
</tr>
<tr>
	<td width="35%">{$LNG.winemp_alliBonus_5}</td>
	<td width="20%">{$five_akt} / {$five_max}</td>
	<td width="45%">{if $deakt_five} <span style="color:red;"><b>{$LNG.winemp_alliBonus_deaktiviert}</b></span>{else}{$five_m}{$five_k}{$five_d}{/if}</td>
</tr>
<tr>
	<td width="35%">{$LNG.winemp_alliBonus_6}</td>
	<td width="20%">{$six_akt} / {$six_max}</td>
	<td width="45%">{if $deakt_six} <span style="color:red;"><b>{$LNG.winemp_alliBonus_deaktiviert}</b></span>{else}{$six_m}{$six_k}{$six_d}{/if}</td>
</tr>
<tr>
	<td width="35%">{$LNG.winemp_alliBonus_7}</td>
	<td width="20%">{$seven_akt} / {$seven_max}</td>
	<td width="45%">{if $deakt_seven} <span style="color:red;"><b>{$LNG.winemp_alliBonus_deaktiviert}</b></span>{else}{$seven_m}{$seven_k}{$seven_d}{/if}</td>
</tr>
<tr>
	<td colspan="3"><input type="submit" value="{$LNG.winemp_alliBonus_submit1}"></td>
</tr>
<tr>
	<th colspan="3"><a href="game.php?page=alliance&amp;mode=admin">{$LNG.al_back}</a></th>
</tr>
</form>
{/if}
</table>
{/block}