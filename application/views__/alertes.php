<html>
<head>
<?php
	include_once(APPPATH.'/views/head.php');
?>
</head>
<body>
<?php
	include_once(APPPATH.'/views/menu.php');
?>
<main>
<div class="container">
<h2>A commander</h2>
<div class="row">
<?php
	//echo lgedit_generate_table($datas['table'],array(),$datas['options']);
	echo lgedit_generate_table($datas['table'],$datas['datas'],$datas['options']);
?>
</div>
<h2>En peremption</h2>
<div class="row">
<?php
	//echo lgedit_generate_table($datas['table'],array(),$datas['options']);
	echo lgedit_generate_table($datas2['table'],$datas2['datas'],$datas2['options']);
?>
</div>
<h2>Perimer</h2>
<div class="row">
<?php
	//echo lgedit_generate_table($datas['table'],array(),$datas['options']);
	echo lgedit_generate_table($datas3['table'],$datas3['datas'],$datas3['options']);
?>
</div>
</div>
</main>
</body>
</html>
