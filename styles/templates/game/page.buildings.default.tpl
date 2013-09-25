{block name="title" prepend}{$LNG.lm_buildings}{/block}

{block name="content"}
<script type="text/javascript" src="././././scripts/game/domtab.js"></script>

<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
	</script>





<table style=" background-color: #000000;">
<tbody>
<tr>

<td>
<table style="width:950px;">
<tbody>
<tr>
	<th colspan="5">
	{$LNG.lm_buildings}
	</th>
</tr>
<tr>
	<td colspan="5" style="width: 950px;">
		<img src="./styles/theme/gow/img/gebaude.jpg">

{if !empty($Queue)}
<div id="buildlist" class="buildlist">
	<table style="width:950px;">
		{foreach $Queue as $List}
		{$ID = $List.element}
		<tr>
			<td style="width:70%;vertical-align:top;" class="left">
				{$List@iteration}.: 
				{if !($isBusy.research && ($ID == 6 || $ID == 31)) && !($isBusy.shipyard && ($ID == 15 || $ID == 21)) && $RoomIsOk && $CanBuildElement && $BuildInfoList[$ID].buyable}
				<form class="build_form" action="game.php?page=buildings" method="post">
				
					<input type="hidden" name="cmd" value="insert">
					<input type="hidden" name="building" value="{$ID}">
					<button type="submit" class="build_submit onlist">{$LNG.tech.{$ID}} {$List.level}{if $List.destroy} {$LNG.bd_dismantle}{/if}</button>
					<button type="submit" class="knopf-1" style="background: transparent; width: 130px;">{$LNG.b_kupdate}</button>
				</form>

				{else}{$LNG.tech.{$ID}} {$List.level} {if $List.destroy}{$LNG.bd_dismantle}{/if}{/if}
				{if $List@first}

				<br><br><div id="progressbar" data-time="{$List.resttime}"></div>
			</td>
          
			<td>
				<div id="time" data-time="{$List.time}"><br></div>
				<form action="game.php?page=buildings" method="post" class="build_form">
					<input type="hidden" name="cmd" value="cancel">
					<button type="submit" class="build_submit onlist">{$LNG.bd_cancel}</button>

				</form>
				{else}
			</td>

			<td>
				<form action="game.php?page=buildings" method="post" class="build_form">
					<input type="hidden" name="cmd" value="remove">
					<input type="hidden" name="listid" value="{$List@iteration}">
					<button type="submit" class="build_submit onlist">{$LNG.bd_cancel}</button>
				</form>
				{/if}
				<br><span style="color:lime" data-time="{$List.endtime}" class="timer">{$List.display}</span>
			</td>
		</tr>

	{/foreach}

	</table>
</div>
{/if}
	</div>


{foreach $BuildInfoList as $ID => $Element}
<script>
    $(function() {
        $( "#build{$ID}" ).dialog({ autoOpen: false, width: 800, height: 400, modal: true,});
    });
</script>
{/foreach}

	</td>
</tr>

<td id="testmap" style="height: 500px;">
<div id="map" style="width:950px; height: 500px; overflow:hidden;">
{foreach $BuildInfoList as $ID => $Element}
{if $Element.level > 0}

<a href="#" onclick="$('#build{$ID}').dialog('open');return false;">
				<div class="build{$ID}"><span><div id="txtpos"><font color="#00ffff"><b>{$LNG.tech.{$ID}}</b> {if $Element.level > 0}<br> <font color="#ffff00"><b>({$LNG.bd_lvl} {$Element.level}{if $Element.maxLevel != 255}/{$Element.maxLevel}{/if})<b>{/if}</font><br>{if $CanBuildElement && $Element.buyable}<span style="color:orange">{if $Element.level == 0}{$LNG.bd_build}{else}{$LNG.bd_build_next_level}{$Element.level + 1}{/if}</span>{/if}</div></span></div></a>
{else}
<a href="#" onclick="$('#build{$ID}').dialog('open');return false;"><div class="build{$ID}_off"><span><div id="txtpos"><font color="#00ffff"><b>{$LNG.tech.{$ID}}</b> {if $Element.level > 0}<br> <font color="#ffff00"><b>({$LNG.bd_lvl} {$Element.level}{if $Element.maxLevel != 255}/{$Element.maxLevel}{/if})<b>{/if}</font><br>{if $CanBuildElement && $Element.buyable}<span style="color:orange">{if $Element.level == 0}{$LNG.bd_build}{else}{$LNG.bd_build_next_level}{$Element.level + 1}{/if}</span>{/if}</div></span></div></a>
{/if}
{/foreach}
{foreach $BuildInfoList as $ID => $Element}
<div id="build{$ID}" style="display:none;">
<table>
	<tr>
		<td rowspan="2" style="width:10px;">
			<a href="#" onclick="return Dialog.info({$ID})">
				<img src="{$dpath}gebaeude/{$ID}.gif" alt="{$LNG.tech.{$ID}}" width="90" height="90">
			</a>
		</td>
		<th>
			<a href="#" onclick="return Dialog.info({$ID})">{$LNG.tech.{$ID}}</a>{if $Element.level > 0} ({$LNG.bd_lvl} {$Element.level}{if $Element.maxLevel != 255}/{$Element.maxLevel}{/if}){/if}
		</th>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td class="transparent left" style="width:90%;padding:10px;"><p>{$LNG.shortDescription.{$ID}}</p>
					<p>{foreach $Element.costRessources as $RessID => $RessAmount}
					{$LNG.tech.{$RessID}}: <b><span style="color:{if $Element.costOverflow[$RessID] == 0}lime{else}red{/if}">{$RessAmount|number}</span></b>
					{/foreach}</p></td>
					<td class="transparent" style="vertical-align:middle;width:100px">
					{if $Element.maxLevel == $Element.level}
						<span style="color:red">{$LNG.bd_maxlevel}</span>
					{elseif ($isBusy.research && ($ID == 6 || $ID == 31)) || ($isBusy.shipyard && ($ID == 15 || $ID == 21))}
						<span style="color:red">{$LNG.bd_working}</span>
					{else}
						{if $RoomIsOk}
							{if $CanBuildElement && $Element.buyable}
							<form action="game.php?page=buildings" method="post" class="build_form">
								<input type="hidden" name="cmd" value="insert">
								<input type="hidden" name="building" value="{$ID}">
								<button type="submit" class="build_submit">{if $Element.level == 0}{$LNG.bd_build}{else}{$LNG.bd_build_next_level}{$Element.level + 1}{/if}</button>
							</form>
							{else}
							<span style="color:red">{if $Element.level == 0}{$LNG.bd_build}{else}{$LNG.bd_build_next_level}{$Element.level + 1}{/if}</span>
							{/if}
						{else}
						<span style="color:red">{$LNG.bd_no_more_fields}</span>
						{/if}
					{/if}
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="margin-bottom:10px;">  
			<table style="width:100%">
				<tr>
					<td class="transparent left">
						{$LNG.bd_remaining}<br>
						{foreach $Element.costOverflow as $ResType => $ResCount}
						{$LNG.tech.{$ResType}}: <span style="font-weight:700">{$ResCount|number}</span><br>
						{/foreach}
						<br>
					</td>
					<td class="transparent right">
						{$LNG.fgf_time}
					</td>
				</tr>
				<tr>		
					<td class="transparent left" style="width:68%">
						{if !empty($Element.infoEnergy)}
							{$LNG.bd_next_level}<br>
							{$Element.infoEnergy}<br>
						{/if}
						{if $Element.level > 0}
							{if $ID == 43}<a href="#" onclick="return Dialog.info({$ID})">{$LNG.bd_jump_gate_action}</a>{/if}
							{if ($ID == 44 && !$HaveMissiles) ||  $ID != 44}<br><a class="tooltip_sticky" data-tooltip-content="
								{* Start Destruction Popup *}
								<table style='width:300px'>
									<tr>
										<th colspan='2'>{$LNG.bd_price_for_destroy} {$LNG.tech.{$ID}} {$Element.level}</th>
									</tr>
									{foreach $Element.destroyRessources as $ResType => $ResCount}
									<tr>
										<td>{$LNG.tech.{$ResType}}</td>
										<td><span style='color:{if $Element.destroyOverflow[$RessID] == 0}lime{else}red{/if}'>{$ResCount|number}</span></td>
									</tr>
									{/foreach}
									<tr>
										<td>{$LNG.bd_destroy_time}</td>
										<td>{$Element.destroyTime|time}</td>
									</tr>
									<tr>
										<td colspan='2'>
											<form action='game.php?page=buildings' method='post' class='build_form'>
												<input type='hidden' name='cmd' value='destroy'>
												<input type='hidden' name='building' value='{$ID}'>
												<button type='submit' class='build_submit onlist'>{$LNG.bd_dismantle}</button>
											</form>
										</td>
									</tr>
								</table>
								{* End Destruction Popup *}
								">{$LNG.bd_dismantle}</a>{/if}
						{else}
							&nbsp;
						{/if}
					</td>
					<td class="transparent right" style="white-space:nowrap;">
						{$Element.elementTime|time}
					</td>
				</tr>	
			</table>
		</td>
	</tr>

</table>	
</div>
{/foreach}
</div>
		


</table></div>
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