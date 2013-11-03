<div id="leftmenu-ingame">
<div id="header" >
	<div id="extra-m1">

		<ul id="extra-m">
			<li>{if isModulAvalible($smarty.const.MODULE_SUPPORT)}<li style="width:180px;"><a href="game.php?page=ticket">{$LNG.lm_support}</a></li>{/if}</li>
			{if !empty($hasBoard)}<li style="width:180px;"><a href="game.php?page=ForumAll" target="">{$LNG.lm_forums}</a></li>{/if}
			{if isModulAvalible($smarty.const.MODULE_CHAT)}<li style="width:180px;"><a href="game.php?page=chat" target="_blank">{$LNG.lm_chat}</a></li>{/if}
			<li style="width:180px;"><a href="game.php?page=questions" target="">{$LNG.lm_faq}</a></li>
			<li style="width:180px;"><a href="http://www.wiki.spaceoflegends.de/doku.php" target="_blank">Wiki</a></li>
			{if isModulAvalible($smarty.const.MODULE_NOTICE)}<li style="width:180px;"><a href="javascript:OpenPopup('?page=notes', 'notes', 720, 300);">{$LNG.lm_notes}</a></li>{/if}
		        {if isModulAvalible($smarty.const.MODULE_SIMULATOR)}<li style="width:180px;"><a href="game.php?page=battleSimulator">{$LNG.lm_msimu}</a></li>{/if}
			{if isModulAvalible($smarty.const.MODULE_TECHTREE)}<li style="width:180px;"><a href="game.php?page=techtree">{$LNG.lm_mtech}</a></li>{/if}
			{if isModulAvalible($smarty.const.MODULE_TECHTREE)}<li style="width:180px;"><a href="game.php?page=search">Suchen</a></li>{/if}
			<li style="width:180px;"><a href="{$ts_data}">TS³</a></li>
			<li><a href="https://www.facebook.com/LoLSpace" target="_blank">Fb</a></li>
			<li><a href="https://twitter.com/SpaceofLegends" target="_blank">Twitter</a></li>

		</ul>	
	</div>

		<table id="headerTable"> 
<tbody>

				<tr>
				<td id="resourceWrapper">
						<table id="resourceTable">
							<tbody>
								<tr>
									<td><a href="?page=messages"><img src="{$dpath}images/message{if $new_message > 0}_active{/if}.gif" width="42" height="22"></td>
									{foreach $resourceTable as $resourceID => $resouceData}
									<td><img src="{$dpath}images/{$resouceData.name}.gif" alt=""></td>
									{/foreach}                                                  
								</tr>
								<tr>
									<td class="res_name">Nachrichten</td>
									{foreach $resourceTable as $resourceID => $resouceData}
									<td class="res_name">{$LNG.tech.$resourceID}</td>
									{/foreach}

								</tr>
								{if $shortlyNumber}
								<tr>
									<td>&nbsp;</td>
									{foreach $resourceTable as $resourceID => $resouceData}
									{if !isset($resouceData.current)}
									{$resouceData.current = $resouceData.max + $resouceData.used}
									<td class="res_current tooltip" data-tooltip-content="{$resouceData.current|number}&nbsp;/&nbsp;{$resouceData.max|number}"><span{if $resouceData.current < 0} style="color:red"{/if}>{shortly_number($resouceData.current)}&nbsp;/&nbsp;{shortly_number($resouceData.max)}</span></td>
									{else}
									<td class="res_current tooltip" id="current_{$resouceData.name}" data-real="{$resouceData.current}" data-tooltip-content="{$resouceData.current|number}">{shortly_number($resouceData.current)}</td>
									{/if}
									{/foreach}
                 				</tr>
								<tr>
									<td>&nbsp;</td>
									{foreach $resourceTable as $resourceID => $resouceData}
									{if !isset($resouceData.current) || !isset($resouceData.max)}
									<td>&nbsp;</td>
									{else}
									<td class="res_max tooltip" id="max_{$resouceData.name}" data-real="{$resouceData.max}" data-tooltip-content="{$resouceData.max|number}">{shortly_number($resouceData.max)}</td>
									{/if}
									{/foreach}
								</tr>
								{else}
								<tr>
									<td class="res_current">{if $new_message > 0}<a href="?page=messages"><b>{$new_message}{/if}</b></td>
									{foreach $resourceTable as $resourceID => $resouceData}
									{if !isset($resouceData.current)}
									{$resouceData.current = $resouceData.max + $resouceData.used}
									<td class="res_current"><span{if $resouceData.current < 0} style="color:red"{/if}>{$resouceData.current|number}&nbsp;/&nbsp;{$resouceData.max|number}</span></td>
									{else}
									<td class="res_current" id="current_{$resouceData.name}" data-real="{$resouceData.current}">{$resouceData.current|number}</td>
									{/if}
									{/foreach}
								</tr>
								<tr>
									<td>&nbsp;</td>
									{foreach $resourceTable as $resourceID => $resouceData}
									{if !isset($resouceData.current) || !isset($resouceData.max)}
									<td>&nbsp;</td>
									{else}
									<td class="res_max" id="max_{$resouceData.name}" data-real="{$resouceData.current}">{$resouceData.max|number}</td>
									{/if}
									{/foreach}
								</tr>
								{/if}
							</tbody>
						</table>
					</td>
					</tr>
					<tr>
						<td style="background-color:black;color:gold;">
						{if $is_news}
						<div id="newsscrollbar" width="100%" align="center"></div>
						{/if}
						</td>
					</tr>

			</tbody>

{if !$vmode}
		<script type="text/javascript">
		var viewShortlyNumber	= {$shortlyNumber|json}
		var vacation			= {$vmode};
		{foreach $resourceTable as $resourceID => $resouceData}
		{if isset($resouceData.production)}
		resourceTicker({
			available: {$resouceData.current|json},
			limit: [0, {$resouceData.max|json}],
			production: {$resouceData.production|json},
			valueElem: "current_{$resouceData.name}"
		}, true);
		{/if}
		{/foreach}
		</script>
		{/if}

		</table>
	</div>


<div id="menu-ausrichtung">

	<ul id="menu" >

		<li class="menu-head"><a href="game.php?page=changelog">{$LNG.lm_changelog}</a></li>
<li>

		<div align="center" width="200px" height="150px" id="menue_r2">
			{$scancheck}<br/>
			Rasse : {$race}
		</div>

	<li>
	<select id="planetSelector">{html_options options=$PlanetSelect selected=$current_pid}
	</select>
	<br/>
	</li>
		



<ul id="css3menu1" >
<li class="topfirst"><a href="#" style="width:190px;" id="item-1"><span>{$LNG.lm_overview}</span></a>
	<ul style="width:180px;  ">
                        <li style="width:180px;"><a href="game.php?page=overview">Planeten Übersicht</a></li>	
			{if isModulAvalible($smarty.const.MODULE_IMPERIUM)}<li style="width:180px;"><a href="game.php?page=imperium">{$LNG.lm_empire}</a></li>{/if}
			{if isModulAvalible($smarty.const.MODULE_RESSOURCE_LIST)}<li style="width:180px;"><a href="game.php?page=resources">{$LNG.lm_resources}</a></li>{/if}
			{if isModulAvalible($smarty.const.MODULE_GALAXY)}<li style="width:180px;"><a href="game.php?page=galaxy">{$LNG.lm_mgala2d}</a></li>{/if}	
			{if isModulAvalible($smarty.const.MODULE_GALAXY)}<li style="width:180px;"><a href="game.php?page=galaxyOld">{$LNG.lm_mgalalist}</a></li>{/if}

	</ul></li>
	<li class="topmenu"><a href="#" style="width:190px;"><span>{$LNG.lm_mwirtschaft}</span></a>
	<ul style="width:180px;">
			{if isModulAvalible($smarty.const.MODULE_BUILDING)}<li style="width:180px;"><a href="game.php?page=buildings">{$LNG.lm_buildings} 2D</a></li>{/if}
			{if isModulAvalible($smarty.const.MODULE_BUILDING)}<li style="width:180px;"><a href="game.php?page=buildingsOld">{$LNG.lm_buildings} old</a></li>{/if}
			{if isModulAvalible($smarty.const.MODULE_SHIPYARD_FLEET)}<li style="width:180px;"><a href="game.php?page=shipyard&amp;mode=fleet">{$LNG.lm_shipshard}</a></li>{/if}
			{if isModulAvalible($smarty.const.MODULE_SHIPYARD_DEFENSIVE)}<li style="width:180px;"><a href="game.php?page=shipyard&amp;mode=defense">{$LNG.lm_defenses}</a></li>{/if}
			{if isModulAvalible($smarty.const.MODULE_RESEARCH)}<li style="width:180px;"><a href="game.php?page=research">{$LNG.lm_research}</a></li>{/if}	

	 </ul></li>
<li class="topmenu"><a href="game.php?page=fleetTable" style="width:190px;"><span>Flotten-Kommando</span></a>
	<ul style="width:180px;">

	</ul></li>
	<li class="topmenu"><a href="#" style="width:190px;"><span>{$LNG.lm_mstats}</span></a>
	<ul style="width:180px;">

    			{if isModulAvalible($smarty.const.MODULE_STATISTICS)}<li style="width:180px;"><a href="game.php?page=statistics">{$LNG.lm_statistics}</a></li>{/if}
   			{if isModulAvalible($smarty.const.MODULE_RECORDS)}<li style="width:180px;"><a href="game.php?page=records">{$LNG.lm_records}</a></li>{/if}
   			{if isModulAvalible($smarty.const.MODULE_BATTLEHALL)}<li style="width:180px;"><a href="game.php?page=battleHall">{$LNG.lm_topkb}</a></li>{/if}
	</ul></li>
	<li class="topmenu"><a href="#" style="width:190px;"><span>{$LNG.lm_mquest}</span></a>
	<ul style="width:180px;">

 	 
			{if isModulAvalible($smarty.const.MODULE_TUTORIAL)}<li style="width:180px;"><a href="game.php?page=tutorial">{$LNG.tut_tut}</a></li>{/if}
			<li style="width:180px;"><a href="?page=achievement">{$LNG.lm_merrung}</a></li>
        </ul></li>
	<li class="topmenu"><a href="#" style="width:190px;"><span>{$LNG.lm_malli}</span></a>
	<ul style="width:180px;">
			{if isModulAvalible($smarty.const.MODULE_ALLIANCE)}<li style="width:180px;"><a href="game.php?page=alliance">{$LNG.lm_alliance}</a></li>{/if}
        		<li style="width:180px;"><a href="game.php?page=alliBank">{$LNG.lm_mallib}</a></li>
        		<li style="width:180px;"><a href="game.php?page=allianzForum">{$LNG.lm_malliForum}</a></li>

	</ul></li>
	<li class="topmenu"><a href="#" style="width:190px;"><span>{$LNG.lm_mhandel}</span></a>
	<ul style="width:180px;">
			{if isModulAvalible($smarty.const.MODULE_OFFICIER) || isModulAvalible($smarty.const.MODULE_DMEXTRAS)}<li style="width:180px;"><a href="game.php?page=officier"style="color:yellow">{$LNG.lm_officiers}</a></li>{/if}	
			<li style="width:180px;"><a href="game.php?page=market"style="color:yellow"><em>{$LNG['an_anres']}</em><em><font size="1" color="lime">   {$LNG['an_lotsum']} {$ddd}</font></em></a></li>
			{if isModulAvalible($smarty.const.MODULE_TRADER)}<li style="width:180px;"><a href="game.php?page=trader"style="color:yellow">{$LNG.lm_trader}</a></li>{/if}
			{if isModulAvalible($smarty.const.MODULE_FLEET_TRADER)}<li style="width:180px;"><a href="game.php?page=fleetDealer"style="color:yellow">{$LNG.lm_fleettrader}</a></li>{/if}
			<li style="width:180px;"><a href="game.php?page=wGutscheinCreate"style="color:yellow">{$LNG.lm_gutscheine_buy}</a></li>
			<li style="width:180px;"><a href="game.php?page=wGutscheinMod"style="color:yellow">{$LNG.lm_gutscheine_einloes}</a></li>
			<li style="width:180px;"><a href="?page=bank"style="color:yellow">{$LNG.lm_mbank}</a></li>
	</ul></li>
	<li class="topmenu"><a href="#" style="width:190px;"><span>{$LNG.lm_meinstellungen}</span></a>
	<ul style="width:180px;">
			<li style="width:180px;"><a href="game.php?page=settings">{$LNG.lm_options}</a></li>
			<li style="width:180px;"><a href="game.php?page=logout">{$LNG.lm_logout}</a></li>	
	</ul></li>
	<li style="width:200px;"><a href="game.php?page=Vote">{$LNG.lm_Vote}</a></li>

	{if $team == true}
	<li class="topmenu"><a href="#" style="width:190px;"><span>Team Area</span></a>
	<ul style="width:180px;">
			{if $authlevel > 0}<li style="width:180px;"><a href="./admin.php" style="color:lime">{$LNG.lm_administration} ({$VERSION})</a></li>{/if}
			<li style="width:180px;"><a href="http://space.landoflegends.de/phpBB3/index.php" target="_blank">Team Forum</a></li>
<li style="width:180px;"><a href="" target="_blank"></a></li>
<li style="width:180px;"><a href="http://mantis.spaceoflegends.de" target="_blank">Mantis</a></li>
<li style="width:180px;"><a href="http://www.entwicklung.spaceoflegends.de/" target="_blank">Test Server</a></li>
<li style="width:180px;"><a href="http://www.wiki.spaceoflegends.de/doku.php" target="_blank">Wiki</a></li>
<li style="width:180px;"><a href="http://winemp83.github.io/SOL/" target="_blank">Git</a></li>
<li style="width:180px;"><a href="https://www.facebook.com/LoLSpace" target="_blank">Facebook</a></li>
<li style="width:180px;"><a href="https://twitter.com/SpaceofLegends" target="_blank">Twitter</a></li>
	</ul></li>
	{/if}





<li class="menu-footer">
	<div align="center" width="200px"><a style="text-align:center;" href="index.php?page=disclamer" target="_blank">{$LNG.lm_disclamer}</a></div>
</li>

</div>
</div>
