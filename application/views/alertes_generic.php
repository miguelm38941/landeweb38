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
<h3 style="background:#eee;padding:10px;">Produits p&eacute;rim&eacute;s</h3>
<div class="row">
<?php //var_dump($datas);exit;
	//echo lgedit_generate_table($datas['table'],array(),$datas['options']);
	//echo lgedit_generate_table($datas['table'],$datas['datas'],$datas['options']);
?>

<div class="lgedit_table" data-table="stock">
		<form>
        <div class="input-field">
          <input id="lgedit_search" type="search">
          <label for="lgedit_search"><i class="material-icons">search</i></label>
        </div>
      </form>

	<table class="highlight">
        <thead>
            <tr><th class="hide">id</th>
            <th class="">Pharmacie</th>
            <th class="">Produit</th>
            <th class="">quantite</th>
            <th class="">peremption</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach( $datas as $data): ?><?php //var_dump($data['produit']);exit; ?>
            <tr data-id="1" class="" data-dblclick="">
                <td data-name="produit" class="" data-multi="">
                    <?= $data['pharmacie']['nom'] ?>
                </td>
                <td data-name="produit">
                    <?= $data['produit']['nom'] ?>
                </td>
                <td data-name="quantite" class=""><?= $data['quantite'] ?></td>
                <td data-name="peremption" class=""><?= $data['peremption'] ?></td>
                <td data-name="peremption" class="">
                    <a class="btn waves-effect waves-light" href="<?= site_url('/backend/mail_alertes/'.$data['pharmacie']['id'].'_'.$data['produit']['id'].'_'.$data['quantite']) ?>" name="action" value="">Envoyer un rappel</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>

</div>
</main>
<br><br><br>
<?php include_once(APPPATH.'/views/footer.php'); ?>
</body>
</html>
