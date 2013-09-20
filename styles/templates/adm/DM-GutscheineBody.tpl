{include file="adm/overall_header.tpl"}
<center>
<form action="" method="post">
<input type="hidden" name="opt_save" value="1">
<table width="70%" cellpadding="2" cellspacing="2">
<tr>
	<th colspan="12">{$mod_gutscheine_headline}</th>
	<th colspan="1" width="5%"><img src="./styles/images/Adm/i.gif" width="16" height="16" alt="" class="tooltip" name="{$mod_gutschein_info_admin}"></th>
</tr><tr>
	<td>{$mod_gutschein_exists_id}</td>
	<td>{$mod_gutschein_exists_name}</td>
	<td>{$mod_gutschein_exists_minerals}</td>
	<td>{$mod_gutschein_exists_kristall}</td>
	<td>{$mod_gutschein_exists_deuterium}</td>
	<td>{$mod_gutschein_exists_dm}</td>
	<td>{$mod_gutschein_exists_key}</td>
	<td>{$mod_gutschein_exists_used}</td>
	<td>{$mod_gutschein_exists_useable}</td>
	<td>{$mod_gutschein_exists_createday}</td>
	<td>{$mod_gutschein_exists_expireday}</td>
	<td>{$mod_gutschein_exists_delete}</td>
	<td>{$mod_gutschein_exists_disable}</td>

	{foreach	item=Gutschein	from=$Gutscheine}
<tr>
	<td>{$Gutschein.id}</td>
	<td>{$Gutschein.name}</td>
	<td>{$Gutschein.mineralien}</td>
	<td>{$Gutschein.kristall}</td>
	<td>{$Gutschein.deuterium}</td>
	<td>{$Gutschein.dm}</td>
	<td>{$Gutschein.key}</td>
	<td>{$Gutschein.used}</td>
	<td><a href="?page=DMGutscheine&amp;action=up&id={$Gutschein.id}"><img border="0" src="./styles/images/Adm/UP.png"></a>{$Gutschein.useable}<a href="?page=DMGutscheine&amp;action=down&id={$Gutschein.id}"><img border="0" src="./styles/images/Adm/GO.png"></a></td>
	<td>{$Gutschein.createday}</td>
	<td>{$Gutschein.expiredayrl}</td>
	<td><a href="?page=DMGutscheine&amp;action=delete&id={$Gutschein.id}"><img border="0" src="./styles/images/r1.png"></a></td>
	<td><a href="?page=DMGutscheine&amp;action=disable&id={$Gutschein.id}"><img border="0" src="./styles/images/Adm/i.gif"></a></td>
</tr>
	{/foreach}
</tr><tr>
	<th colspan="12">{$mod_gutscheine_erstellen}</th>
	<th colspan="1" width="5%">(?)</th>
</tr><tr>
	<td>{$mod_gutscheine_name}
	<td><input name="gutscheine_name" value="{$gutscheine_name}" type="text" maxlength="60"></td>

</tr><tr>
	<td>{$mod_gutscheine_gutschrift_minerals}</td>
	<td><input name="gutscheine_gutschrift_minerals" value="0" type="text" maxlength="60"></td>
</tr><tr>
	<td>{$mod_gutscheine_gutschrift_kristall}</td>
	<td><input name="gutscheine_gutschrift_kristall" value="0" type="text" maxlength="60"></td>
</tr><tr>
	<td>{$mod_gutscheine_gutschrift_deuterium}</td>
	<td><input name="gutscheine_gutschrift_deuterium" value="0" type="text" maxlength="60"></td>
</tr><tr>
	<td>{$mod_gutscheine_gutschrift_DM}</td>
	<td><input name="gutscheine_gutschrift_dm" value="0" type="text" maxlength="60"></td>
</tr><tr>
	<td>{$mod_gutscheine_useable}</td>
	<td><input name="gutscheine_useable" value="-1" type="text" maxlength="60"></td>
</tr><tr>
	<td>{$mod_gutscheine_key}
	<td><input name="gutscheine_key" type="text" maxlength="60"></td>
</tr><tr>
	<td>{$mod_gutscheine_expire}
	<td><input name="gutscheine_expire" type="text" maxlength="60"></td>
</tr><tr>
	<td colspan="2"><input value="{$mod_save_gutscheine}" type="submit"></td>
</tr>
</table>
</form>
</center>
{include file="adm/overall_footer.tpl"}