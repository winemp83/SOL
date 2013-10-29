/**mod by amcat**/
{block name="title" prepend}{$LNG.lm_galaxy}{/block}
{block name="content"}
	<form action="?page=galaxy" method="post" id="galaxy_form">
	<input type="hidden" id="auto" value="dr">
			<tr>
					<td class="transparent">
				<table id="sys" >
				<tr>
		<th><center>{$LNG.lm_overview}&nbsp;&nbsp{$LNG.lm_galaxy}&nbsp;&nbsp{$LNG.gl_solar_system}&nbsp;&nbsp{$galaxy}:{$system}</center></th>
	</tr>
					<tr>
						<td><b>{$LNG.gl_galaxy}<input type="button" name="galaxyLeft" value="&lt;-" onclick="galaxy_submit('galaxyLeft')"><input type="text" name="galaxy" value="{$galaxy}" size="5" maxlength="3" tabindex="1"><input type="button" name="galaxyRight" value="-&gt;" onclick="galaxy_submit('galaxyRight')">&nbsp&nbsp{$LNG.gl_solar_system}<input type="button" name="systemLeft" value="&lt;-" onclick="galaxy_submit('systemLeft')"><input type="text" name="system" value="{$system}" size="5" maxlength="3" tabindex="2"><input type="button" name="systemRight" value="-&gt;" onclick="galaxy_submit('systemRight')"><input type="submit" value="{$LNG.gl_show}"></b></td>
					<tr>
				
			</td>
		</tr>
	</table>
	</form>


<div id="back1" ><tr><div id="back" ><tr>
<table id="sys" 
<th>
	{if $action == 'sendMissle'}
    <form action="?page=fleetMissile" method="post">
	<input type="hidden" name="galaxy" value="{$galaxy}">
	<input type="hidden" name="system" value="{$system}">
	<input type="hidden" name="planet" value="{$planet}">
	<input type="hidden" name="type" value="{$type}">
	
		<tr>
			<th colspan="2">{$LNG.gl_missil_launch} [{$galaxy}:{$system}:{$planet}]</th>
		</tr>
		<tr>
			<td>{$missile_count} <input type="text" name="SendMI" size="2" maxlength="7"></td>
			<td>{$LNG.gl_objective}: 
				{html_options name=Target options=$MissleSelector}
			</td>
		</tr>
		<tr>
			<th colspan="2" style="text-align:center;"><input type="submit" value="{$LNG.gl_missil_launch_action}"></th>
		</tr>
	</form>
    {/if}
</th>
</table>


	{for $planet=1 to $max_planets}
    {if !isset($GalaxyRows[$planet])}
		<div id="p{$planet}" style="width:500px; margin:90px 0px 0px 50px;">
	<tr><a href="?page=fleetTable&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&amp;target_mission=7"><b>{$planet} [{$galaxy}:{$system}:{$planet}]</b>
	<img src="{$dpath}planeten/small/desert.gif" height="45" width="45" alt="{$planet}"
	</a></tr>
        </div>
    {elseif $GalaxyRows[$planet] === false}			
        <td style="white-space: nowrap;">{$LNG.gl_planet_destroyed}</td>
    {else}
		{$currentPlanet = $GalaxyRows[$planet]} 
		<div id="p{$planet}" style="width:500px; margin:90px 0px 0px 50px;">	 
		{if $currentPlanet.planet.name}  
		 <b>[{$galaxy}:{$system}:{$planet}]<b><br>{$currentPlanet.user.username}<br>
			<a class="tooltip_sticky" data-tooltip-content="<tr><th colspan='2'>{$LNG.gl_planet} {$currentPlanet.planet.name}  [{$galaxy}:{$system}:{$planet}]<br>
			<a href='#' onclick='return Dialog.Buddy({$currentPlanet.user.id})'>{$LNG.gl_buddy_request}</a><br>
			<a href='?page=statistics&amp;who=1&amp;start={$currentPlanet.user.rank}'>{$LNG.gl_see_on_stats}</a><br>
			{$currentPlanet.user.username}:&nbsp;<a href='#' onclick='return Dialog.Playercard({$currentPlanet.user.id});'>{$LNG.gl_playercard}</a><br>
			{$LNG.gl_alliance}:&nbsp;<a href='?page=statistics&amp;start={$currentPlanet.alliance.rank}&amp;who=2'>{$LNG.gl_see_on_stats}</a><br>
      >>&nbsp;{$LNG.gl_alliance}:&nbsp;{$currentPlanet.alliance.name}&nbsp;<<
			<br><a href='?page=alliance&amp;mode=info&amp;id={$currentPlanet.alliance.id}'>{$LNG.gl_alliance_page}</a><br>
			{if $currentPlanet.alliance.web}<tr><td><a href='{$currentPlanet.alliance.web}' target='allyweb'>{$LNG.gl_alliance_web_page}</td></tr>{/if}<br>
			{if $currentPlanet.missions.6}<a href='javascript:doit(6,{$currentPlanet.planet.id});'>{$LNG.type_mission.6}</a><br><br>{/if}{if $currentPlanet.planet.phalanx}<a href='javascript:OpenPopup(&quot;?page=phalanx&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&quot;, &quot;&quot;, 640, 510);'>{$LNG.gl_phalanx}</a><br>{/if}{if $currentPlanet.missions.1}<a href='?page=fleetTable&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&amp;target_mission=1'>{$LNG.type_mission.1}</a><br>{/if}{if $currentPlanet.missions.5}<a href='?page=fleetTable&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&amp;target_mission=5'>{$LNG.type_mission.5}</a><br>{/if}{if $currentPlanet.missions.4}<a href='?page=fleetTable&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&amp;target_mission=4'>{$LNG.type_mission.4}</a><br>{/if}{if $currentPlanet.missions.3}<a href='?page=fleetTable&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&amp;target_mission=3'>{$LNG.type_mission.3}</a><br>{/if}{if $currentPlanet.missions.10}<a href='?page=galaxy&amp;action=sendMissle&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}'>{$LNG.type_mission.10}</a><br>{/if}
			
			
			{if $currentPlanet.action}
				{if $currentPlanet.action.esp}
				<a href="javascript:doit(6,{$currentPlanet.planet.id},{$spyShips|json|escape:'html'})">
					<img src="{$dpath}img/e.gif" title="{$LNG.gl_spy}" alt="">
				</a>{/if}
				{if $currentPlanet.action.message}
				<a href="#" onclick="return Dialog.PM({$currentPlanet.user.id})">
					<img src="{$dpath}img/m.gif" title="{$LNG.write_message}" alt="{$currentPlanet.action.message}">
				</a>{/if}
				{if $currentPlanet.action.buddy}
                <a href="#" onclick="return Dialog.Buddy({$currentPlanet.user.id})">
					<img src="{$dpath}img/b.gif" title="{$LNG.gl_buddy_request}" alt="{$currentPlanet.action.buddy}">
				</a>{/if}
				{if $currentPlanet.action.missle}<a href="?page=galaxy&amp;action=sendMissle&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;type=1">
					<img src="{$dpath}img/r.gif" title="{$LNG.gl_missile_attack}" alt="{$currentPlanet.action.missle}">
				</a>{/if}
			{else}-{/if}			
			<br></th></tr><td style="white-space: nowrap;">
				<img src="{$dpath}planeten/small/s_{$currentPlanet.planet.image}.gif" height="45" width="45" alt="{$currentPlanet.planet.name}"></a></td>
		{/if}
		
		<td style="white-space: nowrap;">
			{if $currentPlanet.moon}
			<a class="tooltip_sticky" data-tooltip-content="<tr><th colspan='2'>{$LNG.gl_moon} {$currentPlanet.moon.name} [{$galaxy}:{$system}:{$planet}]</th></tr><tr><td style='width:80px'><img src='{$dpath}planeten/mond.jpg' height='75' width='75'></td><td><td><tr><th colspan='2'>{$LNG.gl_features}</th></tr><tr><td>{$LNG.gl_diameter}</td><td>{$currentPlanet.moon.diameter|number}</td></tr><tr><td>{$LNG.gl_temperature}</td><td>{$currentPlanet.moon.temp_min}</td></tr><tr><th colspan=2>{$LNG.gl_actions}</th></tr><tr><td colspan='2'>{if $currentPlanet.missions.1}<a href='?page=fleetTable&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=1'>{$LNG.type_mission.1}</a><br>{/if}{if $currentPlanet.missions.3}<a href='?page=fleetTable&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=3'>{$LNG.type_mission.3}</a>{/if}{if $currentPlanet.missions.3}<br><a href='?page=fleetTable&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=4'>{$LNG.type_mission.4}</a>{/if}{if $currentPlanet.missions.5}<br><a href='?page=fleetTable&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=5'>{$LNG.type_mission.5}</a>{/if}{if $currentPlanet.missions.6}<br><a href='javascript:doit(6,{$currentPlanet.moon.id});'>{$LNG.type_mission.6}</a>{/if}{if $currentPlanet.missions.9}<br><br><a href='?page=fleetTable&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=9'>{$LNG.type_mission.9}</a><br>{/if}{if $currentPlanet.missions.10}<a href='?page=galaxy&amp;action=sendMissle&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;type=3'>{$LNG.type_mission.10}</a><br>{/if}</td></tr></td></tr>">
				<img src="{$dpath}planeten/small/s_mond.jpg" height="22" width="22" alt="{$currentPlanet.moon.name}">
			</a>
			{/if}
			</td>
				{if $currentPlanet.debris}
			<a class="tooltip_sticky" data-tooltip-content="<tr><th colspan='2'>{$LNG.gl_debris_field} [{$galaxy}:{$system}:{$planet}]</th></tr><tr><td style='width:80px'><img src='{$dpath}planeten/debris.jpg' height='75' style='width:75'></td><td><tr><th colspan='2'>{$LNG.gl_resources}:</th></tr><tr><td>{$LNG.tech.901}: </td><td>{$currentPlanet.debris.metal|number}</td></tr><tr><td>{$LNG.tech.902}: </td><td>{$currentPlanet.debris.crystal|number}</td></tr>{if $currentPlanet.missions.8}<tr><th colspan='2'>{$LNG.gl_actions}</th></tr><tr><td colspan='2'><a href='?page=fleetTable&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=2&amp;target_mission=8'>{$LNG.type_mission.8}</a></td></tr>{/if}</td></tr>">
			<img src="{$dpath}planeten/debris.jpg" height="22" width="22" alt="">
			</a>
        {/if}
				
			{/if}
		</div>
		{/for}
	<div id="exp">
	
	<tr><td colspan="2"><b><a href="?page=fleetTable&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$max_planets + 1}&amp;planettype=1&amp;target_mission=15">{$LNG.gl_out_space}</b>
	<img src="{$dpath}planeten/small/exp.gif" height="30" width="30" alt="">
	</a></td></tr></div>
		<table></table>
		<tr><td><div id="sun"><img src="{$dpath}planeten/small/sun.gif" height="90" width="90" alt=""</div></td></tr>
			<script type="text/javascript">
		status_ok		= '{$LNG.gl_ajax_status_ok}';
		status_fail		= '{$LNG.gl_ajax_status_fail}';
		MaxFleetSetting = {$settings_fleetactions};
	</script></tr></div></div>
{/block}
