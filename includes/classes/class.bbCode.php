<?php
namespace Own;

/**
* This is a class that is used to parse a string and format it
* for BBCode. This class implements the use of a unique
* identifier, for the purpose of saving resources, post-database.
*
* @author Matt Carroll <admin@develogix.com>
* @copyright Copyright 2004-2013 Matt Carroll
* http://gnu.org/copyleft/gpl.html GNU GPL
* @version $Id: bbcode.class.php,v 3.1.0 2013/02/10 07:20:00 GMT develogix Exp $
*
* This version updates the class to PHP5, as well as implementing a new method of parsing.
*
* private @param str string to be parsed
* public @param uid unique identifier with a length of 8 characters
* private @param action 'pre' or 'post' database
*
* private @param added array holding added simple tags and data
*
* private @param list true to allow bbList, false to disallow
* private @param simple true to allow bbSimple, false to disallow
* private @param abbr true to allow bbAbbr, false to disallow
* private @param quote true to allow bbQuote, false to disallow
* private @param mail true to allow bbMail, false to disallow
* private @param url true to allow bbUrl, false to disallow
* private @param img true to allow bbImg, false to disallow
*
* private @param imgLimit amount of images to be parsed (-1 for unlimited)
*/
class BBCode {
    public function parse($str)
{
  # HTML Zeichen maskieren
  $str = htmlentities($str);
 
  # Smilies
  #$str = str_replace(':)', '<img src="smile.gif" />', $str);
  #$str = str_replace(':lol:', '<img src="lol.gif" />', $str);
  #$str = str_replace(':cool:', '<img src="cool.gif" />', $str);
  #$str = str_replace(':thumb:', '<img src="mr_green.gif" />', $str);
  #$str = str_replace(':eek:', '<img src="eek.gif" />', $str);
  $str = str_replace(':server_out:', "<img src='http://www.smilies.4-user.de/include/Computer/smilie_pc_007.gif' />", $str);
  $str = str_replace(':supporter:', "<img src='http://www.smilies.4-user.de/include/Computer/smilie_pc_057.gif' />", $str);
  $str = str_replace(':linux:', "<img src='http://www.smilies.4-user.de/include/Computer/smilie_pc_129.gif' />", $str);
  $str = str_replace(':unschuldig:', "<img src='http://www.smilies.4-user.de/include/Engel/smilie_engel_123.gif' />", $str);
  $str = str_replace(':wtf:', "<img src='http://www.smilies.4-user.de/include/Schock/smilie_sh_026.gif' />", $str);
  
  # Formatierungen
  $str = preg_replace('#\[b\](.*)\[/b\]#isU', "<b>$1</b>", $str);
  $str = preg_replace('#\[i\](.*)\[/i\]#isU', "<i>$1</i>", $str);
  $str = preg_replace('#\[u\](.*)\[/u\]#isU', "<u>$1</u>", $str);
  $str = preg_replace('#\[color=(.*)\](.*)\[/color\]#isU', "<span style='color: $1'>$2</span>", $str);
  $str = preg_replace('#\[size=(8|10|12|16)\](.*)\[/size\]#isU', "<span style='font-size: $1 pt'>$2</span>", $str);
  $str = preg_replace('#\[ueberschrift\](.*)\[/ueberschrift\]#isU', "<h3>$1</h3>", $str);
  
  # Links
  $str = preg_replace('#\[url\](.*)\[/url\]#isU', "<a href='$1'>$1</a>", $str);
  $str = preg_replace('#\[url=(.*)\](.*)\[/url\]#isU', "<a href='$1'>$2</a>", $str);
 
  # Grafiken
  $str = preg_replace('#\[img\](.*)\[/img\]#isU', "<img src='$1' alt='$1' width='200px' height='200px'/>", $str);
 
  # Zitate
  $str = preg_replace('#\[quote\](.*)\[/quote\]#isU', "<div class='zitat'>$1</div>", $str);
   
  # Quelltext
  $str = preg_replace('#\[code\](.*)\[/code\]#isU', "<div class='code'>$1</div>", $str);
 
  #ausrichtung des Textes
  $str = preg_replace('#\[center\](.*)\[/center\]#isU', "<div align='center'>$1</div>", $str);
  $str = preg_replace('#\[left\](.*)\[/left\]#isU', "<div align='left'>$1</div>", $str);
  $str = preg_replace('#\[right\](.*)\[/right\]#isU', "<div align='right'>$1</div>", $str);
  # Listen
  $str = preg_replace('#\[list\](.*)\[/list\]#isU', "<ul>$1</ul>", $str);
  $str = preg_replace('#\[list=(1|a)\](.*)\[/list\]#isU', "<ol type=\"$1\">$2</ol>", $str);
  $str = preg_replace("#\[*\](.*)\\r\\n#U", "<li>$1</li>", $str);
   
  return $str;
}
}
?>