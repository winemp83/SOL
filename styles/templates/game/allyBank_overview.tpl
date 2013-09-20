{block name="title" prepend}{$LNG.allyBank}{/block}
{block name="content"}

<table>
	<tr>
		<th colspan="2"><span width="100%" align="center">{$LNG.allyBank}</span></th>			
	</tr>
	{if $error_code}
	<tr>
		<th>{$LNG.ally_error_1}</th>
	</tr>
	{else}		
	<tr>
		<td width="33%"><span width="100%" align="center">{$LNG.allyBank_metall}</span></td>
		<td width="67%"><span width="100%" align="center">{$ally_bank_met}</span></td>
	</tr>
	<tr>
		<td width="33%"><span width="100%" align="center">{$LNG.allyBank_kristall}</span></td>
		<td width="67%"><span width="100%" align="center">{$ally_bank_kri}</span></td>
	</tr>
	<tr>
		<td width="33%"><span width="100%" align="center">{$LNG.allyBank_deuterium}</span></td>
		<td width="67%"><span width="100%" align="center">{$ally_bank_deu}</span></td>
	</tr>
	<tr>
		<th colspan="2"><div align="center"><a href="?page=alliBank&mode=in"><span style="color:gold;">{$LNG.allyBank_in}</span></div></a></th>
	</tr>
	{/if}
</table>

{/block}
