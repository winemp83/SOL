
{block name="title" prepend}{$LNG.lm_messages}{/block}
{block name="content"}






<table style="width:700px; background-color: #000000;">
<tbody>
<tr>

<td>
<table style="width:700px;">
<tbody>
<th style="text-align: center"> Kategorie </th><th style="text-align: center"> {$LNG.mg_overview} </th> <th style="text-align: center"> {$LNG.mg_game_operators} </th>
<tr>
<td style="width: 200px;  background-color: #000000;">

<table style="width: 200px;">

<tbody >
<tr>

{foreach $CategoryList as $CategoryID => $CategoryRow}
		{if ($CategoryRow@iteration % 6) === 1}<tr>{/if}
		{if $CategoryRow@last && ($CategoryRow@iteration % 6) !== 0}{/if}


		<tr style="word-wrap:break-word; color:{$CategoryRow.color};"><span style="font-size: 10px; text-align: left;"><p><a  href="#" onclick="Message.getMessages({$CategoryID});return false;" style="color:{$CategoryRow.color};">{$LNG.mg_type.{$CategoryID}}</a></span>
		&nbsp;<span id="unread_{$CategoryID}">{$CategoryRow.unread}</span>/<span id="total_{$CategoryID}">{$CategoryRow.total}</span><br>
		</tr>

		{if $CategoryRow@last || ($CategoryRow@iteration % 6) === 0}</tr>{/if}
		{/foreach}

</tr>
</tbody>
</table>
</td>

<td style="width: 300px; background-color: #000000; vertical-align: top;">


<img alt="" src="./styles/theme/gow/img/nach.png">
<br>
<br>
<span id="loading" style="display:none; height:18px;"> (Lade ...)</span>
</td>
<td style="width: 200px; vertical-align: top;  background-color: #000000;">
<table style="width:200px;">
<tbody>
	
		{foreach $OperatorList as $OperatorName => $OperatorEmail}
		<tr>
			<td>{$OperatorName}<a href="mailto:{$OperatorEmail}" title="{$LNG.mg_write_mail_to_ops} {{$OperatorName}}"><img src="{$dpath}img/m.gif" alt=""></a></td>
		</tr>
	{/foreach}

</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>


{/block}
{block name="script" append}
{if !empty($category)}
<script>$(function() {
	Message.getMessages({$category}, {$side});
})</script>
{/if}
{/block}