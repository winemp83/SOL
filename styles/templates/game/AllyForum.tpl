{block name="title" prepend}{$LNG.winemp_Forum_forum_title}{/block}
{block name="content"}
<script type="text/javascript" src="scripts/jQuery.js?v=1829"></script>
<table width="100%">
<tr>
	<th colspan="5">
		<form action="" method="post">
		<input name="menue" value="2" type="hidden">
		<input type="submit" value="{$LNG.winemp_Forum_topic_create}" name="{$LNG.winemp_Forum_topic_create}">
		</form>
	</th>
</tr>
<tr>
	<th width="70%">
		{$LNG.winemp_Forum_forum_topic}
	</th>
	<th width="10%">
		{$LNG.winemp_Forum_forum_date} <br/>
		{$LNG.winemp_Forum_forum_lastdate}
	</th>
	<th width="5%">
		{$LNG.winemp_Forum_forum_user}
	</th>
	<th colspan="2">
		{$LNG.winemp_Forum_forum_close}
	</th>
</tr>
{foreach	item=topic	from=$topics}
	<tr>
		<td>
			{$topic.topic_name}
		</td>
		<td>
			{$topic.time}<br/>
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
				<span style="color:#8B0000;">{$LNG.winemp_Forum_topic_closed}</span>
			{/if}
		</td>
	</tr>
{/foreach}
</table>
{/block}