<?php

$querystring= split(",",substr($searchstring[1],0,-1));
         if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){
         	print $querystring[$myvalue];
         }else{
         for($I=0;$I<count($querystring);$I++)
	         print $querystring[$I]."&nbsp;<input type=\"radio\" name=\"".$tabelem[0]."\" value=\"".($I+1)."\" ".(((int)$myvalue==($I+1))?"checked":"").">&nbsp;";
         }

?>