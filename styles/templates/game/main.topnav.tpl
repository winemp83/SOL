<div id="page">
	<div id="header">
		<table id="headerTable">
			<tbody>
				<tr>
				<td id="resourceWrapper">
						<table id="resourceTable">
							<tbody>
						
							</tbody>
						</table>
					</td>
					</tr>
					<tr>
				
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

