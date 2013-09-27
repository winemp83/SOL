{include file="overall_header.tpl"}
<table width="50%">
{if $step == 1}
<form action="" method="post">
<input type="hidden" value="1" name="menue">
<input type="hidden" value="2" name="step">
<tr>
	<th colspan="3">Vote erstellen</th>
</tr>
<tr>
	<td width="30%">Frage :</td>
	<td colspan="2"><input type="text" name="question"></td>
</tr>
<tr>
	<td width="30%"> -/- </td>
	<td width="35%">Beschreibung der Antwort</td>
	<td width="35%">Antwort</td>
</tr>
<tr>
	<td width="30%"> Antwort 1 </td>
	<td width="35%"><input type="text" name="des1"></td>
	<td width="35%"><input type="text" name="ans1"></td>
</tr>
<tr>
	<td width="30%"> Antwort 2 </td>
	<td width="35%"><input type="text" name="des2"></td>
	<td width="35%"><input type="text" name="ans2"></td>
</tr>
<tr>
	<td width="30%"> Antwort 3 </td>
	<td width="35%"><input type="text" name="des3"></td>
	<td width="35%"><input type="text" name="ans3"></td>
</tr>
<tr>
	<th colspan="3"><input type="submit" value="Vote eintragen" name="vote_create"></th>
</tr>
</form>
{else}
	{if $error}
	<tr>
		<th>Fehler</th>
	</tr>
	<tr>
		<td>{$msg}</td>
	</tr>
	{else}
	<tr>
		<th>Voting erfolgreich eingetragen!</th>
	</tr>
	{/if}
{/if}
</table>
{include file="overall_footer.tpl"}