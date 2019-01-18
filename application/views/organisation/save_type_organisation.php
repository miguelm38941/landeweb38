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
<!--nav>
	<div class="nav-wrapper">
		<a href="<?= site_url('/backend/') ?>" class="brand-logo"><img src="<?= base_url('/logo.png') ?>"/></a>
	</div>
</nav-->
<div class="container">
    <h1>Ajouter un nouveau type d'organisation</h1>
    <p>Veuillez renseigner les champs</p>

    <!--    <div id="infoMessage">--><?php //echo $message;?><!--</div>-->

    <?php echo form_open("users/insertTypeOrganisation");?>
    <p>
        <?php echo '<label for="name">Libellé type organisation</label>' ?><br />
        <input type="text" required name="name">
    </p>

    <p>
        <?php echo '<label for="description">Description type organisation</label>' ?><br />
        <input type="text" required name="description">
    </p>


    <!--    --><?php //echo form_hidden($csrf); ?>

    <p><?php echo form_submit('submit', lang('edit_user_submit_btn'), array('class' => 'btn'));?></p>

    <?php echo form_close();?>

</div>
