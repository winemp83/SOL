{include file="overall_header.tpl"}
<table width="50%">
<tr>
{if $step != 1}
	{if $error}
		<th colspan="3">Fehler!</th>
	</tr>
	<tr>
		<td colspan="3">{$msg}</td>
	{else}
		<th colspan="3">Erfolg!</th>
	</tr>
	<tr>
		<td colspan="3">{$msg}</td>
	{/if}
{/else}
	<form action="" method="post">
	<input type="hidden" value="1" name="menue">
	<input type="hidden" value="1" name="do_it">
		<th colspan="3"> Vote erstellen </th>
	</tr>
	<tr>
		<th width="20%">Frage :</th>
		<td colspan="2"><input type="text" name="question"></td>
	</tr>
	<tr>
		<th width="20%"></th>
		<th width="40%">Beschreibung</th>
		<th width="40%">Antwort</th>
	</tr>
	<tr>
		<th width="20%">Antwort 1 </th>
		<td width="40%"><input type="text" name="des_one"></td>
		<td width="40%"><input type="text" name="ans_one"></td>
	</tr>
	<tr>
		<th width="20%">Antwort 2 </th>
		<td width="40%"><input type="text" name="des_two"></td>
		<td width="40%"><input type="text" name="ans_two"></td>
	</tr>
	<tr>
		<th width="20%">Antwort 3 </th>
		<td width="40%"><input type="text" name="des_tree"></td>
		<td width="40%"><input type="text" name="ans_tree"></td>
	</tr>
	<tr>
		<th colspan="3"><input type="submit" name="vote_create" value="Vote erstellen"></th>
	</tr>
{/if}
</tr>
</table>
{include file="overall_footer.tpl"}