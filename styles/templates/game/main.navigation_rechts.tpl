<div id="menu_r">
	<ul id="menu_r1">
		<li class="menu-head_r"><a href="game.php?page=changelog">{$LNG.lm_changelog}</a></li>
		
		{if isModulAvalible($smarty.const.MODULE_SIMULATOR)}<li><a href="game.php?page=battleSimulator">{$LNG.lm_battlesim}</a></li>{/if}
        {if isModulAvalible($smarty.const.MODULE_BUDDYLIST)}<li><a href="game.php?page=buddyList">{$LNG.lm_buddylist}</a></li>{/if}
		<li><a href="game.php?page=settings">{$LNG.lm_options}</a></li>
		<li><a href="game.php?page=logout">{$LNG.lm_logout}</a></li>
		
		
		<li class="menu-footer_r"></li>
	</ul>
</div>