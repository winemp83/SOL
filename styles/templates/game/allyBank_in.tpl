{block name="title" prepend}{$LNG.bank}{/block}
{block name="content"}
<script type="text/javascript" src="scripts/jQuery.js?v=1829"></script>
<table>
<form action="" method="post">
<input name="action" value="in" type="hidden">
<tr>
	<th colspan="2"><span style="color:gold;">{$LNG.allyBank_in_overview}</span></th>
</tr>
<tr>
	<td width="33%">{$LNG.allyBank_metall}</td>
	<td width="67%">{$ally_bank_met}</td>
</tr>
<tr>
	<td width="33%">{$LNG.allyBank_kristall}</td>
	<td width="67%">{$ally_bank_kri}</td>
</tr>
<tr>
	<td width="33%">{$LNG.allyBank_deuterium}</td>
	<td width="67%">{$ally_bank_deu}</td>
</tr>
<tr>
	<th colspan="2"><span style="color:gold;">{$LNG.allyBank_in_header}</span></th>
</tr>
<tr>
	<td>{$LNG.allyBank_metall}</td>
	<td><input name="metal" value="0" type="text"></td>
</tr>
<tr>
	<td>{$LNG.allyBank_kristall}</td>
	<td><input name="kryst" value="0" type="text"></td>
</tr>
<tr>
	<td>{$LNG.allyBank_deuterium}</td>
	<td><input name="deuta" value="0" type="text"></td>
</tr>
<tr>
	<th colspan="2"><div align="center"><input value="{$LNG.allyBank_in_payin}" type="submit" style="color:black;font-weight:bold;background:gold;"></div></th>
</tr>
</form>
</table>
{/block}