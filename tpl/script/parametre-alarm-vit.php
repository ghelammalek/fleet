<?
$sql="select * from ".__racinebd__."agence_compte where compte_id=".$_SESSION["compte_id"]." and supprimer=0 order by libelle";
$link=query($sql);
while($tbl=fetch($link)){
  $tbl_list_agence[]=$tbl;
}

if($_POST["id"]!=""&&$_POST["mode"]=="modif"){
  $sql="update ".__racinebd__."device set vitessemax='".$_POST["vitessemax"]."' where device_id=".$_POST["id"];
  //print $sql."<br>";
  query($sql);
  $msgsave="Sauvegarde éffectuée";
}
if($_POST["agence"]!=""){
  //listing des véhicules
  $sql = getsqllistvehicule()." and agence_compte_id=".$_POST["agence"];
  $link=query($sql);
  while($tbl=fetch($link)){
    //mettre a jour les km
    $sql="select * from ".__racinebd__."type_compte tc where type_compte_id=".$tbl["type_compte_id"];
    //print $sql;
    $link2=query($sql);
    $tbl_type=fetch($link2);
    $tbl["type"]=$tbl_type;
    
    //recherche catégorie
    $sql="select * from ".__racinebd__."categorie_compte_device ccd
          inner join ".__racinebd__."categorie_compte cc on ccd.categorie_compte_id=cc.categorie_compte_id where device_id=".$tbl["phantom_device_id"];
    //print $sql;
    $link2=query($sql);
    $tbl_list_cat=array();
    while($tbl2=fetch($link2)){
      $tbl_list_cat[]=$tbl2["libelle"];
    } 
    $tbl["listcat"]=implode(", ",$tbl_list_cat);
    $tbl_list_vehicule[]=$tbl;
  }
}

if($_POST["agence"]!=""&&$_POST["id"]!=""&&$_POST["mode"]!="modif"){
  $sql = getsqllistvehicule()." and pd.device_id=".$_POST["id"];
  $link=query($sql);
  $tbl_modif_vitesse=fetch($link);
}

?>