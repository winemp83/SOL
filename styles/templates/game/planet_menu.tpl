<div id="planet_menu">
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