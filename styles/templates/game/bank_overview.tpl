{block name="title" prepend}{$LNG.bank}{/block}
{block name="content"}

<table>


	<tr>

		<td colspan="2">

			{$LNG.bank_info}<br>

			{$LNG.bank_transCoast} {$transCoast}{$LNG.bank_tcShort}

		</td>

	</tr>

	<tr>

		<th colspan="2">{$LNG.bank_ress}</th>

	</tr>

	<tr>

		<td>{$LNG.bank_storage}</td>

		<td>{$freeStorage}/{$maxStorage}</td>

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

	<tr>

		<th colspan="2">{$LNG.bank_choice}</th>

	</tr>

	<tr>

		<td><a href="?page=bank&mode=in">{$LNG.bank_in}</a></td>

		<td><a href="?page=bank&mode=out">{$LNG.bank_out}</a></td>

	</tr>		

</table>

{/block}
