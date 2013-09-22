{block name="title" prepend}{$LNG.winemp_Forum_error_title}{/block}
{block name="content"}
<script type="text/javascript" src="scripts/jQuery.js?v=1829"></script>
<table>
<form action="" method="post">
<input name="menue" value="0" type="hidden">
<tr>
	<th colspan="2"><div width="100%" align="center"><span style="color:#ff2400;">{$LNG.winemp_Forum_error}</div></span></th>
</tr>
<tr>
	<th colspan="2"><div width="100%" align="center"><span style="color:#8c7853;">{$msg}</span></div></th>
</tr>
<tr>
	<td colspan="2"><div width="100%" align="center"><input type="submit" value="{$LNG.winemp_Forum_error_back}" name="{$LNG.winemp_Forum_error_back}"></div></td>
</tr>
</form>
</table>
{/block}