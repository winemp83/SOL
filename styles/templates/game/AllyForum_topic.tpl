{block name="title" prepend}{$LNG.winemp_Forum_topic_title}{$topic_name}{/block}
{block name="content"}
<script type="text/javascript" src="scripts/jQuery.js?v=1829"></script>
<table style="width:950px; background-color: #000000;">
<tbody>
<tr>

<td>
<table style="width:950px;">
<tbody>
<tr>
	<th colspan="5">
		{$LNG.lm_malliForum}
	</th>
</tr>
<tr>
	<td colspan="5">
		<img alt="" src="./styles/theme/gow/img/forumpic.jpg">
	</td>
</tr>
<tr>
	<th colspan="5">
		
	</th>
</tr>


<tr>



<tr>
	<th width="85%" style="text-align: center">
		<span style="text-align: center">{$topic_name}</span>
	</th>

	</th>
	<th width="10%">
		{$LNG.winemp_Forum_forum_date} 
	</th>
	<th width="5%">
			{$LNG.winemp_Forum_forum_user}
	</th>
</tr>
{foreach item=topics from=$topic}

		
			
	<tr>
		<td width="85%">
			<span style="color:#F0F8FF;">{$topics.text}</span>
		</td>

	
	<td width="10%">
		
					<span style="color:#CD5C5C;">{$topics.time}</span>
		
	</td>
	<td width="5%">
		
			<span style="color:#B8860B;"><b>{$topics.user}</b></span><br/>
			
		
	</td>

  </tr>
<th></th>
<th width="10%"> {$LNG.lm_beitragloeschen} </th>
<th width="5%"> {$LNG.lm_beitragedit}</th>


{/foreach}

</td>
</tbody>
</table style="width:950px;">

<table style="width:950px;">
<tbody>
<tr>
	<th width="15%">
		<form action="" method="post">
		<input name="menue" value="3" type="hidden">
		<input name="do_it" value="no" type="hidden">
		<input name="id" value="{$topic_id}" type="hidden">
		<input type="submit" value="{$LNG.winemp_Forum_topic_answer}" name="{$LNG.winemp_Forum_topic_answer}">
		</form>
	</th>
	<th width="15%" style="text-align: center">
		{$LNG.lm_themaedit}
	</th>
	<th width="15%" style="text-align: center">
		{$LNG.lm_themaloeschen}
	</th>
	<th width="15% style="text-align: center">

	{if $topic_close != 1}
	<form action="" method="post">
		<input name="menue" value="5" type="hidden">
		<input name="id" value="{$topic_id}" type="hidden">
		<input type="submit" value="{$LNG.winemp_Forum_topic_closen}" name="{$LNG.winemp_Forum_topic_closen}">
	</form>
	{else}
	{/if}
		
	</th>
	<th width="15% style="text-align: center">
	
			<form action="" method="post">
			<input name="menue" value="0" type="hidden">
			<input type="submit" value="{$LNG.winemp_Forum_topic_back}" name="{$LNG.winemp_Forum_topic_back}">
			</form>
		
	</th >

</tr>

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