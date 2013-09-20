{block name="title" prepend}Achievements{/block}
{block name="content"}
<table>
 <tbody>
		<tr>
			<th colspan=3><center>
        {lang}achievements_name{/lang}
      </th>
		</tr>
		<tr>
			<td colspan=3>
        {lang}achievements_desc{/lang}
      </td>
		</tr>
    <tr>
			<th colspan=3>
		<tr>
			<th colspan=3>
        {lang}achievements_typ_mine{/lang} - {$mine_lvl}
      </th>
		</tr>
    <tr>
			<td rowspan="2" style="width:120px;">
        <img src="styles/achievements/mines.png" alt="achievement" width="85" height="85">
      </td>
    </tr>
        <td style="width:65%;">
          {lang}achievements_mine_desc{/lang}<br><br>
        </td>
			<td style="width:35%">
        {$require}
        <ul>
          <li style="list-style:none">{$mine_req_1} {$mine_done1}</li>
          <li style="list-style:none">{$mine_req_2} {$mine_done2}</li>
          <li style="list-style:none">{$mine_req_3} {$mine_done3}</li>
        </ul>
      </td>
    </tr>
 		<tr>
			<td colspan=3>{$reward}{$mine_reward}</td>
		</tr>

		<tr>
			<th colspan=3>
        {lang}achievements_typ_research{/lang} - {$research_lvl}
      </th>
		</tr>
    <tr>
			<td rowspan="2" style="width:120px;">
        <img src="styles/achievements/research.png" alt="achievement" width="85" height="85">
      </td>
    </tr>
    <tr>
      <td style="width:65%;">
        {lang}achievements_research_desc{/lang}<br><br>
      </td>
      <td style="width:35%">
        {$require}
        <ul>
					<li style="list-style:none">{$research_req_1} {$research_done1}</li>
          <li style="list-style:none">{$research_req_2} {$research_done2}</li>
          <li style="list-style:none">{$research_req_3} {$research_done3}</li>
        </ul>
      </td>
    </tr>
 		<tr>
			<td colspan=3>{$reward}{$research_reward}</td>
		</tr>

		<tr>
			<th colspan=3>
        {lang}achievements_typ_battle{/lang} - {$battle_lvl}
      </th>
		</tr>
    <tr>
      <td rowspan="2" style="width:120px;">
				<img src="styles/achievements/battle.png" alt="achievement" width="85" height="85">
      </td>
    </tr>
    <tr>
       <td style="width:65%;">
        {lang}achievements_battle_desc{/lang}<br><br>
      </td>
      <td style="width:35%">
        {$require}
        <ul>
         <li style="list-style:none">{$battle_req_1} {$battle_done1}</li>
         <li style="list-style:none">{$battle_req_2} {$battle_done2}</li>
        </ul>
      </td>
    </tr>
    		<tr>
			<td colspan=3>{$reward}{$research_reward}</td>
		</tr>

		<tr>
			<th colspan=3>
        {lang}achievements_typ_ship{/lang} - {$ship_lvl}
      </th>
		</tr>
    <tr>
      <td rowspan="2" style="width:120px;">
				<img src="styles/achievements/ship.png" alt="achievement" width="85" height="85">
      </td>
    </tr>
    <tr>
       <td style="width:65%;">
        {lang}achievements_ship_desc{/lang}<br><br>
      </td>
      <td style="width:35%">
        {$require}
        <ul>
         <li style="list-style:none">{$ship_req_1} {$ship_done1}</li>
        </ul>
      </td>
    </tr>
    		<tr>
			<td colspan=3>{$reward}{$research_reward}</td>
		</tr>

		<tr>
			<th colspan=3>
        {lang}achievements_typ_defence{/lang} - {$defence_lvl}
      </th>
		</tr>
    <tr>
      <td rowspan="2" style="width:120px;">
				<img src="styles/achievements/defense.png" alt="achievement" width="85" height="85">
      </td>
    </tr>
    <tr>
       <td style="width:65%;">
        {lang}achievements_defence_desc{/lang}<br><br>
      </td>
      <td style="width:35%">
        {$require}
        <ul>
         <li style="list-style:none">{$defence_req_1} {$defence_done1}</li>
        </ul>
      </td>
    </tr>
    		<tr>
			<td colspan=3>{$reward}{$research_reward}</td>
		</tr>

		<tr>
			<th colspan=3>
        {lang}achievements_typ_storage{/lang} - {$storage_lvl}
      </th>
		</tr>
    <tr>
			<td rowspan="2" style="width:120px;">
        <img src="styles/achievements/storage.png" alt="achievement" width="85" height="85">
      </td>
    </tr>
    <tr>
      <td style="width:65%;">
        {lang}achievements_storage_desc{/lang}<br><br>
      </td>
      <td style="width:35%">
        {$require}
        <ul>
					<li style="list-style:none">{$storage_req_1} {$storage_done1}</li>
          <li style="list-style:none">{$storage_req_2} {$storage_done2}</li>
          <li style="list-style:none">{$storage_req_3} {$storage_done3}</li>
        </ul>
      </td>
    </tr>
 		<tr>
			<td colspan=3>{$reward}{$research_reward}</td>
		</tr>

		<tr>
			<th colspan=3>
        {lang}achievements_typ_moon{/lang} - {$moon_lvl}
      </th>
		</tr>
    <tr>
			<td rowspan="2" style="width:120px;">
        <img src="styles/achievements/moon.png" alt="achievement" width="85" height="85">
      </td>
    </tr>
    <tr>
      <td style="width:65%;">
        {lang}achievements_moon_desc{/lang}<br><br>
      </td>
      <td style="width:35%">
        {$require}
        <ul>
					<li style="list-style:none">{$moon_req_1} {$moon_done1}</li>
          <li style="list-style:none">{$moon_req_2} {$moon_done2}</li>
          <li style="list-style:none">{$moon_req_3} {$moon_done3}</li>
        </ul>
      </td>
    </tr>
 		<tr>
			<td colspan=3>{$reward}{$research_reward}</td>
		</tr>

		<tr>
			<th colspan=3>
        {lang}achievements_typ_colony{/lang} - {$colony_lvl}
      </th>
		</tr>
    <tr>
      <td rowspan="2" style="width:120px;">
				<img src="styles/achievements/colony.png" alt="achievement" width="85" height="85">
      </td>
    </tr>
    <tr>
       <td style="width:65%;">
        {lang}achievements_colony_desc{/lang}<br><br>
      </td>
      <td style="width:35%">
        {$require}
        <ul>
         <li style="list-style:none">{$colony_req_1} {$colony_done1}</li>
        </ul>
      </td>
    </tr>
		<tr>
			<td colspan=3>{$reward}{$research_reward}</td>
		</tr>

		<tr>
			<th colspan=3>
        {lang}achievements_typ_friend{/lang} - {$friend_lvl}
      </th>
		</tr>
    <tr>
      <td rowspan="2" style="width:120px;">
				<img src="styles/achievements/friend.png" alt="achievement" width="85" height="85">
      </td>
    </tr>
    <tr>
       <td style="width:65%;">
        {lang}achievements_friend_desc{/lang}<br><br>
      </td>
      <td style="width:35%">
        {$require}
        <ul>
         <li style="list-style:none">{$friend_req_1} {$friend_done1}</li>
        </ul>
      </td>
    </tr>
		<tr>
			<td colspan=3>{$reward}{$research_reward}</td>
		</tr>

		<tr>
			<th colspan=3>
        {lang}achievements_typ_statpoints{/lang} - {$statpoints_lvl}
      </th>
		</tr>
    <tr>
      <td rowspan="2" style="width:120px;">
				<img src="styles/achievements/statpoints.png" alt="achievement" width="85" height="85">
      </td>
    </tr>
    <tr>
       <td style="width:65%;">
        {lang}achievements_statpoints_desc{/lang}<br><br>
      </td>
      <td style="width:35%">
        {$require}
        <ul>
         <li style="list-style:none">{$statpoints_req_1} {$statpoints_done1}</li>
        </ul>
      </td>
    </tr>
		<tr>
			<td colspan=3>{$reward}{$research_reward}</td>
		</tr>

		<tr>
			<th colspan=3>
        {lang}achievements_typ_destroy{/lang} - {$destroy_lvl}
      </th>
		</tr>
    <tr>
      <td rowspan="2" style="width:120px;">
				<img src="styles/achievements/destroy.png" alt="achievement" width="85" height="85">
      </td>
    </tr>
    <tr>
       <td style="width:65%;">
        {lang}achievements_destroy_desc{/lang}<br><br>
      </td>
      <td style="width:35%">
        {$require}
        <ul>
         <li style="list-style:none">{$destroy_req_1} {$destroy_done1}</li>
        </ul>
      </td>
    </tr>
		<tr>
			<td colspan=3>{$reward}{$research_reward}</td>
		</tr>

		<tr>
			<th colspan=3>
        {lang}achievements_typ_debris{/lang} - {$debris_lvl}
      </th>
		</tr>
    <tr>
      <td rowspan="2" style="width:120px;">
				<img src="styles/achievements/debris.png" alt="achievement" width="85" height="85">
      </td>
    </tr>
    <tr>
       <td style="width:65%;">
        {lang}achievements_debris_desc{/lang}<br><br>
      </td>
      <td style="width:35%">
        {$require}
        <ul>
         <li style="list-style:none">{$debris_req_1} {$debris_done1}</li>
        </ul>
      </td>
    </tr>
		<tr>
			<td colspan=3>{$reward}{$research_reward}</td>
		</tr>

        </tbody>
    </table>
</div>
{/block}