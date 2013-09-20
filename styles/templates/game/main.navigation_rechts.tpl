<div id="menu_r">
	<ul id="menu_r1">
		<li class="menu-head_r"><a href="game.php?page=changelog">{$LNG.lm_changelog}</a></li>
		
		{if isModulAvalible($smarty.const.MODULE_SIMULATOR)}<li><a href="game.php?page=battleSimulator">{$LNG.lm_battlesim}</a></li>{/if}
        {if isModulAvalible($smarty.const.MODULE_BUDDYLIST)}<li><a href="game.php?page=buddyList">{$LNG.lm_buddylist}</a></li>{/if}
		<li><a href="game.php?page=settings">{$LNG.lm_options}</a></li>
		<li><a href="game.php?page=logout">{$LNG.lm_logout}</a></li>
	<li>	<div id="planet_menu">
	<div id="planet_menu_header"><a href="javascript:ShowPlanetMenu()" id="planet_menu_link"><font color="red">>></font> {$LNG.gn_showhide}<font color="red"><<</font></a></div>
	<div id="planet_menu_content"{if $is_pmenu == 0} style="display:none;"{/if}>
    <table style="text-align:left;margin:0">
	
        	{foreach key=PlanetID item=PlanetInfo from=$PlanetMenu}
        	<tr class="transparent">

		<a href="{$PlanetInfo.url}" title="{$PlanetInfo.name}"><br>
		<img src="{$dpath}planeten/small/s_{$PlanetInfo.image}.jpg" alt="{$PlanetInfo.name}">
                	{if $PlanetID == $current_pid}<span style="color:#FFFF00;" class="planetname">{$PlanetInfo.name}</span>
                
                	{else}{if $PlanetInfo.ptype == 3}<span style="color:#CCCCCC">{else}<span style="color:#2E9AFE">{/if}{$PlanetInfo.name}</span>
                	{/if}
                
            	</a></tr>
        	
        	{/foreach}
    	
	</div>
</div>
<script type="text/javascript">
planetmenu	= {$Scripttime};
initPlanetMenu();
</script>
	</li>	
		<li class="menu-footer_r"></li>
	</ul>
</div>