<?
require("../../require/function.php");
require("../../require/back_include.php");
if($_GET["mode"]!=""){
  $sql="select * from ".__racinebd__."devisline where devisline_id='".$_GET["id"]."'";
  $link=query($sql);
  $tbl=fetch($link);
  $devis_id=$tbl["devis_id"]; 
}
if($_GET["mode"]=="moins"){    
	$sql="update ".__racinebd__."devisline set ordre=ordre+1 where devis_id=".$devis_id." and supprimer=0 and devisline_id='".$_GET["id"]."'";
  query($sql);
  $sql="select ordre from ".__racinebd__."devisline where devis_id=".$devis_id." and supprimer=0 and devisline_id='".$_GET["id"]."'";
  $link=query($sql);
  $tbl=fetch($link);
  $sql="update ".__racinebd__."devisline set ordre=ordre-1 where devis_id=".$devis_id." and supprimer=0 and devisline_id!='".$_GET["id"]."' and ordre = ".$tbl["ordre"]."";
  query($sql);
	$_GET["mode"]="list";
}else if($_GET["mode"]=="plus"){
	$sql="update ".__racinebd__."devisline set ordre=ordre-1 where devis_id=".$devis_id." and supprimer=0 and devisline_id='".$_GET["id"]."'";
  //print $sql."<br>";
  query($sql);
  $sql="select ordre from ".__racinebd__."devisline where devis_id=".$devis_id." and supprimer=0 and devisline_id='".$_GET["id"]."'";
  $link=query($sql);
  $tbl=fetch($link);
  $sql="update ".__racinebd__."devisline set ordre=ordre+1 where devis_id=".$devis_id." and supprimer=0 and devisline_id!='".$_GET["id"]."' and ordre = ".$tbl["ordre"]."";
  query($sql);
	$_GET["mode"]="list";
} 
if($_GET["mode"]=="delete"){
  $sql="select ordre from ".__racinebd__."devisline where devis_id=".$devis_id." and supprimer=0 and devisline_id='".$_GET["id"]."'";
  $link=query($sql);
  $tbl=fetch($link);
  $sql="update ".__racinebd__."devisline set ordre=ordre-1 where devis_id=".$devis_id." and supprimer=0 and ordre>(".$tbl["ordre"].")";
  query($sql);
  $sql="update ".__racinebd__."devisline set supprimer=0 where devisline_id=".$_GET["id"];
  query($sql);
}
?>
<html>
<head>
<META http-equiv="Content-Type" Content="text/html; charset=UTF-8">
<style>
th{font-style:arial;font-size:14px;color:black;font-weight:bold;border-right:1px solid black;border-left:1px solid black;padding:5px;height:20px}
td{font-style:arial;font-size:12px;color:black;font-weight:normal;border:1px solid black;padding:5px;height:60px}
</style>
</head>
<body style="margin:0;padding:0;">
<table width="100%" cellpadding=0 cellspacing=0 id="table_montant_<?=$tbl_resultselect["devisline_id"]?>" style="background:#bebebd;border-right:1px solid black;border-top:1px solid black;">
  <tr style="border-bottom:1px solid black"><th>Libellé</th><th>Montant</th><th>&nbsp;</th><th>&nbsp;</th><th>Supprimer</th><th>Modifier</th></tr>
<?
  $i=0;
 	$resultatselect=query($_GET["query"]);
  $nb=num_rows($resultatselect);
  while($tbl_resultselect = fetch ($resultatselect)){
   		//print "Supprimer <input type=\"hidden\" name=\"list2".$tabelem[0]."\" value=\"".$tbl_resultselect[0]."\"><input type=\"checkbox\" name=\"".$tabelem[0]."\" value=\"".$tbl_resultselect[0]."\">".$tbl_resultselect[1]."<br>";
      ?>      
      <tr><td><?=nl2br($tbl_resultselect["libelle"])?></td>
      <td><?=$tbl_resultselect["montant"]?></td>
      <td align="center">
      <?if($i!=0){?>
      <input type="button" name="Up" value="Up" onclick="top.up(<?=$tbl_resultselect["devisline_id"]?>)"/>
      <?}else{?>
      &nbsp;
      <?}?>
      </td>
      <td align="center">
      <?if($i+1!=$nb){?>
      <input type="button" name="Down" value="Down" onclick="top.down(<?=$tbl_resultselect["devisline_id"]?>)"/>
      <?}else{?>
      &nbsp;
      <?}?>
      </td>      
      <td align="center"><input type="button" name="Supprimer" value="Supprimer" onclick="top.deletemontant(<?=$tbl_resultselect["devisline_id"]?>)"/></td>
      <td align="center"><input type="button" name="Modifier" value="Modifier" onclick="top.modifmontant(<?=$tbl_resultselect["devisline_id"]?>)"/></td></tr>
      <?
      $i++;
  }
  ?>
</table>
<script>
if(top.document.getElementById('listidmontantiframelist')){
top.document.getElementById('listidmontantiframelist').height="<?=$i*63+25?>px";
}
top.modifmontant=function(id){
  //alert(top.listidmontantiframe.contentWindow.location)
  top.document.getElementById('listidmontantiframe').contentWindow.location='modiffile.php?id='+id;
}
top.deletemontant=function(id){
  top.document.getElementById('listidmontantiframelist').contentWindow.location='listmontant.php?mode=delete&query=<?=$_GET["query"]?>&id='+id;
}
top.up=function(id){
  top.document.getElementById('listidmontantiframelist').contentWindow.location='listmontant.php?mode=plus&query=<?=$_GET["query"]?>&id='+id;
}
top.down=function(id){
  top.document.getElementById('listidmontantiframelist').contentWindow.location='listmontant.php?mode=moins&query=<?=$_GET["query"]?>&id='+id;
}
</script>
</body>
</html>