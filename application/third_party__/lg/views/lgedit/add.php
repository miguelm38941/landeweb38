<html>
<head>
<?php
	include_once(APPPATH.'/views/head.php');
?>
<script type="text/javascript">

$(document).ready(function(){
});

</script>
</head>
<body>
<?php
	include_once(APPPATH.'/views/menu.php');
?>
<main>
<div class="container">
	<h5><?= $table ?></h5>
<?php
	echo lgedit_generate_form($table,$datas,false);
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
