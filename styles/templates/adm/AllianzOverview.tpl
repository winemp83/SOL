{include file="overall_header.tpl"}
<table style=" background-color: #000000;">
<tbody>
<tr>
{if $member_show == 1}
{foreach item=member from=$members}
<td>
<table style="width:950px;">
<tbody>
<tr>
	<th colspan="5">
	{$alli_name}
	</th>
</tr>
<table>
	<table width="90%">
		<tr>
			<th width="10%">ID</th>
			<th width="30%">Name</th>
			<th width="10%">Rank</th>
			<th width="20%">Punkte</th>
			<th width="15%">Letztes Login</th>
			<th width="15%">Allianz Eintritts Datum</th>
		</tr>
		 	<td width="10%">{$member.id}</td>
			<td width="30%">{$member.name}</td>
			<td width="10%">{$member.rank}</td>
			<td width="20%">{$member.points}</td>
			<td width="15%">{$member.last_online}</th>
			<td width="15%">{$member.ally_reg}</td>
		<tr>
		</tr>
	</table>
</table>
{/foreach}
{else}
{foreach item=alli from=$list}
<td>
<table style="width:950px;">
<tbody>
<tr>
	<th colspan="5">
	{$alli.a_name}
	</th>
</tr>



<table>




	
		<table width="90%">
			
			<tr>
			 	<th>ALLIANZ ID</th>
			 	<th>ALLIANZ NAME</th>
			 	<th>ALLIANZ TAG</th>
			 	<th>ALLIANZ OWNER</th>
			</tr>
			<tr>
				<td>{$alli.a_id}</td>
			 	<td>{$alli.a_name}</td>
			 	<td>{$alli.a_tag}</td>
			 	<td>{$alli.a_owner}</td>
			 </tr>
			 <tr>
			 	<th colspan="4">
			 		<table width="95%">
			 			<tr>
			 				<th>Mitglieder</th>
			 				<th>Maximale Mitglieder</th>
			 				<th>Topics</th>
			 				<th>Maximale Topics</th>
			 			</tr>
			 			<tr>
			 				<td>{$alli.a_akt_u}</td>
			 				<td>{$alli.a_max_u}</td>
			 				<td>{$alli.a_akt_t}</td>
			 				<td>{$alli.a_max_t}</td>
			 			</tr>
			 		</table>
			 	</th>
			 </tr>
			 <tr>
			 	<th colspan="4">
			 	<table width="95%">
			 		<tr>
			 			<th colspan="2">ALLIANZ METALL</th>
			 			<th colspan="3">ALLIANZ KRISTALL</th>
			 			<th colspan="2">ALLIANT DEUTERIUM</th>
			 		</tr>
			 		<tr>
			 			<td colspan="2">{$alli.a_met}</td>
			 			<td colspan="3">{$alli.a_kri}</td>
			 			<td colspan="2">{$alli.a_deu}</td>
			 		</tr>
			 		<tr>
			 			<th colspan="7">ALLIANZ BONI</th>
			 		</tr>
			 		<tr>
			 			<table width="100%">
			 				<tr>
			 					<th width="14%">PRODUKTION</th>
			 					<th width="14%">FORSCHUNG</th>
			 					<th width="14%">GEBÄUDE</th>
			 					<th width="14%">ANGRIFF</th>
			 					<th width="14%">VERTEIDIGUNG</th>
			 					<th width="14%">SLOTS</th>
			 					<th width="14%">THEMEN</th>
			 				</tr>
			 				<tr>
			 					<td width="14%">{$alli.a_bo_pro} %</td>
			 					<td width="14%">{$alli.a_bo_res} %</td>
			 					<td width="14%">{$alli.a_bo_bui} %</td>
			 					<td width="14%">{$alli.a_bo_atk} %</td>
			 					<td width="14%">{$alli.a_bo_def} %</td>
			 					<td width="14%">{$alli.a_bo_slo}</td>
			 					<td width="14%">{$alli.a_bo_top}</td>
			 				</tr>
			 			</table>
			 		</tr>
			 		<tr>
			 			<td colspan="1">
			 			<form action="" method="post">
			 				<input type="hidden" name="menue" value="1">
			 				<input type="hidden" name="ally_id" value="{$alli.a_id}">
			 				<input type="submit" name="show_members" value="Allianz Mitglieder anzeigen">
			 			</form>
			 			</td>
			 			<th colspan="3"></th>
			 		</tr>
			 	</table> 
			 	</th>
			 </tr>
		
		<table>
{/foreach}
{/if}
</table>	
</table>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="100%">
</table>
{include file="overall_footer.tpl"}