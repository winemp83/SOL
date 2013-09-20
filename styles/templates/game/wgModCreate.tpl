{block name="content"}
<table class="table569">
<center>
<form action="" method="post">
<input type="hidden" name="value" value="buyB">
<table width="70%" cellpadding="2" cellspacing="2">
<tr>
	<th>{$wg_mod_buy_header}</th>
</tr>
{if $wg_mod_buy_choise == 1}
<tr>
	<td>{$wg_mod_buy_description}</td>
</tr>
<tr>
<td colspan="2"><input value="{$wg_mod_buy_submit}" type="submit"></td>
</tr>
{/if}
{if $wg_mod_buy_choise == 2}
<tr>
	<td>{$wg_mod_buy_suecess}</td>
</tr>
<tr>
	<td>{$wg_mod_buy_keyA}{$wg_mod_buy_key}</td>
</tr>
{/if}
{if $wg_mod_buy_choise == 2}
	<td>{$wg_mod_buy_error}</td>
{/if}
<tr><td colspan="2"><a href="javascript:history.back()">{$WG_mod_back}</a></td>
</tr>
<tr>
	<td>{$wg_mod_buy_footer}</td>
</tr>
</table>
</form>
</center>
</table>
{/block}