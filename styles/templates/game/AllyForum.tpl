{block name="title" prepend}{$LNG.winemp_Forum_forum_title}{/block}
{block name="content"}
<script type="text/javascript" src="scripts/jQuery.js?v=1829"></script>


<table style="width:700px; background-color: #000000;">
<tbody>
<tr>

<td>
<table style="width:950px;">
<tbody>
<tr>
	<th colspan="5">
		Allianz Forum
	</th>
</tr>
<tr>
	<td colspan="5">
		<img alt="" src="./styles/theme/gow/img/forumpic.jpg">
	</td>
</tr>
<tr>
	<th colspan="5">
		<form action="" method="post">
		<input name="menue" value="2" type="hidden">
		<input type="submit" value="{$LNG.winemp_Forum_topic_create}" name="{$LNG.winemp_Forum_topic_create}">
		</form>
	</th>
</tr>


<tr>



<tr>
	<th width="40%">
		{$LNG.winemp_Forum_forum_topic}
	</th>

	<th width="10%">
		{$LNG.winemp_Forum_forum_date} 
		
	</th>
	<th width="10%">
		{$LNG.winemp_Forum_forum_lastdate}
	</th>
	<th width="5%">
		{$LNG.winemp_Forum_forum_user}
	</th>
	<th width="15%">
		{$LNG.winemp_Forum_forum_close}
	</th>
</tr>
{foreach	item=topic	from=$topics}
	<tr>
		<td>
			{$topic.topic_name}
		</td>
<td>
			{$topic.time}
		</td>
		<td>
			
			{$topic.lastinsert}
		</td>
		<td>
			{$topic.author}
		</td>
		<td>
			{if $topic.close != 1}
				<form action="" method="post">
					<input name="menue" value="1" type="hidden">
					<input name="id" value="{$topic.id}" type="hidden">
					<input type="submit" value="{$LNG.winemp_Forum_topic_show}" name="{$LNG.winemp_Forum_topic_show}">
				</form>
			{else}
				<span style="color:red;"><b>{$LNG.winemp_Forum_topic_closed}</b></span><br/>
				<form action="" method="post">
					<input name="menue" value="1" type="hidden">
					<input name="id" value="{$topic.id}" type="hidden">
					<input type="submit" value="{$LNG.winemp_Forum_topic_show}" name="{$LNG.winemp_Forum_topic_show}">
				</form>
			{/if}
		</td>
	</tr>
{/foreach}
</td>


</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>

<table width="100%">

</table>
{/block}