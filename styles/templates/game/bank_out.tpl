{block name="title" prepend}{$LNG.bank}{/block}
{block name="content"}

<table>

<form action="" method="post">

<input type="hidden" name="action" value="out">

	

	<tr>

		<th colspan="2">{$LNG.bank_out_header}</th>

	</tr>

	<tr>

		<td>{$LNG.bank_ressm}</td>

		<td><input name="metal" type="text" value="0"></td>

	</tr>

	<tr>

		<td>{$LNG.bank_ressc}</td>

		<td><input name="kryst" type="text" value="0"></td>

	</tr>

	<tr>

		<td>{$LNG.bank_ressd}</td>

		<td><input name="deuta" type="text" value="0"></td>

	</tr>

	<tr>

		<td colspan="2"><input type="Submit" value="{$LNG.bank_out}"></td>

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