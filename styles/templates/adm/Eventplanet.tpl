<!DOCTYPE html>
<html>
  <head>
    <title>Planet_Event</title>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type">
  </head>
  <body> {include file="overall_header.tpl"}
    <center>
      <form action="" method="post" name="senden">
    </center>
    <table style="width:900px">
       <tbody>
        <tr>
          <th colspan="3"><font size="4">{$eventplaneten}</font></th>
        </tr>
        <tr>
          <td><input name="planetevent" value="1"  type="checkbox">
            {$ev_planet}<br>
          </td>
          <td><input name="TF_Event" value="1"  type="checkbox">
            {$ev_tfplanet}<br>
          </td>
          <td ><input name="ev_attack" value="1"  type="checkbox">
            {$ev_attack}</td>
	  <td style="color:red"><input name="ev_attack" value="1"  type="checkbox">
            Save Fluege</td>

        </tr>
        <tr>
          <th colspan="2">
            <center><font size="2"><u>{$verteidigung}:</u></font></center>
            <font size="2"> </font></th>
          <th>
            <center><font size="2"><u>{$ev_angriff}:</u></font></center>
          </th>
<th style="color:red">
         <center><font size="2"><u>Save Fluege:</u></font></center>
</th>
        </tr>
        <tr>
          <th>{$k_schildkuppel}<br>
          </th>
          
          <th>
            <center><input name="k_schild" value="1" type="checkbox"><br>
            </center>
          </th>
          <th> {$ev_attackinfo}:&nbsp;<input maxlength="2" value="60" size="2" name="ev_attval" type="text">
            %&nbsp; <br>
          </th>



          <th> {$ev_attackinfo}:&nbsp;<input maxlength="2" value="60" size="2" name="ev_attval" type="text">
            %&nbsp; <br>
          </th>



        </tr>
        <tr>
          <th>{$gr_schildkuppel}<br>
          </th>
          <th>
            <center><input name="gr_schild" value="1" type="checkbox"><br>
            </center>
          </th>
          <th>{$ev_attackinfo_msg}:&nbsp;&nbsp<input name="ev_attack_mail" value="1"  type="checkbox" checked></th><th> &nbsp;</th>
        </tr>
        <tr>
          <th>{$giga_schildkuppel}<br>
          </th>
          <th>
            <center><input name="g_schild" value="1" type="checkbox"><br>
            </center>
          </th>
          <th> &nbsp;</th><th> &nbsp;</th>
        </tr>
   <tr>
          <th>Raketenwerfer | max:<br>
          </th>
          <th><center><input value="0" name="raket_bis" size="20" type="text"><br>
          </th>
         

  <th style="color:red">Leichter Laser | max:<br>
          </th>
          <th><center><input value="0" name="slaser_bis" size="20" type="text"><br>
          </th>
         </tr>
   <tr>
          <th>Schwere Laeser | max:<br>
          </th>
          <th><center><input value="0" name="slaser_bis" size="20" type="text"><br>
          </th>
          
  <th style="color:red">Gravitonkanone | max:<br>
          </th>
          <th><center><input value="0" name="slaser_bis" size="20" type="text"><br>
          </th>
          </tr>
   <tr>
          <th>Ionen | max:<br>
          </th>
          <th><center><input value="0" name="ionen_bis" size="20" type="text"><br>
          </th>
          
  <th style="color:red">Orbitale Verteidigung | max:<br>
          </th>
          <th><center><input value="0" name="slaser_bis" size="20" type="text"><br>
          </th>
         </tr>
        <tr>
          <th>{$gausskanone} | max:<br>
          </th>
          <th><center><input value="0" name="gauss_bis" size="20" type="text"><br>
          </th>
          <th>&nbsp;</th><th>&nbsp;</th>
        </tr>
        <tr>
          <th>{$plasmawerfer} | max:<br>
          </th>
          <th><center><input value="0" name="plasma_bis" size="20" type="text"><br>
          </th>
          <th>&nbsp;</th><th>&nbsp;</th>
        </tr>
        <tr>
          <td><br>
          </td>
          <td><br>
          </td>
          <td>&nbsp;</td><td>&nbsp;</td>
        </tr>
        <tr>
          <th colspan="2">
            <center><u><font size="2">{$schiffe}</font>:</u> </center>
          </th>
          <th> &nbsp;</th><th>&nbsp;</th>
        </tr>    
        <tr>
          <th>Kleine Transporter | max:<br>
          </th>
          <th><center><input value="0" name="ktrans_bis" size="20" type="text"><br>
          </th>

        <th style="color:red">Kreuzer | max:<br>
          </th>
          <th><center><input value="0" name="ktrans_bis" size="20" type="text"><br>
          </th>
        </tr>

            <tr>
          <th>Grosse Transporter | max:<br>
          </th>
          <th><center><input value="0" name="gtrans_bis" size="20" type="text"><br>
          </th>
           <th style="color:red">Bomber | max:<br>
          </th>
          <th><center><input value="0" name="ktrans_bis" size="20" type="text"><br>
          </th>

        </tr>
        <tr>
          <th>{$l_jaeger} | max:<br>
          </th>
          <th><center><input value="0" name="ljaeger_bis" size="20" type="text"><br>
          </th>
           <th style="color:red">Zerstörer | max:<br>
          </th>
          <th><center><input value="0" name="ktrans_bis" size="20" type="text"><br>
          </th>
        </tr>
            <tr>
          <th>SchwereJaeger | max:<br>
          </th>
          <th><center><input value="0" name="sjaeger_bis" size="20" type="text"><br>
          </th>
           <th style="color:red">Evolution Transporter | max:<br>
          </th>
          <th><center><input value="0" name="ktrans_bis" size="20" type="text"><br>
          </th>

        </tr>
        <tr>
          <th>{$schlachtschiff} | max:<br>
          </th>
          <th><center><input value="0" name="schlachts_bis" size="20" type="text"><br>
          </th>
           <th style="color:red">Schlachtkreuzer | max:<br>
          </th>
          <th><center><input value="0" name="ktrans_bis" size="20" type="text"><br>
          </th>
        </tr>
        <tr>
          <th>{$todesstern} | max:<br>
          </th>
          <th><center><input value="0" name="todesstern_bis" size="20" type="text"><br>
          </th>
           <th style="color:red">Avatar | max:<br>
          </th>
          <th><center><input value="0" name="ktrans_bis" size="20" type="text"><br>
          </th>
        </tr>
        <tr>
          <th>{$lune} | max:<br>
          </th>
          <th><center><input value="0" name="lune_bis" size="20" type="text"><br>
          </th>
          <th style="color:red">Giga / Recycler | max:<br>
          </th>
          <th><center><input value="0" name="ktrans_bis" size="20" type="text"><br>
          </th>
        </tr>
        <tr>
          <td><br>
          </td>
          <td><br>
          </td>
          <td>&nbsp;</td> <td>&nbsp;</td>
        </tr>
        <tr>
          <th colspan="2">
            <center><u><font size="2">{$planetdata}:</font></u><font size="4"> </font>
            </center>
          </th>
          <th style="color:red">Rote Schrifft = Inaktiv momentan </th><th style="color:red"></th>
        </tr>
        <tr>
          <th>{$name}:</th>
          <th><center><input name="planet_name" size="20" value="EV-Planet" type="text"></th>
          <th>&nbsp;</th><th>&nbsp;</th>
        </tr>
        <tr>
          <th>{$user_id}:</th>
          <th><center><input name="id_user" size="20" type="text"></th>
          <th>&nbsp;</th><th>&nbsp;</th>
        </tr>
        <tr>
          <th>{$planeten_anzahl}:</th>
          <th><center><input size="3" maxlength="3" name="anzahl" value="100" type="text"></th>
          <th>&nbsp;</th><th>&nbsp;</th>
        </tr>
        <tr>
          <th>{$position_von}:</th>
          <th><center><input size="3" maxlength="3" name="galaxy" value="1" type="text">
            - <input name="system" size="3" maxlength="3" value="1" type="text">
            - <input name="planet" size="3" maxlength="3" value="1" type="text">
            {$galaxy_fehler} {$system_fehler} {$planet_fehler}</th>
          <th>&nbsp;</th><th>&nbsp;</th>
        </tr>
        <tr>
          <th>{$position_bis}:</th>
          <th><center><input size="3" maxlength="3" name="galaxy_2" value="9" type="text">
            - <input name="system_2" size="3" maxlength="3" value="400" type="text">
            - <input name="planet_2" size="3" maxlength="3" value="15" type="text">
            {$galaxy_fehler2} {$system_fehler2} {$planet_fehler2}</th>
          <th>&nbsp;</th><th>&nbsp;</th>
        </tr>
        <tr>
          <th>{$rohstoffe_von}:</th>
          <th><center><input name="ress_von" size="20" type="text"></th>
          <th>&nbsp;</th><th>&nbsp;</th>
        </tr>
        <tr>
          <th>{$rohstoffe_bis}:</th>
          <th><center><input name="ress_bis" size="20" type="text"></th>
          <th>&nbsp;</th><th>&nbsp;</th>
        </tr>
        <tr>
          <td><br>
          </td>
          <td><br>
          </td>
          <td>&nbsp;</td><td>&nbsp;</td>
        </tr>
        <tr>
          <th><center><input name="anzplanet" value="{$anzplanet}" type="submit"></th>
          <th><br>
          </th>
          <th><center><input name="delleertf" value="{$ev_delempty}" type="submit"></th>
	  <th>&nbsp;</th>
        </tr>
        <tr>
          <th><center><input name="anztf" value="{$ev_anzevtf}" type="submit"></th>
          <th><center><input name="senden" value="{$ev_start}" type="submit"></th>
          <th><center><input name="loeschen" value="{$ev_delall}" type="submit"></th>
	  <th>&nbsp;</th>
         </tr>
      </tbody>
    </table>
	</form>
    {include file="overall_footer.tpl"}
    <p><br>
    </p>
  </body>
</html>