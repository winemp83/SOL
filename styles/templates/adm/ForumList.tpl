{include file="overall_header.tpl"}
<table width="90%">
{if $tread}
<tr>
	<th colspan="3">
		{$topic_name}
	</th>
	<th>
		{if $topic_close == 0}
		<span style="color:gold;"><b>OFFEN</b></span>
		{else}
		<span style="color:red;"><b>GESCHLOSSEN</b></span>
		{/if}
	</th>
	<th>
		{$topic_id}
	</th>
</tr>
<tr>
	<th width="5%">ID</th>
	<th width="60%">Nachricht</th>
	<th width="10%">Create Date</th>
	<th width="15%">User</th>
	<th width="10%">Allianz</th>
</tr>
{foreach item=tread from=$list}
	<tr>
		<td>{$tread.tread_id}</td>
		<td>{$tread.text}</td>
		<td>{$tread.time}</td>
		<td>{$tread.user}</td>
		<td>{$tread.ally}</td>
	</tr>
	<tr>
		<th colspan="2"></th>
		<td>
		<form action="" method="post">
			<input type="hidden" name="id" value="{$tread.tread_id}">
			<input type="hidden" name="menue" value="2">
			<input type="submit" name="antwort_loeschen" value="Antwort Löschen">
		</form>
		</td>
		<th colspan="2"></th>
	</tr>
{/foreach}
<tr>
	<th colspan="2">
	<form action="" method="post">
		<input type="hidden" name="id" value="{$topic_id}">
		<input type="hidden" name="menue" value="3">
		<input type="submit" name="topic_schließen" value="Topic Schließen">
	</form>
	</th>
	<td>
	<form action="" method="post">
		<input type="hidden" name="menue" value="5">
		<input type="submit" name="Uebersicht" value="zurück">
	</form>
	</td>
	<th colspan="2">
	<form action="" method="post">
		<input type="hidden" name="id" value="{$topic_id}">
		<input type="hidden" name="menue" value="4">
		<input type="submit" name="topic_loeschen" value="Topic löschen">
	</form>
	</th>
</tr>
{else}
<tr>
	<th width="5%">ID</th>
	<th width="60%">Name</th>
	<th width="10%">Create Date</th>
	<th width="15%">Author</th>
	<th width="10%">Allianz</th>
</tr>
{foreach item=topic from=$list}
	<tr>
		<td>{$topic.id}</td>
		<td>{$topic.name}</td>
		<td>{$topic.create}</td>
		<td>{$topic.author}</td>
		<td>{$topic.ally}</td>
	</tr>
	<tr>
		<th colspan="2">
			<form action="" method="post">
				<input type="hidden" name="id" value="{$topic.id}">
				<input type="hidden" name="menue" value="1">
				<input type="submit" name="ansehen" value="ansehen">
			</form>
		</th>
		<td colspan="3" align="right">
			{if $topic.close == 0}
			<span style="color:gold;"><b>OFFEN</b></span>
			{else}
			<span style="color:red;"><b>GESCHLOSSEN</b></span>
			{/if}
		</td>
	</tr>
	<tr>
	<th colspan="2">
	<form action="" method="post">
		<input type="hidden" name="id" value="{$topic.id}">
		<input type="hidden" name="menue" value="3">
		<input type="submit" name="topic_schließen" value="Topic Schließen">
	</form>
	</th>
	<td>
	</td>
	<th colspan="2">
		<form action="" method="post">
		<input type="hidden" name="id" value="{$topic.id}">
		<input type="hidden" name="menue" value="4">
		<input type="submit" name="topic_loeschen" value="Topic löschen">
	</form>
	</th>
</tr>
{/foreach}
{/if}
</table>
{include file="overall_footer.tpl"}