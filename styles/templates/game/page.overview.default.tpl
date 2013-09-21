{block name="title" prepend}{$LNG.lm_overview}{/block}
{block name="script" append}{/block}
{block name="content"}
<script type="text/javascript" src="././././scripts/game/domtab.js"></script>

<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
	</script>
<table class="table519" style="background: transparent;">
	<tbody>
		<tr>
			<th colspan="6" style="text-align:center;color:gold;" class="servertime"> {$servertime1} <span style="color:silver;">{$servertime2}</span> </th> </tr>
		{if $messages}

		<tr>
			<td colspan="6"><a href="?page=messages">{$messages}</a></td>
		</tr>
		{/if}
		<tr>
			<td colspan="1">Gamer online:</td>
			<td colspan="5">{$online}</td>
		</tr> 
{* Spezial-Event-Mod 1.7.2  Start *} 
    <tr>
		<th>{$eventplaneten}</th>
        {$aktiv_ev}
     </tr> 
{* Spezial-Event-Mod 1.7.2  / End*} 
		{if !empty($chatOnline)}
		<tr>
			<td colspan="1" style="white-space: nowrap;">{$LNG.ov_chat_online}</td>
			<td colspan="5">{foreach $chatOnline as $Name}{if !$Name@first},&nbsp;{/if}<a href="?page=chat">{$Name}</a>{/foreach}</td>
		</tr>
		{/if}
		<tr>
			<td colspan="1" style="white-space: nowrap;">{$LNG.ov_admins_online}</td>
			<td colspan="5">{foreach $AdminsOnline as $ID => $Name}{if !$Name@first}&nbsp;&bull;&nbsp;{/if}<a href="#" onclick="return Dialog.PM({$ID})">{$Name}</a>{foreachelse}{$LNG.ov_no_admins_online}{/foreach}</td>
		</tr>
<tr>
<td colspan="1">{$LNG.ov_marktp}</td>
<td colspan="5"><a href="game.php?page=market" style="color:yellow"> {$LNG['an_lotsum']} {$ddd}</a></td>
</tr>

	{if $teamspeakData !== false}
	<tr>
		<td colspan="1">{$LNG.ov_teamspeak}</td>
		<td colspan="5">{if $teamspeakData.error}{$teamspeakData.error}{else}<a href="{$teamspeakData.url}">{$LNG.ov_teamspeak_connect}</a> &bull; {$LNG.ov_teamspeak_online}: {$teamspeakData.current}/{$teamspeakData.max}{/if}</td>
	</tr>
	{/if}


<table style="background: transparent" class="table519">
	<tbody><tr>
		<td>



<div class="domtab">
<ul class="domtabs">
<li><a href="#t1">{$LNG.ov_events}</a></li>
<li><a href="#t2">{$LNG.lm_overview}</a></li>
<li><a href="#t3">{$LNG.bu_partners}</a></li>
<li><a href="#t4">{$LNG.ov_reflink}</a></li>
<li><a href="#t5">{$LNG.lm_malli}</a></li>


</ul>
<div style="background: transparent;"> <a name="t4" id="t4"></a>

	<table style="width: 100%; background: transparent;">						

									{if $ref_active}
	<tr>
		<th colspan="6"  >{$LNG.ov_reflink}</th>
	</tr>
	<tr>
		<td colspan="6"><input type="text" value="{$path}index.php?ref={$userid}" readonly="readonly" style="width:450px;"></td>
	</tr>
	{foreach $RefLinks as $RefID => $RefLink}
	<tr>
		<td colspan="3"><a href="#" onclick="return Dialog.Playercard({$RefID}, '{$RefLink.username}');">{$RefLink.username}</a></td>
		<td colspan="3">{{$RefLink.points|number}} / {$ref_minpoints|number}</td>
	</tr>
	{foreachelse}
	<tr>
		<td colspan="6">{$LNG.ov_noreflink}</td>
	</tr>
	{/foreach}
	{/if}
						</table></div>


<div style="background: transparent;"> <a name="t3" id="t3"></a>
						<table style="width: 100%;">
							<tbody><tr>
								<tr><th colspan="6" style="text-align:center"> {$LNG.bu_anfrage} </th></tr>
    {foreach $otherRequestList as $otherRequestID => $otherRequestRow}
    <tr>
        <td><a href="#" onclick="return Dialog.PM({$otherRequestRow.id});">{$otherRequestRow.username}</a></td>
        <td><a href="game.php?page=buddyList&amp;mode=accept&amp;id={$otherRequestID}">{$LNG.bu_accept}</a>
        <br><a href="game.php?page=buddyList&amp;mode=delete&amp;id={$otherRequestID}">{$LNG.bu_decline}</a></td>
    </tr>
    {foreachelse}
    <tr><td colspan="6">{$LNG.bu_no_request}</td></tr>
    {/foreach}
    <tr><th colspan="6" style="text-align:left">{$LNG.bu_partners}</th></tr>
    {foreach $myBuddyList as $myBuddyID => $myBuddyRow}
    <tr>
        <td><a href="#" onclick="return Dialog.PM({$myBuddyRow.id});">{$myBuddyRow.username}</a></td>
        <td>
        {if $myBuddyRow.onlinetime < 4}
        <span style="color:lime">{$LNG.bu_connected}</span>
        {elseif $myBuddyRow.onlinetime >= 4 && $myBuddyRow.onlinetime <= 15}
        <span style="color:yellow">{$myBuddyRow.onlinetime} {$LNG.bu_minutes}</span>
        {else}
        <span style="color:red">{$LNG.bu_disconnected}</span>
        {/if}
        </td>
        <td><a href="game.php?page=buddyList&amp;mode=delete&amp;id={$myBuddyID}">{$LNG.bu_delete}</a></td>
    </tr>
    {foreachelse}
    <tr><td colspan="6">{$LNG.bu_no_buddys}</td></tr>
    {/foreach}
    </tr>
    </tr>
						</tbody></table>
					</div>


<div style="background: transparent;"> <a name="t2" id="t2"></a>
						<table style="width: 100%; background: transparent;">
						<tbody><tr>
							<tabel>
<th colspan="6" style="text-align:center;">{$LNG.ov_oaktplan}</th> 


<tr id='system3'>
	<th width="5%">{$LNG.ov_ocor}</th>
	<th width="20%">{$LNG.ov_oname}</th>
	<th width="30%">{$LNG.ov_ogeb}</th>
	<th width="25%">{$LNG.ov_ofors}</th>
	<th width="20%">{$LNG.ov_owerft}</th>
</tr>

<tr id='system3'>
	<td width="5%" style="background: transparent;" ><a href="game.php?page=galaxy&amp;galaxy={$galaxy}&amp;system={$system}">[{$galaxy}:{$system}:{$planet}]</a></td>
	<td width="20%" style="background: transparent;">{$planetname}</td>
	<td  width="30%" style="background: transparent; width: 10%; text-align:left;" >{if $buildInfo.buildings}{$LNG.tech[$buildInfo.buildings['id']]} ({$buildInfo.buildings['level']})<br><div class="timer" style="background: transparent; width: 30%; text-align:left;" data-time="{$buildInfo.buildings['timeleft']}"><b>{$buildInfo.buildings['starttime']}</b></div>{else}{$LNG.ov_free}{/if}</td> 
	<td  width="25%" style="background: transparent; width: 10%; text-align:left;" >{if $buildInfo.tech}{$LNG.tech[$buildInfo.tech['id']]} ({$buildInfo.tech['level']})<br><div class="timer" style="background: transparent; width: 20%; text-align:left; " data-time="{$buildInfo.tech['timeleft']}"{$buildInfo.tech['starttime']}</div>{else}{$LNG.ov_free}{/if}</td>			
	<td  width="20%"style="background: transparent; width: 10%; text-align:left;" >{if $buildInfo.fleet}{$LNG.tech[$buildInfo.fleet['id']]} ({$buildInfo.fleet['level']})<br><div class="timer" style="background: transparent; width: 20%; text-align:left;" data-time="{$buildInfo.fleet['timeleft']}">{$buildInfo.fleet['starttime']}</div>{else}<p>{$LNG.ov_free}{/if}</td>
  
	
</tr>

<th colspan="6" style="text-align:center;">{$LNG.ov_oplanetena}</th> 


<tr id='system3'>
	<th width="5%">{$LNG.ov_ocor}</th>
	<th width="20%">{$LNG.ov_oname}</th>
	<th width="30%">{$LNG.ov_ogeb}</th>
	<th width="25%">{$LNG.ov_owerft}</th>
        <th width="20%">{$LNG.ov_oauswahl}</th>

</tr>
{foreach $AllPlanets as $PlanetRow}
<tr id='system3'>
	<td width="5%" style="background: transparent;">[{$PlanetRow.coordsa}.{$PlanetRow.coordsb}.{$PlanetRow.coordsc}]</td>
	<td width="20%" style="background: transparent;"><a href="game.php?page=overview&amp;cp={$PlanetRow.id}">{$PlanetRow.name}</a></td>
	<td width="30%" style="background: transparent;"> {$PlanetRow.build} </td> 
	<td width="25%" style="background: transparent;"> </td>
	<td width="20%" style="background: transparent;"> <a href="game.php?page=overview&amp;cp={$PlanetRow.id}"><img src='./styles/theme/gow/img/switch.png' width='88px' height='31px' border='0'></a> </td>			

       {if $PlanetRow@last && $PlanetRow@total > 1 && ($PlanetRow@iteration % $themeSettings.PLANET_ROWS_ON_OVERVIEW) !== 0} 
       {$to = $themeSettings.PLANET_ROWS_ON_OVERVIEW - ($PlanetRow@iteration % $themeSettings.PLANET_ROWS_ON_OVERVIEW)}
       {for $foo=1 to $to}
       {/for}
       {/if}
	
</tr>
{/foreach}
</tabel>
					</tbody></table>
					</div>

<div style="background: transparent;">
<div style="background: transparent;"> <a name="t1" id="t1"></a>
											<table style="width: 100%; background: transparent;">
<tr>
		<th colspan="3">{$LNG.ov_events}  
	</tr>
	{foreach $fleets as $index => $fleet}
	<tr>
		<td id="fleettime_{$index}" class="fleets" data-fleet-end-time="{$fleet.returntime}" data-fleet-time="{$fleet.resttime}">{pretty_fly_time({$fleet.resttime})}</td>
		<td colspan="2">{$fleet.text}</td>
	</tr>
	{/foreach}
	 <tr>


	

<td colspan="6">

 <div id='planet_overview' style='background: transparent url({$dpath}planeten/{$planetimage}.jpg); height: 290px; width: 625px;'>
 <div id='planet_overview_header'> <span class="planetname"> {$planetname} </span>
</div>



		

		
<a href="game.php?page=galaxyOld&amp;galaxy={$galaxy}&amp;system={$system}"> <img src="./styles/theme/gow/img/gala.png" width='88px' height='27px' border='0'></a>
<input style="margin:5px 0 0 5px;float:left;" value="<-" onclick="$('#planetSelector > :selected').prev().attr('selected', 'selected');$('#planetSelector').trigger('change')" type="button"/>
<input style="margin:5px 0;float:left;" value="->" onclick="$('#planetSelector > :selected').next().attr('selected', 'selected');$('#planetSelector').trigger('change')" type="button">


<div id="g_bau1">
<table>
<tbody>
<tr>

<th style="text-align:center; width: 5%;"><a href="game.php?page=buildings">{$LNG.ov_ogeb}</th> 
<td style="background: transparent; width: 10%; text-align:left;" >{if $buildInfo.buildings}{$LNG.tech[$buildInfo.buildings['id']]} ({$buildInfo.buildings['level']})<div class="timer" style="background: transparent; width: 30%; text-align:left;" data-time="{$buildInfo.buildings['timeleft']}"><b><div style="background: transparent; width: 20%; text-align:center;">{$buildInfo.buildings['starttime']}</b></div>{else}{$LNG.ov_free}{/if}</div>     
</td>

<th colspan="6" style="text-align:center;  width: 5%;"><a href="game.php?page=research">{$LNG.ov_ofors}</th>  
<td style="background: transparent; width: 10%; text-align:left;" >{if $buildInfo.tech}{$LNG.tech[$buildInfo.tech['id']]} ({$buildInfo.tech['level']})<div class="timer" style="background: transparent; width: 30%; text-align:left;" data-time="{$buildInfo.tech['timeleft']}"><b><div style="background: transparent; width: 20%; text-align:center;">{$buildInfo.tech['starttime']}</b></div>{else}{$LNG.ov_free}{/if}</div>   
</td>
<th colspan="6" style="text-align:center;  width: 5%;"><a href="game.php?page=shipyard&mode=fleet">{$LNG.ov_owerft}</th> 
<td style="background: transparent; width: 10%; text-align:left;" >{if $buildInfo.fleet}{$LNG.tech[$buildInfo.fleet['id']]} ({$buildInfo.fleet['level']})<div class="timer" style="background: transparent; width: 30%; text-align:left;" data-time="{$buildInfo.fleet['timeleft']}"><div style="background: transparent; width: 20%; text-align:center;"><b>{$buildInfo.fleet['starttime']}</b></div>{else}{$LNG.ov_free}{/if}</div>
</td>
</tr>





</tbody>
</table>
<div id='g_moon'>{if $Moon}<a href="game.php?page=overview&amp;cp={$Moon.id}&amp;re=0" title="{$Moon.name}"><img src="{$dpath}planeten/mond.jpg" height="70" width="70" alt="{$Moon.name} ({$LNG.fcm_moon})"></a><br>{else}&nbsp;{/if}

</div>
</div>

						




 <div id='planet_info'>
 <table id='g_overview'>
 </td>
 <tbody>
 <tr>
 <td id='planet_diameter'>
 <span>{$LNG.ov_diameter}:</span>
 </td>
 <td id='planet_diameter_dec'>
 <span>{$planet_diameter} {$LNG.ov_distance_unit} (<a title="{$LNG.ov_developed_fields}">{$planet_field_current}</a> / <a title="{$LNG.ov_max_developed_fields}">{$planet_field_max}</a> {$LNG.ov_fields})</span>
          				</td>
        				</tr>
				
        				<tr>			
          				<td id='planet_temperature'>
          				  <span>{$LNG.ov_temperature}:</span>
          				</td>	
          				<td id='planet_temperature_dec'>
          				  <span>{$LNG.ov_aprox} {$planet_temp_min}{$LNG.ov_temp_unit} {$LNG.ov_to} {$planet_temp_max}{$LNG.ov_temp_unit}</span>
          				</td>
        				</tr>
			
      			    <tr>
                  <td id='planet_position'>
                    <span>{$LNG.ov_position}:</span>
        				  </td>
        				  <td  id='planet_position_dec'>
        				    <span><a href="game.php?page=galaxy&amp;galaxy={$galaxy}&amp;system={$system}">[{$galaxy}:{$system}:{$planet}]</a></span>
        				  </td>
      				  </tr>

        				<tr>
          				<td id='planet_points'>
          				  <span>{$LNG.ov_points}:</span>
          				</td>
          		    <td id='planet_points_dec'>
          				  <span>{$rankInfo}</span>
          				</td>
        				</tr>
                
                <tr>

              		<td id='planet_rename'></td>
                  <td id='planet_rename_dec'>
                    <a href="#" onclick="return Dialog.PlanetAction();" title="{$LNG.ov_planetmenu}"><span class="planetname">{$LNG.ov_oumb}</span></a></td>
              	</tr>
                </tbody>
            </table>
			    </div>
			  </div>
      </div>
		</td>
		 </td>
         

						</tbody></table>		
										</div>



</td>
</tr>
</tbody></table>




<div style="background: transparent;"> <a name="t5" id="t5"></a>						
<table class="table519"style="width: 100%; background: transparent;">
	<tbody>
		<tr>
			<th colspan="2">{$LNG.ov_oauber}</th>
		</tr>
		{if $ally_true}
		<tr>
			<th width="40%">
				{$LNG.ov_oaname}
			</th>
			<td width="60%">
				{$ally_name} / {$ally_tag}
			</td>
		</tr>
		<tr>
			<th>
				{$LNG.ov_oamember}
			</th>
			<td>
				{$ally_mec} / {$ally_mem}
			</td>
		</tr>
		<tr>
			<th colspan="2">{$LNG.ov_oaver}</th>
		</tr>
		<tr>
			<th>
				{$LNG.ov_oametal}
			</th>
			<td>
				{$ally_met}
			</td>
		</tr>
		<tr>
			<th>
				{$LNG.ov_oakris}
			</th>
			<td>
				{$ally_kri}
			</td>
		</tr>
		<tr>
			<th>
				{$LNG.ov_oadeut}
			</th>
			<td>
				{$ally_deu}
			</td>
		</tr>
		<tr>
			<th colspan="2"><a href="game.php?page=market&amp;who=2" style="color:yellow">{$LNG['winemp_allyMarket_text']}{$fff}</th>
		</tr>
		<tr>
			<th colspan="2">Allianz Bonus</th>
		</tr>
		<tr>
			<th>{$LNG.winemp_alliBonus_1}</th>
			<td>{$bo_slo}</td>
		</tr>
		<tr>
			<th>{$LNG.winemp_alliBonus_2}</th>
			<td>{$bo_pro} %</td>
		</tr>
		<tr>
			<th>{$LNG.winemp_alliBonus_5}</th>
			<td>{$bo_def} %</td>
		</tr>
		<tr>
			<th>{$LNG.winemp_alliBonus_6}</th>
			<td>{$bo_atk} %</td>
		</tr>
		<tr>
			<th>{$LNG.winemp_alliBonus_3}</th>
			<td>{$bo_bui} %</td>
		</tr>
		<tr>
			<th>{$LNG.winemp_alliBonus_4}</th>
			<td>{$bo_res} %</td>
		</tr>
		{else}
		<tr><td>{$ally_error}</tr></td>
		{/if}
</tbody>
									
	
	
						</table></div>


</tbody></table>

{/block}