<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script language="JavaScript" type="text/javascript" src="swfobject.js"></script>
<script>
function Upload_Finished(param1, param2) {
  alert('Chargement(s) effectué(s)')
	top.document.getElementById('<?=$_GET["name"]?>_list').src="../element/multiupload/listfile.php?name=<?=$_GET["name"]?>&folder=<?=$_GET['folder']?>";
}  
</script>
</head>
<body bgcolor="#a7abb1">
  <div id="mon_flash"></div>
	<script type="text/javascript">
	1		// <![CDATA[
		var so = new SWFObject("swf/NasUploader18.swf", "nasuploader", "480", "425", "8" );
		so.addParam ('FlashVars','varget=dossierup%3D<?=$_GET['folder']?>');
		so.addParam ('bgcolor','#a7abb1');
		so.write("mon_flash");
		// ]]>
	</script>
</body>
</html>