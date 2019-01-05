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
<h4>Ordonnance N&deg;</h4>

<table border="1" style="width:30%">
<tr>
	<td>Date: </td>
	<td><?= $ordonnance['created'] ?></td>
</tr>
<tr>
	<td>Code: </td>
	<td><?= $pvv['code'] ?></td>
</tr>
<tr>
	<td>PVV: </td>
	<td><?= $pvv['nom']." ".$pvv['prenom'] ?></td>
</tr>
<tr>
	<td>Date de la livraison: </td>
	<td><?= $ordonnance['delivered'] ?></td>
</tr>
<tr>
	<td>Etat: </td>
	<td></td>
</tr>
</table>

<table border=1>
<thead>
	<th>Designation</th>
	<th>Quantite</th>
	<th>Posologie</th>
</thead>
<tbody>
<?php
	$prods = get_produits();
	$ps = json_decode($ordonnance['produits'],true);
	foreach($ps as $p){
		echo "<tr>";
		echo "<td>".$prods[$p['produit']]."</td>";
		echo "<td>".$p['quantite']."</td>";
		echo "<td>".$p['posologie']."</td>";
		echo "</tr>";
	}
?>
</tbody>
</table>
<?php
	if($this->ion_auth->in_group(array('pharmacie')) && !isset($ordonnance['delivered'])){
?>
<div>
	<a class="btn" href="<?= site_url('/backend/ordonnances/deliver/'.$ordonnance['id']) ?>">LIVRER</a>
</div>
<?php
	}
?>
</div>
</main>
</body>
</html>
