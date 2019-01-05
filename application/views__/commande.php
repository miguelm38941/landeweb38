<html>
<head>
<?php
	include_once(APPPATH.'/views/head.php');
?>
<script type="text/javascript">
$(document).ready(function(){
	$("#societe_pharma").on('change',function(){
		var datas = {
			"id":<?= $commande['id'] ?>,
			"societe_pharma" : $(this).val()
		}
		$.post('<?= site_url('/backend/commandes/add_societe_pharma') ?>',datas,function(){
		});
	});
});
</script>
</head>
<body>
<?php
	//include_once(APPPATH.'/views/menu.php');
?>
<main>
<div class="container">
<h5>Commande de medicament</h5>

<?php
	$dests = get_all_destinataires_commandes();
	$sc = get_societe_pharma();
	$can_save=false;
?>
<table border="1" style="width:30%">
<tr>
	<td>Destinataire:</td>
	<td><?= $dests[$commande['destinataire']]?></td>
</tr>
<!--
<tr>
	<td>Societe :</td>
	<td>
	<?php 
			if(isset($commande['societe_pharma']) && !empty($commande['societe_pharma'])){
				 echo  $sc[$commande['societe_pharma']];
				$can_save=false;
			}else{
				echo '<select id="societe_pharma">';
				echo '<option value="">Selectioner</option>';
				foreach($sc as $k => $v){
					echo '<option value="'.$k.'">'.$v.'</option>';
				}
				echo '</select>';
			}
	?>
	</td>
</tr>
-->
</table>


<table border=1>
<thead>
	<th>Designation</th>
	<th>Quantite</th>
</thead>
<tbody>
<?php
	$prods = get_produits();
	$ps = json_decode($commande['produits'],true);
	foreach($ps as $p){
		echo "<tr>";
		echo "<td>".$prods[$p['produit']]."</td>";
		echo "<td>".$p['quantite']."</td>";
		echo "</tr>";
	}
?>
</tbody>
</table>
<div>
<?php
	if($can_save){
?>
	<a class="btn" href="<?= site_url('/backend/commandes/record/'.$commande['id']) ?>">ENREGISTRER</a>
<?php
	}
?>
</div>
</div>
</main>
</body>
</html>
