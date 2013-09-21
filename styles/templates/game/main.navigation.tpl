<div id="leftmenu-ingame">
	<ul id="menu">
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
                        <li style="width:180px;"><a href="game.php?page=overview">{$LNG.lm_overview}</a></li>	
			{if isModulAvalible($smarty.const.MODULE_IMPERIUM)}<li style="width:180px;"><a href="game.php?page=imperium">{$LNG.lm_empire}</a></li>{/if}
			{if isModulAvalible($smarty.const.MODULE_RESSOURCE_LIST)}<li style="width:180px;"><a href="game.php?page=resources">{$LNG.lm_resources}</a></li>{/if}
			{if isModulAvalible($smarty.const.MODULE_TUTORIAL)}<li style="width:180px;"><a href="game.php?page=tutorial">{$LNG.tut_tut}</a></li>{/if}
			<li style="width:180px;"><a href="?page=achievement">{$LNG.lm_merrung}</a></li>
		        {if isModulAvalible($smarty.const.MODULE_SIMULATOR)}<li style="width:180px;"><a href="game.php?page=battleSimulator">{$LNG.lm_msimu}</a></li>{/if}
	</ul></li>
	<li class="topmenu"><a href="#" style="width:190px;"><span>{$LNG.lm_baumenu}</span></a>
	<ul style="width:180px;">
			{if isModulAvalible($smarty.const.MODULE_BUILDING)}<li style="width:180px;"><a href="game.php?page=buildings">{$LNG.lm_buildings}</a></li>{/if}
			{if isModulAvalible($smarty.const.MODULE_SHIPYARD_FLEET)}<li style="width:180px;"><a href="game.php?page=shipyard&amp;mode=fleet">{$LNG.lm_shipshard}</a></li>{/if}
			{if isModulAvalible($smarty.const.MODULE_SHIPYARD_DEFENSIVE)}<li style="width:180px;"><a href="game.php?page=shipyard&amp;mode=defense">{$LNG.lm_defenses}</a></li>{/if}
			{if isModulAvalible($smarty.const.MODULE_RESEARCH)}<li style="width:180px;"><a href="game.php?page=research">{$LNG.lm_research}</a></li>{/if}	
			{if isModulAvalible($smarty.const.MODULE_TRADER)}<li style="width:180px;"><a href="game.php?page=fleetTable">{$LNG.lm_fleet}</a></li>{/if}

	 </ul></li>
	<li class="topmenu"><a href="#" style="width:190px;"><span>{$LNG.lm_mstats}</span></a>
	<ul style="width:180px;">

    			{if isModulAvalible($smarty.const.MODULE_STATISTICS)}<li style="width:180px;"><a href="game.php?page=statistics">{$LNG.lm_statistics}</a></li>{/if}
   			{if isModulAvalible($smarty.const.MODULE_RECORDS)}<li style="width:180px;"><a href="game.php?page=records">{$LNG.lm_records}</a></li>{/if}
   			{if isModulAvalible($smarty.const.MODULE_TECHTREE)}<li style="width:180px;"><a href="game.php?page=techtree">{$LNG.lm_mtech}</a></li>{/if}
   			{if isModulAvalible($smarty.const.MODULE_BATTLEHALL)}<li style="width:180px;"><a href="game.php?page=battleHall">{$LNG.lm_topkb}</a></li>{/if}

        </ul></li>
	<li class="topmenu"><a href="#" style="width:190px;"><span>{$LNG.lm_malli}</span></a>
	<ul style="width:180px;">
			{if isModulAvalible($smarty.const.MODULE_ALLIANCE)}<li style="width:180px;"><a href="game.php?page=alliance">{$LNG.lm_alliance}</a></li>{/if}
        		<li style="width:180px;"><a href="game.php?page=alliBank">{$LNG.lm_mallib}</a></li>

	</ul></li>
	<li class="topmenu"><a href="#" style="width:190px;"><span>{$LNG.lm_mcommunity}</span></a>
	<ul style="width:180px;">
			{if isModulAvalible($smarty.const.MODULE_GALAXY)}<li style="width:180px;"><a href="game.php?page=galaxy">{$LNG.lm_mgala2d}</a></li>{/if}	
			{if isModulAvalible($smarty.const.MODULE_GALAXY)}<li style="width:180px;"><a href="game.php?page=galaxyOld">{$LNG.lm_mgalalist}</a></li>{/if}
        		{if !empty($hasBoard)}<li style="width:180px;"><a href="game.php?page=board" target="forum">{$LNG.lm_forums}</a></li>{/if}
			{if isModulAvalible($smarty.const.MODULE_CHAT)}<li style="width:180px;"><a href="game.php?page=chat">{$LNG.lm_chat}</a></li>{/if}
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
			{if isModulAvalible($smarty.const.MODULE_NOTICE)}<li style="width:180px;"><a href="javascript:OpenPopup('?page=notes', 'notes', 720, 300);">{$LNG.lm_notes}</a></li>{/if}

			<li style="width:180px;"><a href="game.php?page=settings">{$LNG.lm_options}</a></li>
			<li style="width:180px;"><a href="game.php?page=logout">{$LNG.lm_logout}</a></li>	
			{if $authlevel > 0}<li style="width:180px;"><a href="./admin.php" style="color:lime">{$LNG.lm_administration} ({$VERSION})</a></li>{/if}
	</ul></li>
	<li>
		{if isModulAvalible($smarty.const.MODULE_SUPPORT)}<li style="width:180px;"><a href="game.php?page=ticket">{$LNG.lm_support}</a></li>{/if}
	</li>
	<li class="topmenu"><a href="#" style="width:190px;"><span>{$LNG.lm_voteus}</span></a>
	<ul style="width:180px;">
			<li style="width:180px;"><a href="http://www.kostenlos-browsergame.de/" target="_blank">{$LNG.lm_browser1}</a></li>
			<li style="width:180px;"><a href="http://www.top100arena.com/in.asp?id=82759" target="_blank">{$LNG.lm_browser2}</a></li>	
			<li style="width:180px;"><a href="http://www.browsergamelist.com/vote.php?gid=49" target="_blank">{$LNG.lm_browser3}</a></li>
			<li style="width:180px;"><a href="http://www.browsergames.info/" target="_blank">{$LNG.lm_browser4}</a></li>
			<li style="width:180px;"><a href="http://www.gtop100.com/in.php?site=81654&cookie_test=true" target="_blank">{$LNG.lm_browser5}</a></li>
	</ul></li>




<li><div align="center" width="200px" id="menue_r2"><iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FLoLSpace&amp;send=false&amp;width=45&amp;height=21&amp;colorscheme=dark&amp;layout=button_count&amp;show_faces=true&amp;send=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true" align="center"></iframe></div></li>
	
	<li><div align="center" width="200px" id="menue_r2"><a href="https://plus.google.com/communities/114929726915639497772?prsrc=3"rel="publisher" target="_top" style="text-decoration:none;display:inline-block;color:#333;text-align:center; font:13px/16px arial,sans-serif;white-space:nowrap;">
		<span style="font-weight:bold;vertical-align:top;color:silver;">Wir sind auf
		<img src="//ssl.gstatic.com/images/icons/gplus-16.png" alt="Google+" style="border:0;width:16px;height:16px;"/></span>
	</a>
	</div>
	</li>
	<li>
	<div align="center" width="200px" id="menue_r2">
	<a href="https://twitter.com/share" class="twitter-share-button" data-via="SpaceofLegends" data-lang="de" data-hashtags="browsergame">Twittern</a>
{literal}<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>{/literal}
	</div>
	</li>
<div align="center" width="200px" id="menue_r2">
<script src="http://ak-webdesign.net/streambox/box.php?id=12184" type="text/javascript">
function setcode_12184_1378562088_streambox12183()
{
document.getElementById('12184_1378562088_streambox12183').innerHTML = '<iframe src="http://ak-webdesign.net/streambox/streambox_core.php?mode=view_12184" scrolling="no" frameborder="0" align=aus marginheight="0px" marginwidth="0px" height="170" width="140"></iframe>';
setTimeout("setcode_12184_1378562088_streambox12183()",180000);
}
document.write(unescape("%3Cdiv%20id%3D%2212184_1378562088_streambox12183%22%3E%3C%2Fdiv%3E"));setTimeout("setcode_12184_1378562088_streambox12183()",10);
</script>
</div>
	<li class="menu-footer">
	<div align="center" width="200px"><a style="text-align:center;" href="index.php?page=disclamer" target="_blank">{$LNG.lm_disclamer}</a></div>
	</li>
	</ul>
</div>