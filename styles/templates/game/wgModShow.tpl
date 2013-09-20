{block name="content"}
<table class="table569">
<center>
<form action="" method="post">
<input type="hidden" name="opt_save" value="1">
<table width="70%" cellpadding="2" cellspacing="2">
<tr>
	<th colspan="2">{$WG_mod_header}</th>
</tr>
{if $wg_mod_fail == 2}
<tr>
	<th colspan="2">{$WG_mod_sucess}</th>
</tr><tr>
<td>{$WG_mod_sucess1}</td>
<td>
	<br><b>{$WG_mod_metall}</b> Metall
	<br><b>{$WG_mod_kristall}</b> Kristall
	<br><b>{$WG_mod_deuterium}</b> Deuterium
	<br><b>{$WG_mod_darkmatter}</b> Dunkle Matterie</td>
</tr>
{/if}
{if  $wg_mod_fail == 1}
<tr>
</tr><tr>
	<td>{$WG_mod_code}
	<td><input name="gutscheineCode" type="text" maxlength="60" style="background:gold;color:black;"></td>
</tr><tr>
	<td colspan="2"><input value="{$WG_mod_submit}" type="submit"></td>
</tr>
{/if}
<tr>
{if $wg_mod_fail == 3}
	<td>{$WG_mod_Fail_text}</td>
</tr><tr>
	<td>{$WG_mod_error}</td>
</tr>
{/if}
</form>

<tr><td colspan="2"><a href="javascript:history.back()">{$WG_mod_back}</a></td>
</tr>
<tr>
	<td colspan="2">{$WG_mod_footer}</td>
</tr>
</table>
</center>
</table>
{/block}