{block name="title" prepend}{$LNG.bank}{/block}
{block name="content"}
<script type="text/javascript" src="scripts/jQuery.js?v=1829"></script>
<table>
<form action="" method="post">
<input name="action" value="in" type="hidden">

	<tr>
		<th colspan="2">{$LNG.bank_in_header}</th>
	</tr>
	<tr>
		<td colspan="2">{$LNG.bank_in_info} {$LNG.bank_transCoast} {$transCoast}{$LNG.bank_tcShort}</td>
	</tr>
	<tr>
		<td>{$LNG.bank_storage}</td>
		<td>{$freeStorage}/{$maxStorage}</td>
	</tr>
	<tr>
		<td>{$LNG.bank_ressm}</td>
		<td><input name="metal" value="0" type="text"></td>
	</tr>
	<tr>
		<td>{$LNG.bank_ressc}</td>
		<td><input name="kryst" value="0" type="text"></td>
	</tr>
	<tr>
		<td>{$LNG.bank_ressd}</td>
		<td><input name="deuta" value="0" type="text"></td>
	</tr>
	<tr>
		<td colspan="2"><input value="{$LNG.bank_in}" type="submit"></td>
	</tr>
	
	<tr>
		<th colspan="2">{$LNG.bank_ress}</th>
	</tr>
	<tr>
		<td>{$LNG.bank_ressm}</td>
		<td>{$bankm}</td>
	</tr>
	<tr>
		<td>{$LNG.bank_ressc}</td>
		<td>{$bankc}</td>
	</tr>
	<tr>
		<td>{$LNG.bank_ressd}</td>
		<td>{$bankd}</td>
	</tr>

</form>
</table>
{/block}