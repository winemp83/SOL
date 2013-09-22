{block name="title" prepend}{$LNG.winemp_Forum_topic_title}{$topic_name}{/block}
{block name="content"}
<script type="text/javascript" src="scripts/jQuery.js?v=1829"></script>
<table>
<tr>
	<th colspan="3">
		<div width="100%" align="center">
		</div>
	</th>
</tr>
<tr>
	<th width="70%">
		<div width="60%" align="center">
			{$topic_name}
		</div>
	</th>
	<th width="10%>
		<div width="100%" align="center">
			<form action="" method="post">
			<input name="menue" value="0" type="hidden">
			<input type="submit" value="{$LNG.winemp_Forum_topic_back}" name="{$LNG.winemp_Forum_topic_back}">
			</form>
		</div>
	</th>
	<th width="20%">
		<div width="100%" align="center">
			{if $topic_close != 1}{else}<span style="color:#7CFC00;">{$LNG.winemp_Forum_topic_closed}</span>{/if}
		</div>
	</th>
</tr>
<tr>
	<th colspan="3">
		<div width="100%" align="center">
		</div>
	</th>
</tr>
{foreach item=topics from=$topic}
<tr>
	<td width="70%">
		<div width="90%" align="left">
			<span style="color:#F0F8FF;">{$topics.text}</span>
		</div>
	</td>
	<td colspan="1" valign="top">
		<div width="90%" align="center">
			<span style="color:#B8860B;"><b>{$topics.user}</b></span><br/>
			<span style="color:#CD5C5C;">{$topics.time}</span>
		</div>
	</td>
	<td>
	{if $topic_close != 1}
	<form action="" method="post">
		<input name="menue" value="5" type="hidden">
		<input name="id" value="{$topic_id}" type="hidden">
		<input type="submit" value="{$LNG.winemp_Forum_topic_closen}" name="{$LNG.winemp_Forum_topic_closen}">
	</form>
	{else}
	<span style="color:#7CFC00;">{$LNG.winemp_Forum_topic_closed}</span>
	{/if}
	</td>
</tr>
{/foreach}
<tr>
	<th colspan="3">
		<form action="" method="post">
		<input name="menue" value="3" type="hidden">
		<input name="do_it" value="no" type="hidden">
		<input name="id" value="{$topic_id}" type="hidden">
		<input type="submit" value="{$LNG.winemp_Forum_topic_answer}" name="{$LNG.winemp_Forum_topic_answer}">
		</form>
	</th>
</tr>
</table>
{/block}