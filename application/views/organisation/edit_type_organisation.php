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

<div class="container">
    <h1>Éditer le type d'organisation</h1>
    <p>Veuillez renseigner les champs</p>

<!--    <div id="infoMessage">--><?php //echo $message;?><!--</div>-->

    <?php echo form_open("users/UpdateTypeOrganisation");?>

    <p>
        <?php echo '<label for="username">Libellé type organisation</label>' ?><br />
        <input type="text" value="<?php echo $name;?>" name="name">
    </p>

    <p>
        <?php echo '<label for="email">Description type organisation</label>' ?><br />
        <input type="text" value="<?php echo $description;?>" name="description">
    </p>

    <input type="hidden" value="<?php echo $id_type_organisation;?>" name="id">
<!--    --><?php //echo form_hidden($csrf); ?>

    <p><?php echo form_submit('submit', lang('edit_user_submit_btn'), array('class' => 'btn'));?></p>

    <?php echo form_close();?>

</div>
