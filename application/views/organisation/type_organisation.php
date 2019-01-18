<html>

<head>

    <?php

    include_once(APPPATH.'/views/head.php');

    ?>
</head>

<body>

<div class="wrapper">

    <?php

    include_once(APPPATH.'/views/menu.php');

    ?>

    <main>

        <div class="container">



            <h3><?= isset($title) ? $title : "Les types d'organisations" ?></h3>

            <div class="row">

                <table cellpadding=0 cellspacing=10>
                    <tr>
                        <th>Libellé</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($types as $type):?>
                        <tr>
                            <td><?php echo $type->name ?></td>
                            <td><?php echo htmlspecialchars($type->description,ENT_QUOTES,'UTF-8');?></td>
                            <td>

                                <?php echo anchor("users/edit_type_organisation/".$type->id_type_organisation, 'Edit', array('class' => 'btn')) ;?></td>
                        </tr>
                    <?php endforeach;?>
                </table>



            </div>
            <a id="lgedit_add" href="<?php echo base_url();?>users/insertTypeOrganisation" class="btn-floating btn-large waves-effect waves-light red right"><i class="material-icons">add</i></a>
    </main>

</div>

<?php include_once(APPPATH.'/views/footer.php'); ?>

</body>

</html>