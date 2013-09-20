{block name="title" prepend}{$LNG.tut_welcome}{/block}
{block name="content"}
<table class="table519">
	<tbody>
		<tr>
			<th colspan="10" class="kategorie"><div align="center">{$tut_welcome}</div></th>
		</tr>
		<tr>
			<td colspan="10" class="table519">
					<p>{$LNG.tut_welcom_desc}</p>
						<ul id="aufgabe_liste" style="text-align: left;">
							<li class="aufzaehlungszeichen">{$LNG.tut_welcom_desc2}</li>
							<li class="aufzaehlungszeichen">{$LNG.tut_welcom_desc3}</li>
							<li class="aufzaehlungszeichen">{$LNG.tut_welcom_desc4}</li>
							<li class="aufzaehlungszeichen">{$LNG.tut_welcom_desc5}</li>
						</ul>
			</td>
		</tr>
		<tr>
			<td colspan="10">
				<a href ="?page=tutorial&mode=m1"><input type="submit" style="cursor: pointer; width: 180px; height: 27px;" value="{$LNG.tut_go}" onclick="window.location = '?page=tutorial&mode=m1'"/></a>
			</td>
		</tr>
</tbody></table>{/block}