<html>
<head>
<?php
	include_once(APPPATH.'/views/head.php');
?>
<script type="text/javascript">

	window.lgedit_form_reset=false;
$(document).ready(function(){
	$("#lgedit_form form").append('<input type="hidden" name="id" value="<?= $id ?>"/>');	
});

</script>
</head>
<body>
<?php
	include_once(APPPATH.'/views/menu.php');
?>
<main>
<div class="container">
	<h5></h5>
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
</body>
</html>
