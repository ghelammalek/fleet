<?php
require("../../require/function.php");
require("../../require/back_include.php");
?>
var sidebar = false;
function modifier(langue,version_id){
  if (!tree.selectedBranches[tree.selectedBranches.length-1].isRoot&&tree.selectedBranches[tree.selectedBranches.length-1].getAncestor().struct.id!='pb')
    modif(langue,version_id);
}
function informations(){
if(tree.selectedBranches.length>0){
  if (!tree.selectedBranches[tree.selectedBranches.length-1].isRoot)
    info();
}
}
function verrou(){
if(tree.selectedBranches.length>0){
  if (!tree.selectedBranches[tree.selectedBranches.length-1].isRoot&&tree.selectedBranches[tree.selectedBranches.length-1].getAncestor().struct.id!='pb') {
    tree.selectedBranches[tree.selectedBranches.length-1].chgVerrou();
  }
}
}
function supprimer(){
if(tree.selectedBranches.length>0){
  if (!tree.selectedBranches[tree.selectedBranches.length-1].isRoot&&tree.selectedBranches[tree.selectedBranches.length-1].getAncestor().struct.id!='pb') {
    tree.selectedBranches[tree.selectedBranches.length-1]._setDropAjax(tree.getBranchById('pb'), 0, 0, 0, null);
  }
}
}
function renommer(){
if(tree.selectedBranches.length>0){
  if (!tree.selectedBranches[tree.selectedBranches.length-1].isRoot&&tree.selectedBranches[tree.selectedBranches.length-1].getAncestor().struct.id!='pb') {
    tree.selectedBranches[tree.selectedBranches.length-1].setDblClick(null);
  }
}
}
function copier(){
if(tree.selectedBranches.length>0){
  if (!tree.selectedBranches[tree.selectedBranches.length-1].isRoot&&tree.selectedBranches[tree.selectedBranches.length-1].getAncestor().struct.id!='pb') {
    tree.selectedBranches.push(tree.selectedBranches[tree.selectedBranches.length-1]);
    tree.copy();
  }
}
}
function couper(){
if(tree.selectedBranches.length>0){
  if (!tree.selectedBranches[tree.selectedBranches.length-1].isRoot&&tree.selectedBranches[tree.selectedBranches.length-1].getAncestor().struct.id!='pb') {
    tree.selectedBranches.push(tree.selectedBranches[tree.selectedBranches.length-1]);
    tree.cut();
  }
}
}
function coller(){
if(tree.selectedBranches.length>0){
  if (!tree.selectedBranches[tree.selectedBranches.length-1].isRoot&&tree.selectedBranches[tree.selectedBranches.length-1].getAncestor().struct.id!='pb') {
    tree.paste();
  }
}
}
function enpremier(){
  if(tree.selectedBranches.length>0){
    if (!tree.selectedBranches[tree.selectedBranches.length-1].isRoot&&tree.selectedBranches[tree.selectedBranches.length-1].getAncestor().struct.id!='pb') {
      tree.selectedBranches[tree.selectedBranches.length-1]._setDropAjax(tree.selectedBranches[tree.selectedBranches.length-1].getParent().children[0], 1, 0, 0, null);
      tree.selectedBranches[tree.selectedBranches.length-1].unselect();
    }
  }
}
function plushaut(){
if(tree.selectedBranches.length>0){
  if (!tree.selectedBranches[tree.selectedBranches.length-1].isRoot&&tree.selectedBranches[tree.selectedBranches.length-1].getAncestor().struct.id!='pb') {
    tree.selectedBranches[tree.selectedBranches.length-1]._setDropAjax(tree.selectedBranches[tree.selectedBranches.length-1].getParent().children[tree.selectedBranches[tree.selectedBranches.length-1].pos-1], 1, 0, 0, null);
    tree.selectedBranches[tree.selectedBranches.length-1].unselect();
  }
}
}
function plusbas(){
if(tree.selectedBranches.length>0){
  if (!tree.selectedBranches[tree.selectedBranches.length-1].isRoot&&tree.selectedBranches[tree.selectedBranches.length-1].getAncestor().struct.id!='pb') {
    if(tree.selectedBranches[tree.selectedBranches.length-1].pos==tree.selectedBranches[tree.selectedBranches.length-1].getParent().children.length-2){
        tree.selectedBranches[tree.selectedBranches.length-1]._setDropAjax(tree.selectedBranches[tree.selectedBranches.length-1].getParent(), 0, 0, 0, null);
    }else{
        tree.selectedBranches[tree.selectedBranches.length-1]._setDropAjax(tree.selectedBranches[tree.selectedBranches.length-1].getParent().children[tree.selectedBranches[tree.selectedBranches.length-1].pos+2], 1, 0, 0, null, tree.selectedBranches[tree.selectedBranches.length-1].getParent().children[tree.selectedBranches[tree.selectedBranches.length-1].pos+1]);
    }
    tree.selectedBranches[tree.selectedBranches.length-1].unselect();
  }
}
}
function publier(){
  if(tree.selectedBranches.length>0){
    if (!tree.selectedBranches[tree.selectedBranches.length-1].isRoot&&tree.selectedBranches[tree.selectedBranches.length-1].getAncestor().struct.id!='pb') {
      tree.selectedBranches[tree.selectedBranches.length-1].chgEtat();
    }
  }
}
function endernier(){
if(tree.selectedBranches.length>0){
  if (!tree.selectedBranches[tree.selectedBranches.length-1].isRoot&&tree.selectedBranches[tree.selectedBranches.length-1].getAncestor().struct.id!='pb') {
    tree.selectedBranches[tree.selectedBranches.length-1]._setDropAjax(tree.selectedBranches[tree.selectedBranches.length-1].getParent(), 0, 0, 0, null);
    tree.selectedBranches[tree.selectedBranches.length-1].unselect();
  }
}
}
function creeralias(){
  if(tree.selectedBranches.length>0){
    if (!tree.selectedBranches[tree.selectedBranches.length-1].isRoot&&tree.selectedBranches[tree.selectedBranches.length-1].getAncestor().struct.id!='pb') {
      if(tree.selectedBranches[tree.selectedBranches.length-1].tree.copiedBranches.length>0)
        tree.selectedBranches[tree.selectedBranches.length-1].tree.copiedBranches[tree.selectedBranches[tree.selectedBranches.length-1].tree.copiedBranches.length-1]._setDropAjax(tree.selectedBranches[tree.selectedBranches.length-1], 0, 0, 1, null);
      if(tree.selectedBranches[tree.selectedBranches.length-1].tree.cuttedBranches.length>0)
        tree.selectedBranches[tree.selectedBranches.length-1].tree.cuttedBranches[tree.selectedBranches[tree.selectedBranches.length-1].tree.cuttedBranches.length-1]._setDropAjax(tree.selectedBranches[tree.selectedBranches.length-1], 0, 0, 1, null);
    }
  }
}
function droits(){
if(tree.selectedBranches.length>0){
	if(document.all){
    		moniframe=eval("framecontent");
  	}else{
    		moniframe=document.getElementById('framecontent').contentWindow
  	}
    pere=(tree.selectedBranches[tree.selectedBranches.length-1].getParent().struct.id=="root1")?0:tree.selectedBranches[tree.selectedBranches.length-1].getParent().struct.id;
    arbre_id=tree.selectedBranches[tree.selectedBranches.length-1].struct.id;
    moniframe.location='<?=__racineadminmenucore__?>/gabarit/droits.php?pere='+pere+'&arbre_id='+arbre_id;
    //window.open('<?=__racineadminmenucore__?>/gabarit/droits.php?pere='+pere+'&arbre_id='+arbre_id);
	}
}
function show_arbre(){
/*
	if(document.getElementById("contenaire_arbre").style.left == "-<?=__widtharbre__+24?>px"){
		document.getElementById("contenaire_arbre").style.left = 0;
		document.getElementById("img_pointer_arbre").style.backgroundImage='url(<?=__reparbre__?>icones_arbre/fleche_on.png)';
	} else {
		document.getElementById("contenaire_arbre").style.left = "-<?=__widtharbre__+24?>px";
		document.getElementById("img_pointer_arbre").style.backgroundImage='url(<?=__reparbre__?>icones_arbre/fleche_off.png)';
	}*/
	if(sidebar==false){
  new Effect.Tween('contenaire_arbre', 0,- <?=__widtharbre__+24?> , { duration: 0.5,transition:Effect.Transitions.spring}, monouvre);
  //document.getElementById("img_pointer_arbre").style.backgroundImage='url(<?=__reparbre__?>icones_arbre/fleche_off.png)'; 
  document.getElementById("img_pointer_arbre").className='img_pointer_arbre_off';
  //new Effect.Tween('sideBarContents', 0, 200, { duration: 0.5,transition:Effect.Transitions.spring}, function(p){ this.style.clip='rect(0px,'+Math.round(p)+'px,250px,0px)'});
  sidebar=true;
  }else{
  new Effect.Tween('contenaire_arbre',- <?=__widtharbre__+24?>, 0, { duration: 0.5,transition:Effect.Transitions.spring}, monouvre);
  //document.getElementById("img_pointer_arbre").style.backgroundImage='url(<?=__reparbre__?>icones_arbre/fleche_on.png)';
  document.getElementById("img_pointer_arbre").className='img_pointer_arbre_on';
  //new Effect.Tween('sideBarContents', 200, 0, { duration: 0.5,transition:Effect.Transitions.spring}, function(p){ this.style.clip='rect(0px,'+Math.round(p)+'px,250px,0px)'});
  sidebar=false;
  }
}
function monouvre(p){
  this.style.left=Math.round(p)+"px";
}
//permet de palier au pb de prototype 1.6
Function.prototype.bindAsEventListener = function(object) {
  var __method = this, args = $A(arguments), object = args.shift();
    return function(event) {
      //correction jc
      return __method.apply(object, [( event || window.event)].concat(args).concat($A(arguments)));
    }
}
function funcOpen (branch, response) {
	// Ici tu peux traiter le retour et retourner true si
	// tu veux insérer les enfants, false si tu veux pas
	return true;
}
function funcVerrou(branch,response){
  return true;
}
function funcEtat(branch,response){
  return true;
}
function contextmenudiv(branch,e){ 
  if(TafelTree.menudroit!=null){
    //alert('ici');
    TafelTree.menudroit.hide(e);
  }
  var myMenuItems = Array();
  var subMenuItems = Array();
  var subMenuItems2 = Array();
  var subMenuItems3 = Array();
  
  if(branch.struct.id=='root1'){
            <?php
            $myobj=&$_SESSION['obj_users_id'];
    		    if($myobj->user_id=="-1"){
    				  $requete = "select libelle,gabarit_id,iconnormal from ".__racinebd__."gabarit where supprimer=0 order by libelle";
    				}else{
              $requete = "select libelle,gg.gabarit_id,iconnormal from ".__racinebd__."gabarit g inner join ".__racinebd__."groupe_gabarit gg on g.gabarit_id=gg.gabarit_id and gg.groupe_id in(".$_SESSION['obj_users_id']->listgroupeid.") where supprimer=0 group by g.gabarit_id order by g.libelle";
            }
            
            $link=query($requete);
            while ($ligne=fetch($link)){
                ?>
                subMenuItems[subMenuItems.length] = {
                  name: '<?=str_replace("'","\'",$ligne["libelle"])?>',
                  img: '<?=__uploaddir__.__racinebd__."gabarit".$ligne["gabarit_id"].".".$ligne["iconnormal"]?>',
                  callback: function() {
                    ajout(<?=$ligne["gabarit_id"]?>,<?=$_GET["la_langue"]?>);
                  }
                };
                <?
            }
            ?>
            myMenuItems[myMenuItems.length] = {
              name: '<?=$trad["Nouveau"]?>',
              subMenuItems:subMenuItems
            };
            myMenuItems[myMenuItems.length] = {
              name: '<?=$trad["Import"]?>',
              callback: function() {
                importnode();
              }
            };
            if(branch.tree.cuttedBranches.length>0||branch.tree.copiedBranches.length>0){
              
                myMenuItems[myMenuItems.length] = {
                  separator: true
                };
                myMenuItems[myMenuItems.length] = {
                    name: '<?=$trad["Coller"]?>',
                    callback: function() {
                      //alert('Coller');
                      //branch.tree.selectedBranches.push(branch);
                      branch.tree.paste();
                    }
                  };
                <?if(testGenRules("PALL")){?>
                if(branch.tree.copiedBranches.length>0){
                  myMenuItems[myMenuItems.length] = {
                      name: '<?=$trad["Coller l\'arborescence"]?>',
                      callback: function() {
                        //alert('Coller');
                        //branch.tree.selectedBranches.push(branch);
                        branch.tree.pasteAll();
                      }
                    };
                }
                <?}?>
                myMenuItems[myMenuItems.length] = {
                    name: '<?=$trad["Créer un alias"]?>',
                    callback: function() {
                      if(branch.tree.copiedBranches.length>0)
                        branch.tree.copiedBranches[branch.tree.copiedBranches.length-1]._setDropAjax(branch, 0, 0, 1, null);
                      if(branch.tree.cuttedBranches.length>0)
                        branch.tree.cuttedBranches[branch.tree.cuttedBranches.length-1]._setDropAjax(branch, 0, 0, 1, null);
                    }
                  };
              }
  
  } else if (!branch.isRoot&&branch.getAncestor().struct.id!='pb') {
        <?php
        $myobj=&$_SESSION['obj_users_id'];
		    if($myobj->user_id=="-1"){
				  $requete = "select libelle,gabarit_id,iconnormal from ".__racinebd__."gabarit order by libelle";
				}else{
          $requete = "select libelle,g.gabarit_id,iconnormal from ".__racinebd__."gabarit g inner join ".__racinebd__."groupe_gabarit gg on g.gabarit_id=gg.gabarit_id and gg.groupe_id in(".$_SESSION['obj_users_id']->listgroupeid.") group by g.gabarit_id order by g.libelle";
        }
        $link=query($requete);
        while ($ligne=fetch($link)){
            ?>
            subMenuItems[subMenuItems.length] = {
              name: '<?=str_replace("'","\'",$ligne["libelle"])?>',
              img: '<?=__uploaddir__.__racinebd__."gabarit".$ligne["gabarit_id"].".".$ligne["iconnormal"]?>',
              callback: function() {
                    ajout(<?=$ligne["gabarit_id"]?>,<?=$_GET["la_langue"]?>);
                  }
            };
            <?
        }
        ?>
        
      //affichage du menu
      if(branch.struct.alias=='0'){
          myMenuItems[myMenuItems.length] = {
            name: '<?=$trad["Nouveau"]?>',
            subMenuItems:subMenuItems
          };
          myMenuItems[myMenuItems.length] = {
            separator: true
          };
      }
      
      if(branch.struct.alias=='0'){
      myMenuItems[myMenuItems.length] = {
          name: '<?=$trad["Explorer"]?>',
          callback: function() {
            explorer(<?=$_GET["la_langue"]?>);
          }
        };
      myMenuItems[myMenuItems.length] = {
          name: '<?=$trad["Informations"]?>',
          callback: function() {
            info();
          }
        };
      
        myMenuItems[myMenuItems.length] = {
            name: '<?=$trad["Aperçu"]?>',
            subMenuItems:subMenuItems3
          };
      
      if(branch.struct.verrou){
        myMenuItems[myMenuItems.length] = {
            name: '<?=$trad["Déverrouiller"]?>',
            callback: function() {
              branch.chgVerrou();
            }
          };
      }else{
        myMenuItems[myMenuItems.length] = {
            name: '<?=$trad["Verrouiller"]?>',
            callback: function() {
              branch.chgVerrou();
            }
          };
      }
    }
    <?php
    
    $requete = "select libelle,version_id from ".__racinebd__."version order by version_id ASC";
    $link=query($requete);
    while ($ligne=fetch($link)){
        ?>
        subMenuItems2[subMenuItems2.length] = {
          name: '<?=$trad[$ligne["libelle"]]?>',
          callback: function() {
            modif(<?=$_GET["la_langue"]?>,<?=$ligne["version_id"]?>)
          }
        };
        subMenuItems3[subMenuItems3.length] = {
          name: '<?=$trad[$ligne["libelle"]]?>',
          callback: function() {
            show(<?=$_GET["la_langue"]?>,<?=$ligne["version_id"]?>)
          }
        };
        <?
    }
    ?>
    if(branch.struct.alias=='0'){
      myMenuItems[myMenuItems.length] = {
          name: '<?=$trad["Modifier"]?>',
          subMenuItems:subMenuItems2
        };
      
      if(branch.struct.etat==1){
        myMenuItems[myMenuItems.length] = {
            name: '<?=$trad["Dépublier"]?>',
            callback: function() {
              branch.chgEtat();
            }
          };
      }else{
        myMenuItems[myMenuItems.length] = {
            name: '<?=$trad["Publier"]?>',
            callback: function() {
              branch.chgEtat();
            }
          };
      }
    }
    myMenuItems[myMenuItems.length] = {
        name: '<?=$trad["Supprimer"]?>',
        callback: function() {
          branch._setDropAjax(tree.getBranchById('pb'), 0, 0, 0, null);
        }
      };
    myMenuItems[myMenuItems.length] = {
        name: '<?=$trad["Renommer"]?>',
        callback: function() {
          branch.setDblClick(e);
        }
      };
    if(branch.struct.alias=='0'){
      myMenuItems[myMenuItems.length] = {
          separator: true
        };
      myMenuItems[myMenuItems.length] = {
          name: '<?=$trad["Copier"]?>',
          callback: function() {
            branch.tree.selectedBranches.push(branch);
            tree.copy();
          }
        };
      myMenuItems[myMenuItems.length] = {
          name: '<?=$trad["Couper"]?>',
          callback: function() {
            branch.tree.selectedBranches.push(branch);
            branch.tree.cut();
          }
        };
      if(branch.tree.cuttedBranches.length>0||branch.tree.copiedBranches.length>0){
        myMenuItems[myMenuItems.length] = {
            name: '<?=$trad["Coller"]?>',
            callback: function() {
              branch.tree.paste();
            }
          };
        <?if(testGenRules("PALL")){?>
        if(branch.tree.copiedBranches.length>0){
        myMenuItems[myMenuItems.length] = {
              name: '<?=$trad["Coller l\'arborescence"]?>',
              callback: function() {
                //alert('Coller');
                //branch.tree.selectedBranches.push(branch);
                branch.tree.pasteAll();
              }
            };
        }
        <?}?>
        myMenuItems[myMenuItems.length] = {
            name: '<?=$trad["Créer un alias"]?>',
            callback: function() {
              if(branch.tree.copiedBranches.length>0)
                branch.tree.copiedBranches[branch.tree.copiedBranches.length-1]._setDropAjax(branch, 0, 0, 1, null);
              if(branch.tree.cuttedBranches.length>0)
                branch.tree.cuttedBranches[branch.tree.cuttedBranches.length-1]._setDropAjax(branch, 0, 0, 1, null);
            }
          };
      }
    }
    if(branch.pos>0||branch.tree.selectedBranches.length==2||branch.getParent().children.length-1!=branch.pos){
      myMenuItems[myMenuItems.length] = {
          separator: true
        };
      //a faire plus tard
      /*
      if(branch.tree.selectedBranches.length==2){
        myMenuItems[myMenuItems.length] = {
            name: 'Intervertir la position',
            callback: function() {
              alert('Forward function called');
            }
          };
      }*/
      if(branch.pos>0){
        myMenuItems[myMenuItems.length] = {
            name: '<?=$trad["En premier"]?>',
            callback: function() {
              branch._setDropAjax(branch.getParent().children[0], 1, 0, 0, null);
            }
          };
        myMenuItems[myMenuItems.length] = {
            name: '<?=$trad["Plus haut"]?>',
            callback: function() {
              branch._setDropAjax(branch.getParent().children[branch.pos-1], 1, 0, 0, null);
            }
          };
      }
      if(branch.getParent().children.length-1!=branch.pos){
        myMenuItems[myMenuItems.length] = {
            name: '<?=$trad["Plus bas"]?>',
            callback: function() {
              branch.movedown();
            }
          };
        myMenuItems[myMenuItems.length] = {
            name: '<?=$trad["En dernier"]?>',
            callback: function() {
              branch._setDropAjax(branch.getParent(), 0, 0, 0, null);
            }
          };
      }
    }
    myMenuItems[myMenuItems.length] = {
          separator: true
        };
    myMenuItems[myMenuItems.length] = {
          name: '<?=$trad["Droits"]?>',
          callback: function() {
            droits();
          }
        };
    myMenuItems[myMenuItems.length] = {
          separator: true
        };
    myMenuItems[myMenuItems.length] = {
          name: '<?=$trad["Export"]?>',
          callback: function() {
            exportnode();
          }
        };
    myMenuItems[myMenuItems.length] = {
          name: '<?=$trad["Import"]?>',
          callback: function() {
            importnode();
          }
        };
  }
  if(branch.struct.id=='pb'){
  <?if(testGenRules("FDEL")){?>
    myMenuItems[myMenuItems.length] = {
        name: '<?=$trad["Vider la corbeille"]?>',
        callback: function() {
          for(i=0;i<branch.children.length;i++){
            branch.children[i].finishDelete();
          }
        }
      };
  <?}?>
  }else if(branch.getParent()&&branch.getParent().struct.id=='pb'){
  <?if(testGenRules("REST")){?>
    myMenuItems[myMenuItems.length] = {
        name: '<?=$trad["Restaurer"]?>',
        callback: function() {
          branch.restore();
        }
      };
  <?}
  if(testGenRules("FDEL")){?>
    myMenuItems[myMenuItems.length] = {
        name: '<?=$trad["Suppression définitive"]?>',
        callback: function() {
          branch.finishDelete();
        }
      };
  <?}?>  
    myMenuItems[myMenuItems.length] = {
        name: '<?=$trad["Informations"]?>',
        callback: function() {
          alert('Informations');
        }
      };
  }
  if(myMenuItems.length>0){
    TafelTree.menudroit=new Proto.Menu({
      selector: '#test', // context menu will be shown when element with id of "contextArea" is clicked
      className: 'menu desktop', // this is a class which will be attached to menu container (used for css styling)
      menuItems: myMenuItems // array of menu items
    })
    TafelTree.menudroit.show(e);
  }
  return false;
}
function funcEdit(branch){
  return true;
}
function funcDrop3 (move, drop, response, finished) {
	// On vérifie avant que le drop soit fait. A ce moment là
	// la requête Ajax est effectuée, mais pas le drop.
	if (!finished) {
		// On évalue la réponse Ajax. L'objet contient donc
		// une propriété "ok" et une autre "msg"
		var obj = eval(response);
		if (!obj.ok) {
			alert ('Problème : ' + obj.msg);
			return false;
		}
	}
	//alert('ici');
	return true;
}

function glu (branch) {
  return (branch.children.length > 0) ? true : false;
}
function testParent (branch) {
		var p = tree.getBranches(glu);
		var str = '';
		for (var i = 0; i < p.length; i++) {
			str += p[i].getText() + ' : ' + p[i].children.length + "\n";
		}
		//alert(str);
}
function effet () {
	var branch = tree.getBranchById('child1');
	branch.refreshChildren();
}
function drop () {
	return true;
}

function funcFinishDelete(){
  refreshA();
  return true;
}
function funcRestore(){
  return true;
}
//function modif(langue_id,arbre_id,mode,version_id){
function ajout(gabarit_id,langue_id){
  if(tree.selectedBranches[tree.selectedBranches.length-1].getAncestor()==null||tree.selectedBranches[tree.selectedBranches.length-1].getAncestor().struct.id!='pb'){
    if(document.all){
      moniframe=eval("framecontent");
    }else{
      moniframe=document.getElementById('framecontent').contentWindow
    }
    //on recupere le pere
    if(tree.selectedBranches.length>0){
      arbre_id=(tree.selectedBranches[tree.selectedBranches.length-1].struct.id=="root1")?0:tree.selectedBranches[tree.selectedBranches.length-1].struct.id;
      moniframe.location='<?=__racineadminmenucore__?>/gabarit/article.php?pere='+arbre_id+'&langue_id='+langue_id+'&mode=ajout&gabarit_id='+gabarit_id;
      //window.open('<?=__racineadminmenucore__?>/gabarit/article.php?pere='+arbre_id+'&langue_id='+langue_id+'&mode=ajout&gabarit_id='+gabarit_id);
    }else{
      alert('<?=$trad["Veuillez sélectionner un élément"]?>');
    }
  }
}	
function modif(langue_id,version_id){
  if(document.all){
    moniframe=eval("framecontent");
  }else{
    moniframe=document.getElementById('framecontent').contentWindow
  }
  //alert(tree.selectedBranches.length)
  //on recupere le pere
  if(tree.selectedBranches.length>0){
    pere=(tree.selectedBranches[tree.selectedBranches.length-1].getParent().struct.id=="root1")?0:tree.selectedBranches[tree.selectedBranches.length-1].getParent().struct.id;
    arbre_id=tree.selectedBranches[tree.selectedBranches.length-1].struct.id;
    moniframe.location='<?=__racineadminmenucore__?>/gabarit/article.php?pere='+pere+'&arbre_id='+arbre_id+'&langue_id='+langue_id+'&mode=modif&version_id='+version_id;
    //window.open('<?=__racineadminmenucore__?>/gabarit/article.php?pere='+pere+'&arbre_id='+arbre_id+'&langue_id='+langue_id+'&mode=modif&version_id='+version_id);
  }else{
    alert('<?=$trad["Veuillez sélectionner un élément"]?>');
  }
}
function info(){
  if(document.all){
    moniframe=eval("framecontent");
  }else{
    moniframe=document.getElementById('framecontent').contentWindow
  }
  if(tree.selectedBranches.length>0){
    arbre_id=tree.selectedBranches[tree.selectedBranches.length-1].struct.id;
    moniframe.location='<?=__racineadminmenucore__?>/gabarit/log.php?arbre_id='+arbre_id;
  }else{
    alert('<?=$trad["Veuillez sélectionner un élément"]?>');
  } 
}
function refreshA(){
    var branch = top.tree.getBranchById('root1');
		branch.refreshChildren();
		var branch = top.tree.getBranchById('pb');
		branch.refreshChildren();
}
function show(langue_id,version_id){
  if(!tree.selectedBranches[tree.selectedBranches.length-1].isRoot){
    if(tree.selectedBranches.length>0){
      arbre_id=tree.selectedBranches[tree.selectedBranches.length-1].struct.id;
      etat_id=tree.selectedBranches[tree.selectedBranches.length-1].struct.etat;
      //alert("<?=__racine__?>?mode=preview&version_id="+version_id+"&arbre_id="+arbre_id+"&etat_id="+etat_id+"&langue_id="+langue_id)
      window.open("../<?=__arbre__?>preview.php?mode=preview&version_id="+version_id+"&arbre_id="+arbre_id+"&etat_id="+etat_id+"&langue_id="+langue_id);
    }
  }
}
function explorer(langue_id){
  if(document.all){
    moniframe=eval("framecontent");
  }else{
    moniframe=document.getElementById('framecontent').contentWindow
  }
  //alert(tree.selectedBranches.length)
  //on recupere le pere
  if(tree.selectedBranches.length>0){
    arbre_id=tree.selectedBranches[tree.selectedBranches.length-1].struct.id;
    moniframe.location='<?=__racineadminmenucore__?>/gabarit/article.php?&arbre_id='+arbre_id+'&langue_id='+langue_id+'&mode=list';
    //window.open('<?=__racineadminmenucore__?>/gabarit/article.php?&arbre_id='+arbre_id+'&langue_id='+langue_id+'&mode=list');
  }else{
    alert('<?=$trad["Veuillez sélectionner un élément"]?>');
  }
}
function importnode(){
  if(tree.selectedBranches.length>0){
  	if(document.all){
    		moniframe=eval("framecontent");
  	}else{
    		moniframe=document.getElementById('framecontent').contentWindow
  	}
    arbre_id=tree.selectedBranches[tree.selectedBranches.length-1].struct.id;
    moniframe.location='<?=__racineadminmenucore__?>/gabarit/import.php?arbre_id='+arbre_id;
    //window.open('<?=__racineadminmenucore__?>/gabarit/import.php?arbre_id='+arbre_id);
	}
}
function exportnode(){
  if(!tree.selectedBranches[tree.selectedBranches.length-1].isRoot){
    if(tree.selectedBranches.length>0){
      arbre_id=tree.selectedBranches[tree.selectedBranches.length-1].struct.id;
      window.open("../<?=__arbre__?>export.php?arbre_id="+arbre_id);
    }
  }
}