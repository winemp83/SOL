{block name="title" prepend}{$LNG.allyBonus}{/block}
{block name="content"}
<table>
	<tr>
		<th colspan="2"><span width="100%" align="center">{$LNG.allyBonus}</span></th>			
	</tr>
	{if $err}
	<tr>
		<th>{$LNG.ally_bonus_error_1}</th>
	</tr>
	{else}		
	<tr>
		<td width="33%"><span width="100%" align="center">{$LNG.allyBonus_Produktion}</span></td>
		<td width="67%"><span width="100%" align="center">{$pro}</span></td>
	</tr>
	<tr>
		<td width="33%"><span width="100%" align="center">{$LNG.allyBonus_Research}</span></td>
		<td width="67%"><span width="100%" align="center">{$res}</span></td>
	</tr>
	<tr>
		<td width="33%"><span width="100%" align="center">{$LNG.allyBonus_Building}</span></td>
		<td width="67%"><span width="100%" align="center">{$bui}</span></td>
	</tr>
	<tr>
		<td width="33%"><span width="100%" align="center">{$LNG.allyBonus_Slots}</span></td>
		<td width="67%"><span width="100%" align="center">{$slo}</span></td>
	</tr>
	<tr>
		<td width="33%"><span width="100%" align="center">{$LNG.allyBonus_Defense}</span></td>
		<td width="67%"><span width="100%" align="center">{$def}</span></td>
	</tr>
	<tr>
		<td width="33%"><span width="100%" align="center">{$LNG.allyBonus_Attack}</span></td>
		<td width="67%"><span width="100%" align="center">{$atk}</span></td>
	</tr>
	{/if}
	{if $owner}
	<tr>
		<th colspan="2"><div align="center"><a href="?page=alliBank&mode=buy"><span style="color:gold;">{$LNG.allyBonus_buy}</span></div></a></th>
	</tr>
	{/if}
</table>
{/block}