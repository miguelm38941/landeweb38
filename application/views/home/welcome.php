<html>

<head>

<?php

	include_once(APPPATH.'/views/head.php');

?>

</head>

<body>

<div class="wrapper">

<?php

	include_once('menu.php');

?>

<main>

<div class="container">

<h1 style="width:100%" class="center-align">Bienvenue sur Landela</h1>

<div class="center-align">

	<a class="btn" href="<?= site_url('/auth/login') ?>">Acceder</a>

	<a class="btn" href="<?= site_url('/welcome/inscription') ?>">Inscription</a>

</div>

</div>

</main>

</div>

<?php include_once(APPPATH.'/views/footer.php'); ?>

</body>

</html>

