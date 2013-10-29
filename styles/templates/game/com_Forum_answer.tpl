{block name="title" prepend}{$LNG.winemp_Forum_forum_title}{/block}
{block name="content"}
<script type="text/javascript" src="scripts/jQuery.js?v=1829"></script>


<table style="width:700px; background-color: #000000;">
<tbody>
<tr>
	<th colspan="2">
		Space of Legends Forum 
	</th>
	<th>
	<form action="" method="post">
		<input type="hidden" name="menue" value="4">
		<input type="hidden" name="topic_id" value="{$top_id}">
		<input type="hidden" name="step" value="1">
		<input type="submit" name="new_answ" value="Antworten">
	</form>
	</th>
	<th>
		<div width="100%" align="center">Thema: {$top_name}</div>
	</th>
	<th>
		<div width="100%" align="right">Kategorie: {$kat_name}</div>
	</th>
</tr>
<tr>
	<td colspan="5">
		<img alt="" src="./styles/theme/gow/img/forumpic.jpg">
	</td>
</tr>
<tr>
	<td colspan="5">
	<table style="width:950px;">
		<tbody>
		<tr>
			<td width="75%">
				Antwort
			</td>
			<td width="25%">
				Spieler Info
			</td>
		</tr>
		{foreach item=answer from=$ans}
		<tr>
			<td>
				{if $answer.ans_adm == 2}
				<span style="color:lightblue;"><b>{$answer.ans_text}</b></span>
				{elseif $answer.ans_adm == 1}
				<span style="color:gold;"><b>{$answer.ans_text}</b></span>
				{elseif $answer.ans_adm == 3}
				<span style="color:#FF6600;"><b>{$answer.ans_text}</b></span>
				{elseif $answer.ans_adm == 4}
				<span style="color:lightgreen;"><b>{$answer.ans_text}</b></span>
				{else}
				<span style="color:silver;"><b>{$answer.ans_text}</b></span>
				{/if}
			</td>
			<td>
				Spieler: {$answer.ans_user}<br/>
				{if $answer.ans_create == $answer.ans_edit}
				Erstellt: {$answer.ans_create}<br/>
				{else}
				Geändert am: {$answer.ans_edit}<br/>
				{/if}
				{if ($answer.ans_admone && ($close == 0)) || $adm }
				<form action="" method="post">
					<input type="hidden" name="menue" value="8">
					<input type="hidden" name="ans_id" value="{$answer.ans_id}">
					<input type="hidden" name="topic_id" value="{$top_id}">
					<input type="hidden" name="step" value="1">
					<input type="hidden" name="text" value="{$answer.ans_text}">
					<input type="submit" name="edit" Value="Antwort editieren"><br/>
				</form>
				{/if}
				{if $adm}
				<form action="" method="post">
					<input type="hidden" name="menue" value="6">
					<input type="hidden" name="ans_id" value="{$answer.ans_id}">
					<input type="submit" name="dell" Value="Antwort löschen"><br/>
				</form>
				{/if}
			</td>
		</tr>
		{/foreach}
		<tr>
			<th>
			{if $close == 0} 
			<form action="" method="post">
				<input type="hidden" name="menue" value="4">
				<input type="hidden" name="topic_id" value="{$top_id}">
				<input type="hidden" name="step" value="1">
				<input type="submit" name="new_answ" value="Antworten">
			</form>
			{else}
			GESCHLOSSEN
			{/if}
			</th>
			<th>
			<div width="100%" align="right">
				<form action="" method="post">
					<input type="hidden" name="menue" value="1">
					<input type="hidden" name="kat_id" value="{$kat_id}">
					<input type="submit" name="back" value="zurück">
				</form>
			</div>
			</th>
		</tr>
		</tbody>
	</table>
	</td>
</tr>
<table width="100%">

</table>
</table>
{/block}