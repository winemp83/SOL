<div id="menu_r">
	<ul id="menu_r1">
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