<?php 
header('Content-type: text/html; charset=ISO-8859-1');
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Update Stock Manager Advance to V2.0</title>
<link rel="SHORTCUT ICON" href="../assets/img/favicon.ico"/>
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-cosmo.css"/>
<link href="css/custom.css" rel="stylesheet" type="text/css" />
<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
<style type="text/css">
html{ height: 100%; }
body { padding-bottom:40px; height:auto; background:url("../assets/img/bg.gif"); }
form { margin:0; }
</style>
</head>
<body>
 <div id="install-header">
 <img src="img/logo.png" />
 </div>
 <div class="install">
  <?php 
	require("update.php");
  ?>
 </div>
<script src="../assets/js/jquery.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('form').form();
  $('.tip').tooltip();
});
</script>        
</body>
</html>