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



            <h3><?= isset($title) ? $title : "Liste des organisations" ?></h3>

            <div class="row">

                <table cellpadding=0 cellspacing=10>
                    <tr>
                        <th>Titre</th>
                        <th>Désignation</th>
                        <th>Adresse</th>
                        <th>Ville</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Type</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($data as $value):?>
                        <tr>
                            <td><?php echo htmlspecialchars($value->titre,ENT_QUOTES,'UTF-8');?></td>
                            <td><?php echo htmlspecialchars($value->designation,ENT_QUOTES,'UTF-8');?></td>
                            <td><?php echo htmlspecialchars($value->adresse,ENT_QUOTES,'UTF-8');?></td>
                            <td><?php echo htmlspecialchars($value->ville,ENT_QUOTES,'UTF-8');?></td>
                            <td><?php echo htmlspecialchars($value->email,ENT_QUOTES,'UTF-8');?></td>
                            <td><?php echo htmlspecialchars($value->telephone,ENT_QUOTES,'UTF-8');?></td>
                            <td><?php echo htmlspecialchars($value->name,ENT_QUOTES,'UTF-8');?></td>
                            <td>
                                <?php if ($value->statut == 1){?>
                                <a href='#' class='btn btn-small btn-success' onclick="return confirm('Êtes vous sûr de désactiver l organisation');">Activée</a>
                                <?php
                                }else{
                                    ?>
                                    <a href='#' class='btn btn-small btn-success' onclick="return confirm('Êtes vous sûr d\'sactiver l organisation');">Désctivée</a>
                                    <?php
                                }?>
                            </td>
                            <td>
                                <?php echo anchor("users/edit_organisation/".$value->id_organisation, 'Edit', array('class' => 'btn')) ;?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>



            </div>
            <a id="lgedit_add" href="<?php echo base_url();?>users/insertOrganisation" class="btn-floating btn-large waves-effect waves-light red right"><i class="material-icons">add</i></a>
    </main>

</div>

<?php include_once(APPPATH.'/views/footer.php'); ?>

</body>

</html>