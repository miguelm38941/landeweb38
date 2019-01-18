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
    <h3>Ajouter une nouvelle organisation</h3>
<!--    <p>Veuillez renseigner les champs</p>-->

    <!--    <div id="infoMessage">--><?php //echo $message;?><!--</div>-->

    <?php echo form_open("users/insertOrganisation");?>
    <p>
        <label for="titre">Libellé</label><br />
        <input type="text" required name="titre">
    </p>

    <p>
        <label for="designation">Désignation</label><br />
        <input type="text" required name="designation">
    </p>

    <p>
        <label for="adresse">Adresse</label><br />
        <input type="text" required name="adresse">
    </p>

    <p>
        <label for="ville">Ville</label><br />
        <input type="text" required name="ville">
    </p>

    <p>
        <label for="email">Email</label><br />
        <input type="text" required name="email">
    </p>

    <p>
        <label for="telephone">Téléphone</label><br />
        <input type="text" required name="telephone">
    </p>

    <p>
        <label for="type">Type</label><br />
        <select name="type" required class="validate ">
            <option value="" selected>Choisir...</option>
            <?php foreach ($types as $type) : ?>
                <option value="<?php echo $type->id_type_organisation;?>"><?php echo $type->name;?></option>
            <?php endforeach; ?>
        </select>
    </p>
    <!--    --><?php //echo form_hidden($csrf); ?>

    <p><?php echo form_submit('submit', lang('edit_user_submit_btn'), array('class' => 'btn'));?></p>

    <?php echo form_close();?>

</div>
