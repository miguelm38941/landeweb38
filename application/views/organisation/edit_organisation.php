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
    <h1>Éditer l'organisation</h1>
<!--    <p>Veuillez renseigner les champs</p>-->

    <!--    <div id="infoMessage">--><?php //echo $message;?><!--</div>-->

    <?php echo form_open("users/UpdateOrganisation");?>

    <p>
        <?php echo '<label for="name">Libellé</label>' ?><br />
        <input type="text" value="<?php echo $data->titre;?>" name="titre">
    </p>

    <p>
        <?php echo '<label for="email">Désignation</label>' ?><br />
        <input type="text" value="<?php echo $data->designation;?>" name="designation">
    </p>

    <p>
        <?php echo '<label for="email">Adresse</label>' ?><br />
        <input type="text" value="<?php echo $data->adresse;?>" name="adresse">
    </p>

    <p>
        <?php echo '<label for="email">Ville</label>' ?><br />
        <input type="text" value="<?php echo $data->ville;?>" name="ville">
    </p>

    <p>
        <?php echo '<label for="email">Email</label>' ?><br />
        <input type="text" value="<?php echo $data->email;?>" name="email">
    </p>

    <p>
        <?php echo '<label for="email">Téléphone</label>' ?><br />
        <input type="text" value="<?php echo $data->telephone;?>" name="telephone">
    </p>

  

    <p>
        <label for="type">Type</label><br />
        <select name="type" required class="validate ">
            <?php foreach ($types as $type) : ?>
                <option <?php echo $type->id_type_organisation == $data->id_type_organisation ? 'selected' : false;?> value="<?php echo $type->id_type_organisation;?>"><?php echo $type->name;?></option>
            <?php endforeach; ?>

        </select>
    </p>

    <input type="hidden" value="<?php echo $data->id_organisation;?>" name="id">
    <!--    --><?php //echo form_hidden($csrf); ?>

    <p><?php echo form_submit('submit', lang('edit_user_submit_btn'), array('class' => 'btn'));?></p>

    <?php echo form_close();?>

</div>
