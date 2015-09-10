<?	
require("../../require/function.php");  
require("../../require/back_include.php");
if(file_exists($_SERVER["DOCUMENT_ROOT"].__racineadminmenu__."/gabarit/article.php")){
  require($_SERVER["DOCUMENT_ROOT"].__racineadminmenu__."/gabarit/article.php");
  die;
}
if($_GET["arbre_id"]==""&&$_GET["id"]!=""){
  $_GET["arbre_id"]=$_GET["id"];
}
$_GET["langue_id"]=$_GET["langue_id"]==""&&$_GET["lang"]!=""?$_GET["lang"]:$_GET["langue_id"];
//$tmpvar=new class_rules(-1,$tbl_result["login"]);
if($_GET["pere"]==""||$_GET["pere"]=="0"){
  testGenRulesDie("RULR");
}
if($_GET["mode"]=="ajout"){
  testdroitarbredie($_GET["pere"],"ADD");
}
if($_GET["mode"]=="modif"){
  testdroitarbredie($_GET["arbre_id"],"UPD");
}
if($_GET["mode"]=="suppr"){
  testdroitarbredie($_GET["arbre_id"],"DEL");
}

$detailsave="no";
$nbelemparpage=50;

$typeElem="Article";
$TxtTitre="Article";
$Ajouttxt="Ajouter un Article";
$Updatetxt="Text";

if($_GET["arbre_id"]!=""){
  $sql="select libelle from ".__racinebd__."gabarit g inner join ".__racinebd__."arbre a on a.gabarit_id=g.gabarit_id where arbre_id=".$_GET["arbre_id"];
  //print "<script>alert('".$sql."')</script>";
  $link=query($sql);
  $tbl_result=fetch($link);
  $elem=$tbl_result["libelle"];
  //print "<script>alert('".$elem."')</script>";
}else if($_GET["gabarit_id"]!=""){
  $sql="select libelle from ".__racinebd__."gabarit where gabarit_id=".$_GET["gabarit_id"];
  $link=query($sql);
  $tbl_result=fetch($link);
  $elem=$tbl_result["libelle"];
}

$_GET["version_id"]=(($_GET["version_id"]!="")?$_GET["version_id"]:(($_POST["version_id"]!="")?$_POST["version_id"]:2));
$sql="select * from ".__racinebd__."version where version_id=".$_GET["version_id"];
//print $sql;
$link=query($sql);
$tbl_result=fetch($link);
$libversion=$tbl_result["libelle"];
/*
$sql="select * from ".__racinebd__."langue where langue_id=".(($_GET["langue_id"]!="")?$_GET["langue_id"]:1);
$link2=query($sql);
$tbl_result2=fetch($link2);
*/

//$elem.=" (".$tbl_result2["libelle"]." | ".$tbl_result["libelle"].")";
$elem.=" (".$tbl_result["libelle"].")";


$TxtSousTitreajout="Ajouter un ".$elem;
$TxtSousTitremodif="Modifier un ".$elem;
$TxtSousTitrevisu="&Eacute;diter un ".$elem;


$TxtSousTitrelist="Liste des articles : ".chemin($_GET["arbre_id"],$_GET["langue_id"])." ".$elem;

$TxtSousTitreSuppr="Supprimer un ".$elem;

//on recherche l'ID de la table content
//$_GET["version_id"]=($_GET["version_id"]=="")?2:$_GET["version_id"];
//si le version_id est vide on regarde si il existe une version brouillon

$table=__racinebd__."content";
//$textehelp="<li>S&eacute;lectionnez \" Texte \" pour administrer les textes de chaque sc&egrave;ne.</li>";
$tablekey="content_id";
//$txtretour=false;

//print "ici";

if($_GET["mode"]!=""){
    if($_GET["mode"]=="undo"){
        //on deverouille
				$sql="update ".__racinebd__."arbre set users_id_verrou=null where arbre_id='".$_GET["arbre_id"]."'";
        query($sql);
        require("../../include/template_haut.php");
        ?>
        <div class="clear"></div>
        <center>Dévérouillage</center>
        <div class="clear"></div>
        <script>
        //top.refreshA(<?=($_GET["pere"]==0)?"null":$_GET["pere"]?>);
        /*
        $("#arbre_new").dynatree("getTree").
        node.parent.reloadChildren(function(node, isOk){});
        var branch = top.tree.getBranchById('<?=($_GET["pere"]==0)?"root1":$_GET["pere"]?>');
        branch.refreshChildren();
        */
        window.location='../../home/index.php'
        </script>
        <?
        require("../../include/template_bas.php");
        die;
    }else if($_GET["mode"]=="list"){
		
      $tablekey="arbre_id";
      $szQuery = "select distinct a.arbre_id,nom,libelle,secure,etat_id from 
      ".__racinebd__."contenu c  
      inner join ".__racinebd__."arbre a on c.arbre_id=a.arbre_id and langue_id=".$_GET["langue_id"]." 
      inner join ".__racinebd__."gabarit g on g.gabarit_id=a.gabarit_id where a.supprimer=0 and pere = ".$_GET["arbre_id"]." and arbre_id_alias is null";
			$ImgAjout=false;
			$tabcolonne=array("Nom d'url"=> "nom","Type d'élément"=>"libelle");
			$update=true;
			$delete=false;
			$search=false;
			$notview=true;
			
						
			$couleur = "etat_id";
			$valcouleur1=1;
			$txtcouleur[0] = "Publié";
			$txtcouleur[1] = "Non publié";
			
			$_GET["pere"]=$_GET["arbre_id"];
			$_GET["lang"]=$_GET["langue_id"];
			$filtre="listversion.php";
			require("../../include/template_list.php");
    }else if($_POST["save"]=="yes"){
    	$_POST["abstractseo"]=($_POST["abstractseo"]=="")?cutword(strip_tags($_POST["abstract"]),125):cutword($_POST["abstractseo"],125);
      $_POST["titleseo"]=($_POST["titleseo"]=="")?strip_tags($_POST["titre1"]):$_POST["titleseo"];
    	
      switch($_GET["mode"]){
        case "suppr" :
          //marche pas
          $txtmsg="L'élément a &eacute;t&eacute; supprim&eacute;";
          $szQuery="update ".__racinebd__."arbre set supprimer=1 where arbre_id='".$_GET["arbre_id"]."'";
          //modification de l'ordre
          $sql="select pere,ordre from ".__racinebd__."arbre where arbre_id=".$_GET["arbre_id"];
          $link=query($sql);
					$tbl_result=fetch($link);
          $sql="update ".__racinebd__."arbre set ordre=ordre-1 where supprimer=0 and pere=".(($_GET["pere"]==""||$_GET["pere"]=="0")?"null":$_GET["pere"])." and ordre>".$tbl_result["ordre"];
          query($sql);
          log_phantom($arbre_id,"suppression du noeud");
          //rafraichissement de l'arbre
        break;
        case "ajout" :
          
					if($_FILES["ext"]["tmp_name"]!=""){
	          $myext="'".getext($_FILES["ext"]["name"])."'";  
					}else{
  			    if($_POST["ext"]!=""){
              $myext="'".$_POST["ext"]."'";
  					}else{
              $myext="null";
            }
          }
          if($_FILES["ext2"]["tmp_name"]!=""){
	          $myext2="'".getext($_FILES["ext2"]["name"])."'";
					}else{
  			    if($_POST["ext2"]!=""){
              $myext2="'".$_POST["ext2"]."'";
  					}else{
              $myext2="null";
            }
          }
          if($_FILES["ext3"]["tmp_name"]!=""){
	          $myext3="'".getext($_FILES["ext3"]["name"])."'";
					}else{
  			    if($_POST["ext3"]!=""){
              $myext3="'".$_POST["ext3"]."'";
  					}else{
              $myext3="null";
            }
          }
          if($_FILES["ext4"]["tmp_name"]!=""){
	          $myext4="'".getext($_FILES["ext4"]["name"])."'";
					}else{
  			    if($_POST["ext4"]!=""){
              $myext4="'".$_POST["ext4"]."'";
  					}else{
              $myext4="null";
            }
          }
          if($_FILES["ext5"]["tmp_name"]!=""){
	          $myext5="'".getext($_FILES["ext5"]["name"])."'";
					}else{
  			    if($_POST["ext5"]!=""){
              $myext5="'".$_POST["ext5"]."'";
  					}else{
              $myext5="null";
            }
          }
          $txtmsg="L'élément a &eacute;t&eacute; ajout&eacute;";
          
					//recherche du nouvel ordre
					$sql="select max(ordre) as maxordre from ".__racinebd__."arbre where supprimer=0 and pere ".(($_GET["pere"]==""||$_GET["pere"]=="0")?"is null":"=".$_GET["pere"]);
					$link=query($sql);
					$tbl_result=fetch($link);
					$maxordre=$tbl_result["maxordre"]+1;
					//enregistrement dans la table arbre
					$sql="insert into ".__racinebd__."arbre (gabarit_id,pere,users_id_crea,ordre,secure,etat_id,root) values (".$_GET["gabarit_id"].",".(($_GET["pere"]==""||$_GET["pere"]=="0")?"null":$_GET["pere"]).",".$_SESSION["users_id"].",$maxordre,'".$_POST["secure"]."',2,".getroot($_GET["pere"]).")";
					query($sql);
					$arbre_id=insert_id();
					//affectation des droits identique a ceux du pere
					$sql="select * from ".__racinebd__."groupe_arbre where arbre_id='".$_GET["pere"]."'";
					$link=query($sql);
					if(num_rows($link)>0){
  					while($tbl_result=fetch($link)){
              $sql="insert into ".__racinebd__."groupe_arbre (arbre_id,droits_id,groupe_id) values (".$arbre_id.",".$tbl_result["droits_id"].",".$tbl_result["groupe_id"].")";
              query($sql);
  					}
					}else{
            //si le pere ne possede aucun droit on lui met tout les droits
            /*
            $sql="select * from groupe";
            $link=query($sql);
            while($tbl_result=fetch($link)){
              $sql="select * from droits where droitarbre=1";
              $link_droits=query($sql);
              while($tbl_result_droits=fetch($link_droits)){
                $sql="insert into groupe_arbre (arbre_id,droits_id,groupe_id) values (".$arbre_id.",".$tbl_result_droits["droits_id"].",".$tbl_result["groupe_id"].")";
                query($sql);
              }
            } 
            */          
          }
					
					$sql="select * from ".__racinebd__."langue where active=1";
					$link=query($sql);
					while($tbl_result=fetch($link)){
           $name=($_GET["pere"]==""||$_GET["pere"]=="0")?$_POST["titre1"]:makename($_POST["titre1"]);
					 if($tbl_result["langue_id"]==$_GET["langue_id"]){
              $sql="insert into ".__racinebd__."contenu (arbre_id,langue_id,nom,translate) values (".$arbre_id.",".$tbl_result["langue_id"].",'".$name."',1)";
              query($sql);
              $contenu_id=insert_id();
					  }else{
              $sql="insert into ".__racinebd__."contenu (arbre_id,langue_id,nom,translate) values (".$arbre_id.",".$tbl_result["langue_id"].",'".$name."',0)";
              query($sql);
              
            }				  
					}
					
					$szQuery="insert into $table (titre1,titre2,titre3,titre4,titre5,abstract,contenu,date_actu,date_fin,ext,version_id,contenu_id,ext2,note,abstract2,abstract3,abstract4,abstract5,ext3,ext4,twitter,tva_id,fournisseur_id,note1,note2,note3,note4,archive,envoye,titleseo,abstractseo,robotseo,ext5)
          values ('".addquote($_POST["titre1"])."','".addquote($_POST["titre2"])."','".addquote($_POST["titre3"])."','".addquote($_POST["titre4"])."','".addquote($_POST["titre5"])."','".addquote($_POST["abstract"])."',
          '".addquote($_POST["contenu"])."','".datetimebdd($_POST["date_actu"])."','".datetimebdd($_POST["date_fin"])."',$myext,".$_POST["version_id"].",".$contenu_id.",$myext2,'".$_POST["note"]."','".addquote($_POST["abstract2"])."','".addquote($_POST["abstract3"])."',
          '".addquote($_POST["abstract4"])."','".addquote($_POST["abstract5"])."',$myext3,$myext4,'".addquote($_POST["twitter"])."','".addquote($_POST["tva_id"])."','".addquote($_POST["fournisseur_id"])."','".addquote($_POST["note1"])."',
          '".addquote($_POST["note2"])."','".addquote($_POST["note3"])."','".addquote($_POST["note4"])."','".addquote($_POST["archive"])."','".addquote($_POST["envoye"])."','".addquote($_POST["titleseo"])."','".addquote($_POST["abstractseo"])."','".addquote($_POST["robotseo"])."',$myext5)";
          $link=query($szQuery);
					$id=insert_id();
          
          //copy du master content dans les autres langues
          
					createdefault("ext",$table,$id);
					createdefault("ext2",$table."2_",$id);
					createdefault("ext3",$table."3_",$id);
					createdefault("ext4",$table."4_",$id);
          createdefault("ext5",$table."5_",$id);
          if($_FILES["ext5"]["tmp_name"]!=""){
	            savefile("ext5",$table."5_",$id);    
					}
					if($_FILES["ext4"]["tmp_name"]!=""){
	            savefile("ext4",$table."4_",$id);    
					}
					if($_FILES["ext3"]["tmp_name"]!=""){
	            savefile("ext3",$table."3_",$id);    
					}
					if($_FILES["ext2"]["tmp_name"]!=""){
	            savefile("ext2",$table."2_",$id);    
					}
					if($_FILES["ext"]["tmp_name"]!=""){
	            savefile("ext",$table,$id);    
					}
					//sauvegarde des tags 1
          for($i=0;$i<count($_POST["tag_id"]);$i++){
            $sql="insert into ".__racinebd__."tag_content (tag_id,content_id) values (".$_POST["tag_id"][$i].",".$id.")";
            query($sql);
          }
          //sauvegarde des tags 2
          for($i=0;$i<count($_POST["tag_search_id"]);$i++){
            $sql="insert into ".__racinebd__."tag_search_content (tag_search_id,content_id) values (".$_POST["tag_search_id"][$i].",".$id.")";
            query($sql);
          }
          majfichier($id);
          majval($id);
					copyContent($id,$arbre_id,$_GET["langue_id"]);
          log_phantom($arbre_id,"Création du noeud");
					//log_phantom($arbre_id,"Modification du noeud (".$currentlangue." | ".$libversion.")");
          log_phantom($arbre_id,"Modification du noeud (".$libversion.")");
					//on deverouille
					$sql="update ".__racinebd__."arbre set users_id_verrou=null,secure='".$_POST["secure"]."' where arbre_id=".$arbre_id;
          query($sql);
					$szQuery="";
          
          
					//rafraichissement de l'arbre
          @require($_SERVER["DOCUMENT_ROOT"].__racineadminmenu__."/gabarit/hook_insert.php");
        break;
      	case "modif" :
      	    
  					$txtmsg=$trad["L'élément a &eacute;t&eacute; modifi&eacute;"];
            //on recherche le content_id a modifié
            //recherche du contenu_id correspondant
            $sql="select contenu_id from ".__racinebd__."contenu where arbre_id=".$_GET["arbre_id"]." and langue_id=".$_GET["langue_id"];
            $link=query($sql);
            $tbl_result=fetch($link);
            $contenu_id=$tbl_result["contenu_id"];
            
            //on verifie si il existe deja un enregistrement
            //on recherche le content_id correspondant a la modification
            $sql="select content_id from ".__racinebd__."contenu c1 inner join ".__racinebd__."content c2 on c1.contenu_id=c2.contenu_id where arbre_id=".$_GET["arbre_id"]." and langue_id=".$_GET["langue_id"]." and version_id='".$_POST["version_id"]."'";
            $link=query($sql);
            $tbl_result=fetch($link);
            $content_id=$tbl_result["content_id"];
            
            if($content_id==""){
            
    					if($_FILES["ext"]["tmp_name"]!=""){
    	          $myext="'".getext($_FILES["ext"]["name"])."'";
    					}else{
    						if($_POST["ext"]!=""){
                  $myext="'".$_POST["ext"]."'";
      					}else{
                  $myext="null";
                }
              }
              if($_FILES["ext2"]["tmp_name"]!=""){
    	          $myext2="'".getext($_FILES["ext2"]["name"])."'";
    					}else{
    						if($_POST["ext2"]!=""){
                  $myext2="'".$_POST["ext2"]."'";
      					}else{
                  $myext2="null";
                }
              }
              if($_FILES["ext3"]["tmp_name"]!=""){
    	          $myext3="'".getext($_FILES["ext3"]["name"])."'";
    					}else{
    						if($_POST["ext3"]!=""){
                  $myext3="'".$_POST["ext3"]."'";
      					}else{
                  $myext3="null";
                }
              }
              if($_FILES["ext4"]["tmp_name"]!=""){
    	          $myext4="'".getext($_FILES["ext4"]["name"])."'";
    					}else{
    						if($_POST["ext4"]!=""){
                  $myext4="'".$_POST["ext4"]."'";
      					}else{
                  $myext4="null";
                }
              }
              if($_FILES["ext5"]["tmp_name"]!=""){
    	          $myext5="'".getext($_FILES["ext5"]["name"])."'";
    					}else{
    						if($_POST["ext5"]!=""){
                  $myext5="'".$_POST["ext5"]."'";
      					}else{
                  $myext5="null";
                }
              }
              
              $szQuery="insert into $table (titre1,titre2,titre3,titre4,titre5,abstract,contenu,date_actu,date_fin,ext,version_id,contenu_id,ext2,note,abstratc2,abstract3,abstract4,abstract5,ext3,ext4,twitter,tva_id,fournisseur_id,note1,note2,note3,note4,archive,envoye,titleseo,abstractseo,robotseo,ext5)
              values ('".addquote($_POST["titre1"])."','".addquote($_POST["titre2"])."','".addquote($_POST["titre3"])."','".addquote($_POST["titre4"])."','".addquote($_POST["titre5"])."',
              '".addquote($_POST["abstract"])."','".addquote($_POST["contenu"])."','".datetimebdd($_POST["date_actu"])."','".datetimebdd($_POST["date_fin"])."',$myext,".$_POST["version_id"].",
              ".$contenu_id.",$myext2,'".$_POST["note"]."','".addquote($_POST["abstract2"])."','".addquote($_POST["abstract3"])."','".addquote($_POST["abstract4"])."','".addquote($_POST["abstract5"])."',$myext3,$myext4,
              '".addquote($_POST["twitter"])."','".addquote($_POST["tva_id"])."','".addquote($_POST["fournisseur_id"])."','".addquote($_POST["note1"])."','".addquote($_POST["note2"])."',
              '".addquote($_POST["note3"])."','".addquote($_POST["note4"])."','".addquote($_POST["archive"])."','".addquote($_POST["envoye"])."','".addquote($_POST["titleseo"])."','".addquote($_POST["abstractseo"])."','".addquote($_POST["robotseo"])."',$myext5)";
              $link=query($szQuery);
    					$id=insert_id();
    					$content_id=$id;
              $_GET['id']=$id;
              
    					createdefault("ext",$table,$id);
    					createdefault("ext2",$table."2_",$id);
    					createdefault("ext3",$table."3_",$id);
    					createdefault("ext4",$table."4_",$id);
              createdefault("ext5",$table."5_",$id);
    					
    					if($_FILES["ext2"]["tmp_name"]!=""){
    	            $myext2=savefile("ext2",$table."2_",$content_id);
    					}
    					if($_FILES["ext"]["tmp_name"]!=""){
    	            $myext=savefile("ext",$table,$content_id);
    					}
    					if($_FILES["ext3"]["tmp_name"]!=""){
    	            $myext3=savefile("ext3",$table."3_",$content_id);
    					}
    					if($_FILES["ext4"]["tmp_name"]!=""){
    	            $myext4=savefile("ext4",$table."4_",$content_id);
    					}
              if($_FILES["ext5"]["tmp_name"]!=""){
    	            $myext5=savefile("ext5",$table."5_",$content_id);
    					}
    					majfichier($id);
              majval($id);
              copyContent($id,$_GET["arbre_id"],$_GET["langue_id"]);
    					$szQuery="";
              }else{
              $_GET["id"]=$content_id;
              
              if($_FILES["ext"]["tmp_name"]!=""&&$_POST["ext_chk"]!=1){
                $myext=savefile("ext",$table);
    					}else{
      					if($_POST["ext"]!=""&&$_POST["ext_chk"]!=1){
                  $myext=",ext='".$_POST["ext"]."'";
      					}else if($_POST["ext_chk"]==1){
                  $myext=",ext=null";
                }
              }
              if($_FILES["ext2"]["tmp_name"]!=""&&$_POST["ext2_chk"]!=1){
                $myext2=savefile("ext2",$table."2_");
    					}else{
      					if($_POST["ext2"]!=""&&$_POST["ext2_chk"]!=1){
                  $myext2=",ext2='".$_POST["ext2"]."'";
      					}else if($_POST["ext2_chk"]==1){
                  $myext2=",ext2=null";
                }
              }
              if($_FILES["ext3"]["tmp_name"]!=""&&$_POST["ext3_chk"]!=1){
                $myext3=savefile("ext3",$table."3_");
    					}else{
      					if($_POST["ext3"]!=""&&$_POST["ext3_chk"]!=1){
                  $myext3=",ext3='".$_POST["ext3"]."'";
      					}else if($_POST["ext3_chk"]==1){
                  $myext3=",ext3=null";
                }
              }
              if($_FILES["ext4"]["tmp_name"]!=""&&$_POST["ext4_chk"]!=1){
                $myext4=savefile("ext4",$table."4_");
    					}else{
      					if($_POST["ext4"]!=""&&$_POST["ext4_chk"]!=1){
                  $myext4=",ext4='".$_POST["ext4"]."'";
      					}else if($_POST["ext4_chk"]==1){
                  $myext4=",ext4=null";
                }
              }
              if($_FILES["ext5"]["tmp_name"]!=""&&$_POST["ext5_chk"]!=1){
                $myext5=savefile("ext5",$table."5_");
    					}else{
      					if($_POST["ext5"]!=""&&$_POST["ext5_chk"]!=1){
                  $myext5=",ext5='".$_POST["ext5"]."'";
      					}else if($_POST["ext5_chk"]==1){
                  $myext5=",ext5=null";
                }
              }
              
              //si pas de changement d'etat
              $szQuery="update $table set 
    					titre1='".addquote($_POST["titre1"])."',
    					titre2='".addquote($_POST["titre2"])."',
    					titre3='".addquote($_POST["titre3"])."',
    					titre4='".addquote($_POST["titre4"])."',
    					titre5='".addquote($_POST["titre5"])."',
    					abstract='".addquote($_POST["abstract"])."',
              abstract2='".addquote($_POST["abstract2"])."',
    					abstract3='".addquote($_POST["abstract3"])."',
    					abstract4='".addquote($_POST["abstract4"])."',
    					abstract5='".addquote($_POST["abstract5"])."',
    					contenu='".addquote($_POST["contenu"])."',
    					date_actu='".datetimebdd($_POST["date_actu"])."',
    					date_fin='".datetimebdd($_POST["date_fin"])."',
    					note='".$_POST["note"]."',
    					version_id='".$_POST["version_id"]."',
    					twitter='".$_POST["twitter"]."',
    					tva_id='".$_POST["tva_id"]."',
    					fournisseur_id='".$_POST["fournisseur_id"]."',
              note1='".$_POST["note1"]."',
              note2='".$_POST["note2"]."',
              note3='".$_POST["note3"]."',
              note4='".$_POST["note4"]."',
              archive='".$_POST["archive"]."',
              envoye='".$_POST["envoye"]."',
              titleseo='".addquote($_POST["titleseo"])."',
              abstractseo='".addquote($_POST["abstractseo"])."',
              robotseo='".addquote($_POST["robotseo"])."'
    					$myext
    					$myext2
    					$myext3
    					$myext4
              $myext5
              where content_id=".$content_id;
              majfichier($content_id);
              majval($content_id);
              
              updateContent($content_id,$_GET["arbre_id"],$_GET["langue_id"]);
              
              createdefault("ext",$table,$content_id);
              createdefault("ext2",$table."2_",$content_id);
              createdefault("ext3",$table."3_",$content_id);
              createdefault("ext4",$table."4_",$content_id);
              createdefault("ext5",$table."5_",$content_id);
            }
            if($_POST["version_id"]==1){
              $sql="update ".__racinebd__."contenu set translate=1 where contenu_id=".$contenu_id;
              query($sql);
            }

          $sql="delete from ".__racinebd__."tag_content where content_id=".$content_id;
          query($sql);
					//sauvegarde des tags 1
          for($i=0;$i<count($_POST["tag_id"]);$i++){
            $sql="insert into ".__racinebd__."tag_content (tag_id,content_id) values (".$_POST["tag_id"][$i].",".$_GET["id"].")";
            query($sql);
          }
          $sql="delete from ".__racinebd__."tag_search_content where content_id=".$content_id;
          query($sql);
					//sauvegarde des tags 2
          for($i=0;$i<count($_POST["tag_search_id"]);$i++){
            $sql="insert into ".__racinebd__."tag_search_content (tag_search_id,content_id) values (".$_POST["tag_search_id"][$i].",".$_GET["id"].")";
            query($sql);
          }
          
          
          //verification si il sagit d'une sauvegarde avec un changement de version (sauver en brouillon un en ligne ou vice et versa)
          if($_GET["version_id"]!=$_POST["lastversion_id"]&&$_POST["lastversion_id"]!=""){
              $myext=""; 
              $myext2="";
              $myext3="";
              $myext4="";
              $myext5="";
              if($_FILES["ext"]["tmp_name"]==""&&$_POST["ext_chk"]!=1){
    						  //copy du fichier
    						  $sql="select content_id,ext from ".__racinebd__."contenu c1 inner join ".__racinebd__."content c2 on c1.contenu_id=c2.contenu_id where arbre_id=".$_GET["arbre_id"]." and langue_id=".$_GET["langue_id"]." and version_id=".(($_POST["lastversion_id"]=="")?$_GET["version_id"]:$_POST["lastversion_id"]);
    						  $link=query($sql);
    						  $ligne_select_content=fetch($link);
    						  if($ligne_select_content['ext']!=""){
      						  @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content'.$ligne_select_content['content_id'].'.'.$ligne_select_content['ext'],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content'.$content_id.'.'.$ligne_select_content['ext']);
                    @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl_content'.$ligne_select_content['content_id'].'.'.$ligne_select_content['ext'],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl_content'.$content_id.'.'.$ligne_select_content['ext']);
                    for($i=0;$i<5;$i++){
                      @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl'.$i.'_content'.$ligne_select_content['content_id'].'.'.$ligne_select_content['ext'],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl_'.$i.'content'.$content_id.'.'.$ligne_select_content['ext']);
                    }
                    $myext=",ext='".$ligne_select_content['ext']."' ";    
                  }
    					}
    					if($_FILES["ext2"]["tmp_name"]==""&&$_POST["ext2_chk"]!=1){
    						  
    						  //copy du fichier
    						  $sql="select content_id,ext2 from ".__racinebd__."contenu c1 inner join ".__racinebd__."content c2 on c1.contenu_id=c2.contenu_id where arbre_id=".$_GET["arbre_id"]." and langue_id=".$_GET["langue_id"]." and version_id=".$_POST["lastversion_id"];
    						  $link=query($sql);
    						  $ligne_select_content=fetch($link);
    						  if($ligne_select_content['ext2']!=""){
      						  @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content2_'.$ligne_select_content['content_id'].'.'.$ligne_select_content['ext2'],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content2_'.$content_id.'.'.$ligne_select_content['ext2']);
                    @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl_content2_'.$ligne_select_content['content_id'].'.'.$ligne_select_content['ext2'],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl_content2_'.$content_id.'.'.$ligne_select_content['ext2']);
                    for($i=0;$i<5;$i++){
                      @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl'.$i.'_content2_'.$ligne_select_content['content_id'].'.'.$ligne_select_content['ext2'],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl_'.$i.'content2_'.$content_id.'.'.$ligne_select_content['ext2']);
                    }
                    $myext2=",ext2='".$ligne_select_content['ext2']."' ";    
                  }
    					}
    					if($_FILES["ext3"]["tmp_name"]==""&&$_POST["ext3_chk"]!=1){
    						  //copy du fichier
    						  $sql="select content_id,ext3 from ".__racinebd__."contenu c1 inner join ".__racinebd__."content c2 on c1.contenu_id=c2.contenu_id where arbre_id=".$_GET["arbre_id"]." and langue_id=".$_GET["langue_id"]." and version_id=".$_POST["lastversion_id"];
    						  $link=query($sql);
    						  $ligne_select_content=fetch($link);
    						  if($ligne_select_content['ext3']!=""){
      						  @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content3_'.$ligne_select_content['content_id'].'.'.$ligne_select_content['ext3'],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content3_'.$content_id.'.'.$ligne_select_content['ext3']);
                    @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl_content3_'.$ligne_select_content['content_id'].'.'.$ligne_select_content['ext3'],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl_content3_'.$content_id.'.'.$ligne_select_content['ext3']);
                    for($i=0;$i<5;$i++){
                      @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl'.$i.'_content3_'.$ligne_select_content['content_id'].'.'.$ligne_select_content['ext3'],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl_'.$i.'content3_'.$content_id.'.'.$ligne_select_content['ext3']);
                    }
                    $myext3=",ext3='".$ligne_select_content['ext3']."' ";    
                  }
    					}
    					if($_FILES["ext4"]["tmp_name"]==""&&$_POST["ext4_chk"]!=1){
    						  //copy du fichier
    						  $sql="select content_id,ext4 from ".__racinebd__."contenu c1 inner join ".__racinebd__."content c2 on c1.contenu_id=c2.contenu_id where arbre_id=".$_GET["arbre_id"]." and langue_id=".$_GET["langue_id"]." and version_id=".$_POST["lastversion_id"];
    						  $link=query($sql);
    						  $ligne_select_content=fetch($link);
    						  if($ligne_select_content['ext4']!=""){
      						  @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content4_'.$ligne_select_content['content_id'].'.'.$ligne_select_content['ext4'],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content4_'.$content_id.'.'.$ligne_select_content['ext4']);
                    @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl_content4_'.$ligne_select_content['content_id'].'.'.$ligne_select_content['ext4'],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl_content4_'.$content_id.'.'.$ligne_select_content['ext4']);
                    for($i=0;$i<5;$i++){
                      @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl'.$i.'_content4_'.$ligne_select_content['content_id'].'.'.$ligne_select_content['ext4'],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl_'.$i.'content4_'.$content_id.'.'.$ligne_select_content['ext4']);
                    }
                    $myext4=",ext4='".$ligne_select_content['ext4']."' ";    
                  }
    					}
              if($_FILES["ext5"]["tmp_name"]==""&&$_POST["ext5_chk"]!=1){
    						  //copy du fichier
    						  $sql="select content_id,ext5 from ".__racinebd__."contenu c1 inner join ".__racinebd__."content c2 on c1.contenu_id=c2.contenu_id where arbre_id=".$_GET["arbre_id"]." and langue_id=".$_GET["langue_id"]." and version_id=".$_POST["lastversion_id"];
    						  $link=query($sql);
    						  $ligne_select_content=fetch($link);
    						  if($ligne_select_content['ext5']!=""){
      						  @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content5_'.$ligne_select_content['content_id'].'.'.$ligne_select_content['ext5'],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content5_'.$content_id.'.'.$ligne_select_content['ext5']);
                    @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl_content5_'.$ligne_select_content['content_id'].'.'.$ligne_select_content['ext5'],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl_content5_'.$content_id.'.'.$ligne_select_content['ext5']);
                    for($i=0;$i<5;$i++){
                      @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl'.$i.'_content5_'.$ligne_select_content['content_id'].'.'.$ligne_select_content['ext5'],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'tbl_'.$i.'content5_'.$content_id.'.'.$ligne_select_content['ext5']);
                    }
                    $myext5=",ext5='".$ligne_select_content['ext5']."' ";    
                  }
    					}
    					if($myext!=""||$myext2!=""||$myext3!=""||$myext4!=""||$myext5!=""){
    					 $sql="update ".__racinebd__."content set content_id=content_id $myext $myext2 $myext3 $myext4 $myext5 where content_id=".$content_id;
    					 query($sql);
    					}
          }
          
          //print $szQuery;
          $sql="select libelle from ".__racinebd__."version where version_id=".$_POST["version_id"];
          $link=query($sql);
          $tbl_result=fetch($link);
					log_phantom($_GET["arbre_id"],"Modification du noeud (".$libversion.")");
					//on deverouille
					$sql="update ".__racinebd__."arbre set users_id_verrou=null,secure='".$_POST["secure"]."' where arbre_id=".$_GET["arbre_id"];
          query($sql);
          //on regenere le fichiers de referencement
          genereFileReferencement();
          @require($_SERVER["DOCUMENT_ROOT"].__racineadminmenu__."/gabarit/hook_update.php");
          break;
        }   
      if($_POST["stay"]==1){
        /*
        query($szQuery);
        if($_GET["mode"]=="ajout"){
          $_GET["id"]=insert_id();
        } */
        $_GET["arbre_id"]=($_GET["arbre_id"]=="")?$arbre_id:$_GET["arbre_id"];
        $version_id=(($_GET["version_id"]!="")?$_GET["version_id"]:(($_POST["version_id"]!="")?$_POST["version_id"]:2));
        //header("Location: article.php?pere=".$_GET["pere"]."&arbre_id=".$_GET["arbre_id"]."&langue_id=".$_GET["langue_id"]."&mode=modif&version_id=".$version_id);
        ?>
        <script>
        window.location='<?="article.php?pere=".$_GET["pere"]."&arbre_id=".$_GET["arbre_id"]."&langue_id=".$_GET["langue_id"]."&mode=modif&version_id=".$version_id?>';
        top.adchildinfo('<?=($_GET["pere"]==0)?"_1":$_GET["pere"]?>');
        </script>
        <?
        //header("Location: article.php?mode=modif&id=".$_GET["id"]."&pere=&lang=&version_id=");
        die;
      }
    	require("../../include/template_save.php");
      if($_GET["mode"]=="ajout"){?>
    	<script>
      /*
      var branch = top.tree.getBranchById('<?=($_GET["pere"]==0)?"root1":$_GET["pere"]?>');
			branch.refreshChildren();
      */
      
      top.adchildinfo('<?=($_GET["pere"]==0)?"_1":$_GET["pere"]?>');
      </script>
    	<?}
    }else{
    if($_GET["mode"]!="ajout"){
      if($_GET["id"]!=""){
        $_GET["content_id"]=$_GET["id"];
        $version_id=1;
      }else{
        $version_id=(($_GET["version_id"]!="")?$_GET["version_id"]:(($_POST["version_id"]!="")?$_POST["version_id"]:2));
        $sql="select content_id from ".__racinebd__."contenu c1 inner join ".__racinebd__."content c2 on c1.contenu_id=c2.contenu_id where arbre_id=".$_GET["arbre_id"]." and langue_id=".$_GET["langue_id"]." and version_id=".$version_id;
        $link=query($sql);
        $tbl_result=fetch($link);
        $_GET["content_id"]=(int)$tbl_result["content_id"];
      }
    }
    $szQuery = "select *,version_id as lastversion_id from ".__racinebd__."arbre a inner join ".__racinebd__."gabarit g on g.gabarit_id=a.gabarit_id inner join ".__racinebd__."contenu c on c.arbre_id=a.arbre_id left join ".__racinebd__."content c2 on c2.contenu_id=c.contenu_id  where a.supprimer=0 and a.arbre_id=".$_GET["arbre_id"]." and c.langue_id=".$_GET["langue_id"]." and version_id=".$_GET["version_id"];
    
    //print "<script>alert(\"".$szQuery."\")</script>";
    //libelle=>nom du champ|type|obligatoire|taille (facultatif)
    //les type sont les suivant
    // txt area html media date file email list(nom var requete) listmutiple(nom var requete)
    //recherche du gabarit
    if($_GET["mode"]=="ajout"||$_GET["mode"]=="modif"){
      $notdelete=true;
      $notundo=true;
      /*
      $input="<div class=\"btn_07\"><a href=\"javascript:void(0)\" onclick=\"".(($_GET["mode"]!="suppr")?"document.form1.version_id.value=1;validateGenForm(document.form1)":"document.form1.submit()")."\"><img src=\"".__racineadmin__."/images/new/bt_valider.gif\" name=\"valider\" border=\"0\"></a></div>";
      $input.="<div class=\"btn_07\"><a href=\"javascript:void(0)\" onclick=\"document.form1.version_id.value=2;validateGenForm(document.form1)\"><img src=\"".__racineadmin__."/images/new/save_as_brouillon.gif\" border=\"0\"/></a></div>";
      $input.="<div class=\"btn_08\"><a href=\"".$_SERVER["PHP_SELF"]."?mode=undo&arbre_id=".$_GET["arbre_id"]."&langue_id=".$_GET["langue_id"]."\" target=\"framecontent\"><img src=\"".__racineadmin__."/images/new/bt_annuler.gif\" border=\"0\"/></a></div>";
      */
      //$input.="<input type=\"hidden\" name=\"stay\" value=\"0\" /><input type=\"button\" name=\"valider\" value=\"Sauver et rester sur la page\" class=\"btn btn-primary\" onclick=\"".(($_GET["mode"]!="suppr")?"document.form1.version_id.value=1;document.form1.stay.value=1;validateGenForm(document.form1)":"document.form1.submit()")."\" />&nbsp;";
   
      if($version_id==2&&$_GET["mode"]=="modif"){
        $input.="<input type=\"button\" name=\"valider\" value=\"".$trad["valider"]."\" class=\"btn btn-success\" onclick=\"if(confirm('Vous allez écraser la version en ligne')){document.form1.version_id.value=1;validateGenForm(document.form1)}\"/>&nbsp;";
      }else{
        $input.="<input type=\"button\" name=\"valider\" value=\"".$trad["valider"]."\" class=\"btn btn-success\" onclick=\"".(($_GET["mode"]!="suppr")?"document.form1.version_id.value=1;validateGenForm(document.form1)":"document.form1.submit()")."\"/>&nbsp;";
      }
      $input.="<input type=\"button\" name=\"valider\" value=\"".$trad["Sauver en brouillon"]."\" class=\"btn btn-primary\" onclick=\"".(($_GET["mode"]!="suppr")?"document.form1.version_id.value=2;validateGenForm(document.form1)":"document.form1.submit()")."\"/>&nbsp;";
      $input.="<input type=\"button\" value=\"".$trad["annuler"]."\" class=\"btn btn-error\" onclick=\"framecontent.location='".$_SERVER["PHP_SELF"]."?mode=undo&arbre_id=".$_GET["arbre_id"]."&langue_id=".$_GET["langue_id"]."'\">";      
    }
    if($_GET["mode"]=="modif"){
      //on verifie si on peut editer le noeud
      $sql="select users_id_verrou,login from ".__racinebd__."arbre a inner join ".__racinebd__."users u on users_id_verrou=users_id where arbre_id=".$_GET["arbre_id"];
      //print $sql;
      $link_verrou=query($sql);
      $tbl_result=fetch($link_verrou);
      /*
      print $tbl_result["users_id_verrou"]."<br>";
      print $_SESSION["users_id"]."<br>";
      */
      if($tbl_result["users_id_verrou"]==$_SESSION["users_id"]||$tbl_result["users_id_verrou"]==""){
        //on verrouille le noeud
        $sql="update ".__racinebd__."arbre set users_id_verrou=".$_SESSION["users_id"]." where arbre_id=".$_GET["arbre_id"];
        query($sql);
      }else{
        require("../../include/template_haut.php");
        ?>
        <div class="clear"></div>
        <center><span style="font-family : arial; font-size : 14px;color:red">Document actuellement utilisé par "<b><?=$tbl_result["login"]?></b>".<br>Vous devez attendre la fin de son utilisation afin de pouvoir le modifier</span></center><br>
        <div class="clear"></div>
        <?
        require("../../include/template_bas.php");
        die;
      }
    }
    if($_GET["gabarit_id"]==""){
      $sql="select gabarit_id from ".__racinebd__."arbre where arbre_id=".$_GET["arbre_id"];
      $link=query($sql);
      $tbl_result=fetch($link);
      $_GET["gabarit_id"]=$tbl_result["gabarit_id"];
    }
    
    $sql="select libelle from ".__racinebd__."langue where langue_id=".$_GET["langue_id"];
    $link=query($sql);
    $tbl_result=fetch($link);
    $currentlangue=$tbl_result["libelle"];
    if($_GET["mode"]=="ajout"){
    $sql="select libelle as libellelangue,shortlib as shortliblangue from ".__racinebd__."langue l where l.langue_id!=".$_GET["langue_id"];
    }else{
    $sql="select libelle as libellelangue,shortlib as shortliblangue,c.* from ".__racinebd__."langue l inner join ".__racinebd__."contenu c1 on c1.langue_id=l.langue_id and arbre_id='".$_GET["arbre_id"]."' left join ".__racinebd__."content c on c.contenu_id=c1.contenu_id and c.version_id=".$version_id." where l.langue_id!=".$_GET["langue_id"];
    }
    //print $sql."<br>";
    $link=query($sql);
    $tbl_list_other_langue=array();
    while($tbl_result=fetch($link)){
      $tbl_list_other_langue[]=$tbl_result;
    }

    
    $sqllistfile="select * from ".__racinebd__."fichiers where supprimer=0 and content_id=".$_GET["content_id"];
    $sqllisttag1="select t.tag_id,t.libelle from ".__racinebd__."tag t left join ".__racinebd__."tag_content tc on t.tag_id=tc.tag_id and tc.content_id='".$_GET["content_id"]."' where tc.tag_id is null and supprimer=0 order by t.libelle";
    $sqllisttag2="select t.tag_id,t.libelle from ".__racinebd__."tag t inner join ".__racinebd__."tag_content tc on t.tag_id=tc.tag_id where tc.content_id='".$_GET["content_id"]."'  and supprimer=0 order by t.libelle";
    $sqllisttag3="select t.tag_search_id,t.libelle from ".__racinebd__."tag_search t left join ".__racinebd__."tag_search_content tc on t.tag_search_id=tc.tag_search_id and tc.content_id='".$_GET["content_id"]."' where tc.tag_search_id is null and supprimer=0  order by t.libelle";
    $sqllisttag4="select t.tag_search_id,t.libelle from ".__racinebd__."tag_search t inner join ".__racinebd__."tag_search_content tc on t.tag_search_id=tc.tag_search_id where tc.content_id='".$_GET["content_id"]."' and supprimer=0  order by t.libelle";
  
    $sqlfournisseur="select fournisseur_id,libelle from fournisseur where supprimer=0 order by libelle";
    $sqltva="select tva_id,valeur from tva where supprimer=0 order by valeur";  
    require($_SERVER["DOCUMENT_ROOT"].__racineadminmenu__."/confarticle.php");
    
    $tabcolonne["lastversion_id"]="lastversion_id|hidden";		
  require("../../include/template_detail.php");
  }
}
?>