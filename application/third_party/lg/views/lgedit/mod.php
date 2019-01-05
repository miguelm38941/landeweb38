<html>
<head>
<?php
	include_once(APPPATH.'/views/head.php');
?>
<script type="text/javascript">

	window.lgedit_form_reset=false;
$(document).ready(function(){
	$("#lgedit_form form").append('<input type="hidden" name="id" value="<?= $id ?>"/>');
	$("#lgedit_peremption").hide();

	// later ...
	$(".btn").click(function(e){
		var quantite_produit = $("#lgedit_quantite").val();
		if ( quantite_produit.exists() ) {
			if(quantite_produit!=''){
				alert('Ne peut etre vide');
				e.preventDefault(e);
			}else{
				alert(quantite_produit);
			}
		}
	})	
});

</script>
</head>
<body>
<?php
	include_once(APPPATH.'/views/menu.php');
?>
<main>
<div class="container">
	<h4><?= $title ?></h4>
	<br><br>
<?php

	echo lgedit_generate_form($table,$datas,true);
	if($referer){
?>
<a class="btn" href="<?= $referer ?>">BACK</a>
<?php
	}
?>
</div>
</main>
<br><br><br>
<?php include_once(APPPATH.'/views/footer.php'); ?>
</body>
</html>
