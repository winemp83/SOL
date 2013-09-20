<div id="page">
	<div id="header">
		<table id="headerTable">
			<tbody>
				<tr>
				<td id="resourceWrapper">
						<table id="resourceTable">
							<tbody>
								<tr>
									<td><a href="?page=messages"><img src="{$dpath}images/message{if $new_message > 0}_active{/if}.gif" width="42" height="22"></td>
									{foreach $resourceTable as $resourceID => $resouceData}
									<td><img src="{$dpath}images/{$resouceData.name}.gif" alt=""></td>
									{/foreach}                                                  
								</tr>
								<tr>
									<td class="res_name">Nachrichten</td>
									{foreach $resourceTable as $resourceID => $resouceData}
									<td class="res_name">{$LNG.tech.$resourceID}</td>
									{/foreach}

								</tr>
								{if $shortlyNumber}
								<tr>
									<td>&nbsp;</td>
									{foreach $resourceTable as $resourceID => $resouceData}
									{if !isset($resouceData.current)}
									{$resouceData.current = $resouceData.max + $resouceData.used}
									<td class="res_current tooltip" data-tooltip-content="{$resouceData.current|number}&nbsp;/&nbsp;{$resouceData.max|number}"><span{if $resouceData.current < 0} style="color:red"{/if}>{shortly_number($resouceData.current)}&nbsp;/&nbsp;{shortly_number($resouceData.max)}</span></td>
									{else}
									<td class="res_current tooltip" id="current_{$resouceData.name}" data-real="{$resouceData.current}" data-tooltip-content="{$resouceData.current|number}">{shortly_number($resouceData.current)}</td>
									{/if}
									{/foreach}
                 				</tr>
								<tr>
									<td>&nbsp;</td>
									{foreach $resourceTable as $resourceID => $resouceData}
									{if !isset($resouceData.current) || !isset($resouceData.max)}
									<td>&nbsp;</td>
									{else}
									<td class="res_max tooltip" id="max_{$resouceData.name}" data-real="{$resouceData.max}" data-tooltip-content="{$resouceData.max|number}">{shortly_number($resouceData.max)}</td>
									{/if}
									{/foreach}
								</tr>
								{else}
								<tr>
									<td class="res_current">{if $new_message > 0}<a href="?page=messages"><b>{$new_message}{/if}</b></td>
									{foreach $resourceTable as $resourceID => $resouceData}
									{if !isset($resouceData.current)}
									{$resouceData.current = $resouceData.max + $resouceData.used}
									<td class="res_current"><span{if $resouceData.current < 0} style="color:red"{/if}>{$resouceData.current|number}&nbsp;/&nbsp;{$resouceData.max|number}</span></td>
									{else}
									<td class="res_current" id="current_{$resouceData.name}" data-real="{$resouceData.current}">{$resouceData.current|number}</td>
									{/if}
									{/foreach}
								</tr>
								<tr>
									<td>&nbsp;</td>
									{foreach $resourceTable as $resourceID => $resouceData}
									{if !isset($resouceData.current) || !isset($resouceData.max)}
									<td>&nbsp;</td>
									{else}
									<td class="res_max" id="max_{$resouceData.name}" data-real="{$resouceData.current}">{$resouceData.max|number}</td>
									{/if}
									{/foreach}
								</tr>
								{/if}
							</tbody>
						</table>
					</td>
					</tr>
					<tr>
						<td style="background-color:black;color:gold;">
						{if $is_news}
						<marquee scrollamount="3" scrolldelay="5">{$news}</marquee>
						{/if}
						</td>
					</tr>
			</tbody>
		</table> 
		{if !$vmode}
		<script type="text/javascript">
		var viewShortlyNumber	= {$shortlyNumber|json}
		var vacation			= {$vmode};
		{foreach $resourceTable as $resourceID => $resouceData}
		{if isset($resouceData.production)}
		resourceTicker({
			available: {$resouceData.current|json},
			limit: [0, {$resouceData.max|json}],
			production: {$resouceData.production|json},
			valueElem: "current_{$resouceData.name}"
		}, true);
		{/if}
		{/foreach}
		</script>
		{/if}

	</div>

