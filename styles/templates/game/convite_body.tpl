{block name="title" prepend}Allianz Einladung{/block}
{block name="content"}
<form action="game.php?page=Convite&mode=change" method="post">
<table width="519">
    <tr>
        <th class="c" colspan="2"><center>Allianz Einladung</center></th>
    </tr>
    <tr>
        <td>Name:</td>
        <td><center><input type="text" value="{$username}" name="username"></center></td>
    </tr>
    <tr>
        <td colspan="2"><input class="submit" value="Send" type="submit"></td>
    </tr>
</table>
</form>
{/block}