{block name="content"}
<table class="table569">
<center>
<form action="" method="post">
<input type="hidden" name="opt_save" value="1">
<table width="70%" cellpadding="2" cellspacing="2">
<tr>
	<th colspan="2">{$mod_gutscheine_user_headline}</th>
</tr>
{if $mod_gutscheine_success == 1}
<tr>
	<th colspan="2">{$mod_gutscheine_user_Successhead}</th>
</tr><tr>
	<td>{$mod_gutscheine_recieve1}{$mod_gutschein_name}
	<br><b>{$mod_gutscheine_metall}</b> {$mod_metal}
	<br><b>{$mod_gutscheine_crystall}</b> {$mod_crystall}
	<br><b>{$mod_gutscheine_deuterium}</b> {$mod_deuterium}
	<br><b>{$mod_gutscheine_matter}</b> {$mod_darkmatter} {$mod_gutscheine_recieve2}</td>
</tr>
{/if}
<tr>
{if $mod_gutscheine_success == 0}
	<td>{$mod_gutscheine_user_Fail}</td>
</tr>{if $mod_gutscheine_errorcode == 1}<tr>
	<td>{$mod_gutscheine_user_Fail1}</td>
</tr>{/if}{if $mod_gutscheine_errorcode == 2}<tr>
	<td>{$mod_gutscheine_user_Fail2}</td>
</tr>{/if}{if $mod_gutscheine_errorcode == 3}<tr>
	<td>{$mod_gutscheine_user_Fail3}</td>
</tr>{/if}{if $mod_gutscheine_errorcode == 4}<tr>
	<td>{$mod_gutscheine_user_Fail4}</td>
</tr>{/if}{if $mod_gutscheine_errorcode == 5}<tr>
	<td>{$mod_gutscheine_user_Fail5}</td>
</tr>{/if}<tr>
{/if}
	<td colspan="2"><a href="javascript:history.back()">{$mod_gutscheine_user_back}</a></td>
</tr>
</table>
</form>
</center>
</table>
{/block}