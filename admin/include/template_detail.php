<?
if($_GET["mode"]!="ajout"&&$_GET['mode']!="send"){
  if($szQuery!=""){
    $resultat= query($szQuery);
    $tbl_result = fetch ($resultat);
  }
}
$TxtSousTitre="TxtSousTitre".$_GET["mode"];
$TxtSousTitre=$$TxtSousTitre;                 
require($_SERVER["DOCUMENT_ROOT"].__racineadmin__."/include/template_haut".$_GET["template"].".php");?>
<script>
function validateForm(obj)
{
//alert(top.editor.length)
for(i=0;i<top.editor.length;i++){
	top.document.getElementById(top.editor[i].InstanceName).value=top.editor[i].getHTML();
}
<?
while (list($key, $val) = each($tabcolonne)) {
  unset($tabelem);
  if(is_array($val)){
    while (list($key, $val2) = each($val)) {
      $tabelem=split("\|",$val2);
      if(count($tabelem)>1){
        $searchstring=split("\(",$tabelem[1]);
        if($searchstring[0]=="listmultipleversemail"||$searchstring[0]=="listfichier"||$searchstring[0]=="listmultiple"||$searchstring[0]=="listmultiple4"||$searchstring[0]=="listmultiple2"||$searchstring[0]=="listmultiple3"||$searchstring[0]=="listmultipleordre"||$searchstring[0]=="popuparbre"){?>
        	selectAll(obj.elements["<?=$tabelem[0]?>"]);
          <?
          if($searchstring[0]=="listmultiple4"||$searchstring[0]=="listmultiple2"||$searchstring[0]=="listfichier"){?>
        	 selectAll(obj.elements["list2<?=$tabelem[0]?>"]);
          <?}
        }
      }
      if(count($tabelem)>2&&$tabelem[2]=="yes"){
      	include $_SERVER['DOCUMENT_ROOT'].__racineadmin__."/element/".$searchstring[0]."/js.php";
      }  
    }
  }else{
    $tabelem=split("\|",$val);
    if(count($tabelem)>1){
      $searchstring=split("\(",$tabelem[1]);
      if($searchstring[0]=="listmultipleversemail"||$searchstring[0]=="listfichier"||$searchstring[0]=="listmultiple"||$searchstring[0]=="listmultiple4"||$searchstring[0]=="listmultiple2"||$searchstring[0]=="listmultiple3"||$searchstring[0]=="listmultipleordre"||$searchstring[0]=="popuparbre"){?>
      	selectAll(obj.elements["<?=$tabelem[0]?>"]);
        <?
        if($searchstring[0]=="listmultiple4"||$searchstring[0]=="listmultiple2"||$searchstring[0]=="listfichier"){?>
      	 selectAll(obj.elements["list2<?=$tabelem[0]?>"]);
        <?}
      }
    }
    if(count($tabelem)>2&&$tabelem[2]=="yes"){
    	include $_SERVER['DOCUMENT_ROOT'].__racineadmin__."/element/".$searchstring[0]."/js.php";
    }
  }
}
?>
	return true;
}
</script>
<div class="container">
<div class="grid-24">
<div class="widget widget-table">
<div class="widget-header">
						<span class="icon-article"></span>
						<h3 class="icon compass"> <? if($TxtTitre!=""){ ?><?=$TxtTitre?> &gt; <?=$TxtSousTitre?><? } else { ?><?=$TxtSousTitre?><? } ?></h3>					
</div>
<div class="widget-content">
<!--  target="framecontent" -->					
<form name="form1" target="framecontent" action="<?=$_SERVER["PHP_SELF"]?>?mode=<?=$_GET["mode"]?>&id=<?=$_GET["id"]?>&pere=<?=$_GET["pere"]?>&template=<?=$_GET["template"]?>&elem=<?=$_GET["elem"]?>&langue_id=<?=$_GET["langue_id"]?>&arbre_id=<?=$_GET["arbre_id"]?>&gabarit_id=<?=$_GET["gabarit_id"]?>" method="post"  ENCTYPE="multipart/form-data" onsubmit="return false;">

<table class="table table-bordered table-striped">
<input type="hidden" name="save" value="yes">
<?
$indice=1;
reset($tabcolonne);
while (list($key, $val) = each($tabcolonne)) {
unset($tabelem);
if(is_array($val)){?>
      <tr>
        <td colspan="2">
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
          	<?
            $nbcol=count($val)*2;
            $percent=100/$nbcol;
            while (list($key, $val2) = each($val)) {
              $tabelem=split("\|",$val2);
              if($_GET["mode"]!="ajout"){
                	$myvalue=$tbl_result[$tabelem[0]];
              }else{
              	$myvalue="";
              }
              $searchstring=split("\(",$tabelem[1]); 
              ?>
              <td class="titre01" width="<?=$percent-10?>%"><?if ($searchstring[0]!="tempo") { ?><?=$key?><? } ?><br /><div class="filet"></div></td>        
            	<td valign="top"  width="<?=$percent+10?>%" style="font-size : 13px; font-family : arial;">
              <? $searchstring=split("\(",$tabelem[1]); require $_SERVER['DOCUMENT_ROOT'].__racineadmin__."/element/".$searchstring[0]."/form.php";?>
            	</td>
            <?}?>
          </tr>
          </table>
        </td>
    </tr>
<?}else{
  $tabelem=split("\|",$val);
  if($_GET["mode"]!="ajout"){
    $myvalue=$tbl_result[$tabelem[0]];
  }else{
  	$myvalue="";
  }
  $searchstring=split("\(",$tabelem[1]); 
  if ($searchstring[0]=="hidden") { 
    require $_SERVER['DOCUMENT_ROOT'].__racineadmin__."/element/".$searchstring[0]."/form.php";
  }else{
    if($tabelem[0]=="delim"){?>
      <tr>
      <td class="valid" colspan="2">
      <hr>
      <!--<?if($notdelete!=true&&$_GET["mode"]!="visu"){?>&nbsp;&nbsp;<input type="button" name="valider" value="<?=$trad["valider"]?>" onclick="<?=($_GET["mode"]!="suppr")?"validateGenForm(this.form)":"this.form.submit()"?>" class="btnform"><?}?><hr>-->
      <?=$key?><hr>
    <?}else{?>
    <tr>
    	<td width="197" class="titre01">
    	<?if ($searchstring[0]!="tempo") { ?><?=$key?> <?if($tabelem[3]==true){?><?=$currentlangue?><?}?><?}?><br /><div class="filet"></div></td>
    	<td valign="top" style="font-size : 13px; font-family : arial;">         
      <? 
      $lastindice=$indice;
      $searchstring=split("\(",$tabelem[1]); require $_SERVER['DOCUMENT_ROOT'].__racineadmin__."/element/".$searchstring[0]."/form.php";
      $lastindice2=$indice;?>
    	</td>
    </tr>
    <?if($tabelem[3]==true){
    //print $sqlrequetelangue;
    //print_r($tbl_list_other_langue);
    
    for($i=0;$i<count($tbl_list_other_langue);$i++){
      if($_GET["mode"]!="ajout"){
        $myvalue=$tbl_list_other_langue[$i][$tabelem[0]];
      }else{
      	$myvalue="";
      }
      $tmptabelem=$tabelem[0];
      $tabelem[0]=$tabelem[0]."___".$tbl_list_other_langue[$i]["shortliblangue"];
    ?>
    <tr>
    	<td width="197" class="titre01">
    	<?if ($searchstring[0]!="tempo") { ?><?=$key?> <?if($tabelem[3]==true){?><?=$tbl_list_other_langue[$i]["libellelangue"]?><?}?><?}?><br /><div class="filet"></div></td>
    	<td valign="top" style="font-size : 13px; font-family : arial;"> 
      <? 
      $indice=$lastindice;
      $tmp_result=$tbl_result;
      $tbl_result=$tbl_list_other_langue[$i];
      $searchstring=split("\(",$tabelem[1]);require $_SERVER['DOCUMENT_ROOT'].__racineadmin__."/element/".$searchstring[0]."/form.php";
      $tbl_result=$tmp_result;
      ?>
    	</td>
    </tr>
    <?
    $tabelem[0]=$tmptabelem;
    }
    $indice=$lastindice2;
    }}?> 
<?}}}?>
<!-- test de suppression -->
<?if($notdelete==true){?>
<tr>
	<td colspan="2" class="texterouge"><?=$txtdelete?></td>
</tr>
<!-- fin de test de suppression -->
<?}?>
<tr>
<td colspan="2">
 <?
		print $input;
		if($_GET["mode"]!="visu"){
			if($notdelete!=true){
		?>
          <input type="button" name="valider" value="<?=$trad["valider"]?>" class="btn btn-success" onclick="<?=($_GET["mode"]!="suppr")?"validateGenForm(document.form1)":"document.form1.submit()"?>"/>
            <!-- <div class="btn_07"><input type="button" name="valider" value="<?=$TxtSousTitre?>" onclick="<?=($_GET["mode"]!="suppr")?"validateGenForm(this.form)":"this.form.submit()"?>"></div> -->
      	<?
        	}
		?>
	  	<?
        	if($notviewsstitre==true){
		?>
            <input type="reset" value="<?=$trad["reset"]?>" class="btn btn-warning">
	  	<?
        	} else {
        	 if($notundo!=true){
		?>
         
            <input type="button" value="<?=$trad["annuler"]?>" class="btn btn-error" onclick="framecontent.location='<?=$_SERVER["PHP_SELF"]?>?mode=list&pere=<?=$_GET["pere"]?>'">
          
       <?}
       		if($_GET["mode"]!="suppr"){
		?>
       	<input type="reset" value="<?=$trad["reset"]?>" class="btn btn-warning">
       <?
       		}
		}
		?>
		<?
        } else {
		?>
        <input type="button" value="<?=$trad["annuler"]?>" class="btnform" onclick="framecontent.location='<?=$_SERVER["PHP_SELF"]?>?mode=list&pere=<?=$_GET["pere"]?>'">
      
		<?
		}
		?> 
</td>
</tr>
</table>  
   	</div>
	</div>
    </form>
    </div>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"].__racineadmin__."/include/template_bas.php");?>