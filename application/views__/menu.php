<div class="navbar-fixed">
<nav id="menu">
	<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
	<div class="nav-wrapper">
		<a href="<?= site_url('/backend/') ?>" class="brand-logo"><img src="<?= base_url('/logo.png') ?>"/></a>

		<ul id="nav-mobile" class="right hide-on-med-and-down">
<?php	
	if($this->ion_auth->in_group(array('admin'))){	
?>
			<li><a class="dropdown-button" href="#!" data-activates="dropdown1" >PVV<i class="material-icons right">arrow_drop_down</i></a></li>
			<li><a href="<?= site_url('/backend/produits') ?>">Produits</a></li>
			<li><a href="<?= site_url('/backend/propositions') ?>">Propositions</a></li>
			<li><a class="dropdown-button" href="#!" data-activates="dropdown4" >Acteurs<i class="material-icons right">arrow_drop_down</i></a></li>
<?php
	}else if($this->ion_auth->in_group(array('pnls'))){
?>
			<li><a href="<?= site_url('/backend/produits') ?>">Produits</a></li>
			<li><a href="<?= site_url('/backend/agent') ?>">Formation sanitaire</a></li>
			<li><a href="<?= site_url('/backend/medecin') ?>">Medecins</a></li>
			<li><a href="<?= site_url('/backend/societe_pharma') ?>">Societe Pharmaceutique</a></li>
			<li><a href="<?= site_url('/backend/partenaire') ?>">Partenaires</a></li>
			<li><a href="<?= site_url('/backend/pharmacie') ?>">Prepose pharmacie </a></li>
			<li><a href="<?= site_url('/backend/propositions') ?>">Propositions</a></li>

<?php
	}else if($this->ion_auth->in_group(array('pharmacie'))){
?>
			<li><a class="dropdown-button" href="#!" data-activates="dropdown3" >Commandes<i class="material-icons right">arrow_drop_down</i></a></li>
			<li><a href="<?= site_url('/backend/alertes') ?>">Alertes</a></li>
			<li><a href="<?= site_url('/backend/stock') ?>">Stock</a></li>
			<!--li><a href="<?= site_url('/backend/pvv/ordonnances') ?>">Ordonnances</a></li-->
			<li><a href="<?= site_url('/backend/ordonnances') ?>">Ordonnances</a></li>
<?php
	}else if($this->ion_auth->in_group(array('medecin'))){
?>
			<li><a href="<?= site_url('/backend/ordonnances') ?>">Ordonnances</a></li>
			<li><a href="<?= site_url('/backend/pvv') ?>">PVV</a></li>
			<!--li><a href="<?= site_url('/backend/profile_pvv') ?>">Profil PVV</a></li-->
			<li><a href="<?= site_url('/backend/propositions') ?>">Propositions</a></li>
<?php
	}else if($this->ion_auth->in_group(array('agent'))){
?>
			<li><a href="<?= site_url('/lgedit/addPage/pvv') ?>">ajouter PVV</a></li>
			<li><a href="<?= site_url('/backend/profile_pvv') ?>">Profil PVV</a></li>
			<li><a href="<?= site_url('/backend/medecin') ?>">Medecins</a></li>
			<li><a href="<?= site_url('/backend/educateur') ?>">Educateurs</a></li>
<?php
	}else if($this->ion_auth->in_group(array('educateur'))){
?>
			<li><a href="<?= site_url('/backend/pvv') ?>">PVV</a></li>
			<li><a href="<?= site_url('/backend/pvv/filter/tovalidate') ?>">PVV a valider</a></li>
<?php
	}else if($this->ion_auth->in_group(array('regionsante','zonesante','partenaire'))){
?>
		<li><a href="<?= site_url('/backend/stock') ?>">Stock</a></li>
		<li><a class="dropdown-button" href="#!" data-activates="dropdown3" >Commandes<i class="material-icons right">arrow_drop_down</i></a></li>
<?php
		if($this->ion_auth->in_group(array('partenaire'))){
			?>
			<li><a href="<?= site_url('/backend/agent') ?>">Formations sanitaires</a></li>
			<?php
		}
	}else if($this->ion_auth->in_group(array('societe_pharma'))){
?>
	<li><a href="<?= site_url('/backend/commandes/filter/waiting_for_me') ?>">Commandes</a></li>
	<li><a href="<?= site_url('/backend/commandes/filter/delivered') ?>">Commandes gerer</a></li>
<?php
	}else if($this->ion_auth->in_group(array('pvv'))){
?>

<?php
	}
?>
			<li><a class="dropdown-button" href="#!" data-activates="dropdown2">Utilisateur<i class="material-icons right">arrow_drop_down</i></a></li>
		</ul>

		<ul class="side-nav" id="mobile-demo">
		</ul>

	</div>
</nav>


<ul id="dropdown4" class="dropdown-content">
<li><a href="<?= site_url('/backend/agent') ?>">Formation sanitaire</a></li>
<li><a href="<?= site_url('/backend/pharmacie') ?>">Prepose pharmacie </a></li>
<li><a href="<?= site_url('/backend/educateur') ?>">Educateurs</a></li>
<li><a href="<?= site_url('/backend/medecin') ?>">Medecins</a></li>
<li><a href="<?= site_url('/backend/partenaire') ?>">Partenaires</a></li>
<li><a href="<?= site_url('/backend/societe_pharma') ?>">Societe Pharmaceutique</a></li>
<li><a href="<?= site_url('/backend/regionsante') ?>">CDR</a></li>
<li><a href="<?= site_url('/backend/zonesante') ?>">Aire sante</a></li>
</ul>

<ul id="dropdown1" class="dropdown-content">
	<li><a href="<?= site_url('/backend/pvv') ?>">TOUS</a></li>
	<li><a href="<?= site_url('/backend/pvv/filter/tovalidate') ?>">a valider</a></li>
</ul>

<ul id="dropdown3" class="dropdown-content">
	<li><a href="<?= site_url('/backend/commandes') ?>">En cours</a></li>
	<li><a href="<?= site_url('/backend/commandes/filter/waiting_by_me') ?>">En attente</a></li>
	<li><a href="<?= site_url('/backend/commandes/filter/waiting_for_me') ?>">A gerer</a></li>
	<li><a href="<?= site_url('/backend/commandes/filter/delivered') ?>">gerer</a></li>
	<li><a href="<?= site_url('/backend/commandes/filter/received') ?>">Recues</a></li>
</ul>

<ul id="dropdown2" class="dropdown-content">
<?php	
	$id = $this->session->userdata('user_id');
	if($this->ion_auth->is_admin()){
?>
 	<li><a href="<?= site_url('/auth/') ?>">Users</a></li>
<?php
	}
?>
<!--
  <li><a href="<?= site_url('/auth/prof/'.$id) ?>">Profil</a></li>
-->
  <li><a href="<?= site_url('/auth/change_password') ?>">Mot de passe</a></li>
  <li><a href="<?= site_url('/auth/logout') ?>">Logout</a></li>
</ul>
</div>

<?php
	if(!isset($hide_alert) && $this->ion_auth->in_group(array('pharmacie','partenaire','regionsante','zonesante')) && get_warning(true)){
?>
<div class="row">
	<div class="col s12">
		<div class="center card red darken-1">
			<h1><a href="<?= site_url('/backend/alertes') ?>">Controler votre stock</a></h1>
		</div>	
	</div>	
</div>	
<?php
	}
?>	

