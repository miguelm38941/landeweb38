<html>
<head>
<?php
	include_once(APPPATH.'/views/head.php');
?>
<script type="text/javascript">

$(document).ready(function(){
	$("#educateur").on('change',function(){
		var datas = {
			"id":"<?= $infos['id'] ?>",
			"educateur" : $(this).val()
		}
		$.post('<?= site_url('/backend/pvv/educateur') ?>',datas,function(){
		});
	});

	$("#medecin").on('change',function(){
		if($(this).val()!=''){
			var datas = {
				"id": $("#id_consultation").val(),
				"pvv" : "<?= $infos['id'] ?>",
				"agent" : "<?= isset($consultation) ? $consultation['agent'] : '' ?>",
				"medecin" : $(this).val(),
				"infirmier" : "<? if(isset($consultation['infirmier'])){ echo $consultation['infirmier']; } ?>",
				"etat" : 'En attente',
			}
			$.post(window.base_url+'/lgedit/add/consultation',datas,function(data){
				var selected_id = $("#medecin").val();
				var selected_name = $("#medecin .option"+selected_id).text();
				Materialize.toast(selected_name+' a été attribué pour la consultation', 5000);
				$("#medecin_choisi span").html(selected_name);
			}).fail(function(){
				Materialize.toast('Echec attribution de la consultation', 3000);
			});
		}
	});

	$("#infirmier").on('change',function(){
		if($(this).val()!=''){
			var datas = {
				"id": $("#id_consultation").val(),
				"pvv" : "<?= $infos['id'] ?>",
				"agent" : "<?= isset($consultation) ? $consultation['agent'] : '' ?>",
				"medecin" : "<? if(isset($consultation['medecin'])){ echo $consultation['medecin']; } ?>",
				"infirmier" : $(this).val(),
				"etat" : 'En attente',
			}

			$.post(window.base_url+'/lgedit/add/consultation',datas,function(data){
				var selected_id = $("#infirmier").val();
				var selected_name = $("#infirmier .option"+selected_id).text();
				Materialize.toast(selected_name+' a été attribué pour la prise des constantes', 5000);
				$("#infirmier_choisi span").html(selected_name);
			}).fail(function(){
				Materialize.toast('Echec attribution de la consultation', 3000);
			});
		}
	});
});
</script>

    <script language="JavaScript">

			function user_delete(user_id, user_name) {

				var r = confirm("Delete user "+user_name+" ?");

				if (r == true) {

					push('user.php?action=delete&user_id='+user_id);

				}
			}
			
			function user_register(user_id, user_name) {
				
				//$('body').ajaxMask();
			
				regStats = 0;
				regCt = -1;
				try
				{
					timer_register.stop();
				}
				catch(err)	
				{
					console.log('Registration timer has been init');
				}
				
				
				var limit = 4;
				var ct = 1;
				var timeout = 5000;
				
				timer_register = $.timer(timeout, function() {					
					console.log("'"+user_name+"' registration checking...");
					//console.log("count : "+$("#user_finger").html());
					user_checkregister(user_id,$("#user_finger").html());
					if (ct>=limit || regStats==1) 
					{
						timer_register.stop();
						console.log("'"+user_name+"' registration checking end");
						if (ct>=limit && regStats==0)
						{
							alert("'"+user_name+"' Echec de l\'enregistrement!");
							//$('body').ajaxMask({ stop: true });
						}						
						if (regStats==1)
						{
							$("#user_finger").html(regCt);
							alert("'"+user_name+"' Enregistrement reussi!");
							//$('body').ajaxMask({ stop: true });
							//load('user.php?action=index');
						}
					}
					ct++;
				});
			}
			
			function user_checkregister(user_id, current) {
				console.log("backend/fingerprint/checkreg?user_id="+user_id+"&current="+current);
				var baseurl = "<?php echo base_url(); ?>";
				$.ajax({
					url			:	baseurl+"backend/fingerprint/checkreg?user_id="+user_id+"&current="+current,
					type		:	"GET",
					success		:	function(data)
									{
										console.log(data);
										try
										{
											var res = jQuery.parseJSON(data);	
											if (res.result)
											{
												regStats = 1;
												$.each(res, function(key, value){
													if (key=='current')
													{			
														regCt = value;
													}
												});
											}
										}
										catch(err)
										{
											alert(err.message);
										}
									}
				});
			}

</script>
</head>
<body>
<div class="wrapper">
<?php
	include_once(APPPATH.'/views/menu.php');
?>
<main>
<div class="container">
<h2>Profil PVV</h2>
<br>
<div class="row">
	<div class="col s6">
	<?php	
	if(!isset($consultation) || empty($consultation)){
	?>
		<div style="display:inline-block;">
			<img src="../../../images/qrcode.png"  style="width:80px;" />
			<br>
		<a style="color:#000;font-weight:bold;border:1px solid #333;padding:5px;" href="<?php echo str_replace('index.php', '', $_SERVER['PHP_SELF']); ?>backend/profile_pvv/<?php echo $infos['id']; ?>/qrprint">
			Imprimer le Code QR
		</a>
		</div>
		<div style="display:inline-block;">
			<img src="../../../images/fingerprint.jpg"  style="width:80px;" />
			<br>
		<?php 		
//backend/fingerprint/fverify class='btn btn-xs btn-primary'
			$user_id = $infos['id'];
			$register = ''; 
			$verification = '';
			//if():
				//echo base_url()."backend/fingerprint/fregister/".$user_id; exit;
				$register			= '';
				$verification		= '';
				$url_register		= base64_encode(base_url()."backend/fingerprint/fregister/".$user_id);
				//$url_register		= base64_encode('http://landela.org/register.php?user_id=63');
				$url_verification	= base64_encode(base_url()."backend/fingerprint/fverify/".$user_id);
				
				if(isset($finger) && count($finger) > 0) {

					$verification = "<a style='color:#000;font-weight:bold;border:1px solid #333;padding:5px;margin-left: 10px;text-align: center;' href='finspot:FingerspotVer;$url_verification'>V&eacute;rifier l'identit&eacute;</a>";
					echo $verification;
				} else {
					
					$register = "<a style='color:#000;font-weight:bold;border:1px solid #333;padding:5px;margin-left: 10px;text-align: center;' href='finspot:FingerspotReg;$url_register' onclick=\"user_register('".$user_id."','".$infos['username']."')\">Enregistrer l'empreinte</a>";
					echo $register;
				}
			//endif;

		?>
		
		</div>
		<div><code id="user_finger" style="visibility: hidden;"><?php if(isset($finger) && is_object($finger)){ echo count($finger);}else{echo '0';} ?></code></div>
		<br><br>
	<?php	
	}
	?>
		<table>
		<?php

			foreach($infos as $k => $v){
				echo '<tr>';
				if($k == "id") continue;
				if($k == "username") continue;
				if($k == "password") continue;
				if($k == "password_confirm") continue;
				if($k == "validate") continue;
				if($this->ion_auth->in_group(array('agent','infirmier')) && (($k == "nom") || ($k == "prenom") || ($k == "cnib") || ($k == "adresse") || ($k == "telephone") || ($k == "email"))) continue;
				echo "<td>".ucfirst($k)."</td>";
				
				$v = ($k == "regionsante") ? get_single_entity_name("regionsante",$v) : $v;
				$v = ($k == "zonesante") ? get_single_entity_name("zonesante",$v) : $v;

				$edus = get_educateurs();
				if($k == "educateur"){
					echo "<td>";
					if($this->ion_auth->in_group(array('agent'))){
						echo '<select id="educateur">';
						echo '<option value="'.$v.'">';
						echo (isset($edus[$v]) && !empty($v))? $edus[$v]:'';
						echo '</option>';
						foreach($edus as $kk => $vv){
							echo '<option value="'.$kk.'">'.$vv.'</option>';
						}
						echo '</select>';
					}else{
						echo (!empty($v) && ($v!='tocheck') && isset($edus[$v]))? $edus[$v]:'';
					}
					echo "</td>";
				}else{
					echo "<td>".$v."</td>";
				}
				echo '</tr>';
			}
		?>
		</table>
	</div>

	<?php	
	if(isset($consultation) && !empty($consultation)){
	?>
		<div class="col s6">
		<?php if($this->ion_auth->in_group(array('medecin','infirmier'))){ ?>
			<h5>Consultation du : <?php echo isset($consultation['created'])?$consultation['created']:date('d/m/Y'); ?></h5>
			<?php if(isset($constantes) && !empty($constantes)){ ?>
				<div class="col s12">
					<div class="col s6" style="border-bottom:1px solid #eee;padding-bottom:20px;">
						Temp&eacute;rature: <?php echo $constantes['temp']; ?><br> 
						Poids: <?php echo $constantes['poids']; ?><br>
						Tension: <?php echo $constantes['tension']; ?><br>
						Indice de Masse Corporelle (IMC): <?php echo $constantes['masse_corp']; ?><br>
						Pouls: <?php echo $constantes['pouls']; ?>
					</div>
					<div class="col s6" style="border-bottom:1px solid #eee;padding-bottom:20px;">
						Taille: <?php echo $constantes['taille']; ?><br>
						PB: <?php echo $constantes['pb']; ?><br>
						P&eacute;rim&egrave;tre Cranien (PC): <?php echo $constantes['perimetre_cranien']; ?><br>
						Charge virale: <?php echo $constantes['charge_virale']; ?>
					</div>
				</div>
			<?php }else{ ?>
				<?php if(!$this->ion_auth->in_group(array('medecin'))){ ?>
					<a style="padding:3px 5px; background-color:rgb(185,36,54);" href="<?= site_url('/lgedit/addPage/constante/pvv_c/') ?><?= $infos['id'] ?>_<?= $consultation['id'] ?>">Cliquer ici pour prendre les constantes</a>
				<?php } ?>
			<?php } ?>
			<?php if(!$this->ion_auth->in_group(array('infirmier'))){ ?>
			<div style="margin:20px 0;border-bottom:1px solid #eee;padding-bottom:20px;">
				<?php
				//echo $latestOrdonnance['consultation'].' ----- '.$consultation['id']; exit;	
				if(isset($latestOrdonnance['consultation']) && ($latestOrdonnance['consultation']==$consultation['id'])){?>
					<a style="padding:3px 5px; background-color:rgb(185,36,54); display: inline-block;" href="<?= site_url('/backend/ordonnances/show/') ?><?= $latestOrdonnance['id'] ?>">Voir l'ordonnance pour cette consultation</a><?php
				}else{?>
					<a style="padding:3px 5px; background-color:rgb(185,36,54); display: inline-block;" href="<?= site_url('/lgedit/addPage/ordonnances/pvv_c/') ?><?= $infos['id'] ?>_<?= $consultation['id'] ?>">R&eacute;diger une ordonnance</a>&nbsp;&nbsp;&nbsp;<?php
				}
				?><a style="padding:3px 5px; background-color:rgb(185,36,54); display: inline-block;" href="<?= site_url('/lgedit/addPage/prescription_examens?pvv='.$infos['id'].'&cons='.$consultation['id']) ?><?= $infos['id'] ?>_<?= $consultation['id'] ?>">Prescrire des examens</a>
				<br><br>
				<a style="padding:3px 5px; background-color:rgb(185,36,54); display: inline-block;" href="<?= site_url('/backend/resultat_examens/?selected_pvv='.$infos['id']) ?>">R&eacute;sultats d'examens</a>&nbsp;&nbsp;&nbsp;<?php
				if($consultation['etat']=='done'){?>
					<a style="padding:3px 5px; background-color:#333;">Consultation close</a><?php
				}else{?>
					<a style="padding:3px 5px; background-color:rgb(185,36,54);" href="<?= site_url('/lgedit/add/consultation/?consultid=') ?><?= $consultation['id'] ?>&pvv=<?= $infos['id'] ?>">Terminer cette consultation</a><?php
				}
				?>
			</div>
			<?php } ?>
		<?php }elseif($this->ion_auth->in_group(array('agent'))){ ?>
			<h5>Consultation du <?php echo date('d/m/Y'); ?></h5>
			<?php	
			echo '<input id="id_consultation" type="hidden" value="'.$consultation['id'].'" >';
			$medecins = get_medecins(); //var_dump($medecins); exit;
			if($this->ion_auth->in_group(array('agent')) || $this->ion_auth->in_group(array('medecin'))){
				echo '<select id="medecin">';
				echo '<option value="">S&eacute;lectionner un m&eacute;decin</option>';
				foreach($medecins as $kk => $vv){
					echo '<option ';
					echo ($consultation['medecin']==$kk) ? 'selected' : '';
					echo ' class="option'.$kk.'" value="'.$kk.'">'.$vv.'</option>';
				}
				echo '</select>';
				echo '<br>';
			$infirmiers = get_infirmiers(); //var_dump($medecins); exit;
				echo '<select id="infirmier">';
				echo '<option value="">S&eacute;lectionner un infirmier</option>';
				foreach($infirmiers as $kk => $vv){
					echo '<option ';
					echo (isset($consultation['infirmier']) && ($consultation['infirmier']==$kk) ) ? 'selected' : '';
					echo ' class="option'.$kk.'" value="'.$kk.'">'.$vv.'</option>';
				}
				echo '</select>';
			}
			?>
			<div style="margin-top:20px;border-top:1px solid #eee;padding-top:20px;display:inline-block;" id="date">Date : <?php echo date('d m Y'); ?></div>
			
			<div style="margin-top:20px;border-top:1px solid #eee;padding-top:20px;display:inline-block;" id="date"><?php echo '&nbsp;&nbsp;'; ?>Heure : <?php echo date('h:i'); ?></div>
		<?php } ?>
		</div>
	<?php
	}
	?>


	<div class="col s6">
		<?php	
			if(!empty($ordonnances)){
			?>
			<h5>Ordonnances</h5>
			<?php
				echo lgedit_generate_table('ordonnances',$ordonnances['datas'],$ordonnances['options']);
			}
		?>
	</div>

	<div class="col s6" style="margin-top:40px;background-color:#eee;">
		<?php if($this->ion_auth->in_group(array('agent','medecin','educateur'))){ ?>
			<h5>Observations</h5>
			<form method="POST" action="<?= site_url('/backend/pvv/note') ?>">
				<input type="hidden" name="id" value="<?= $infos['id'] ?>"/>
				<?php 
				if($this->ion_auth->in_group(array('medecin'))){ 
					$id_consultation=$consultation['id']; 
				}else{ 
					$id_consultation=''; 
				}
				?>
				<input type="hidden" name="id_consultation" value="<?= $id_consultation ?>"/>
				<textarea id="observation" name="observation" style="background-color:#ffffff;"></textarea>
				<input class="btn" type="submit" value-"envoyer">
			</form>
			<?php	
				if(!empty($observations)){
				?>
					<ul class="collection">
					<?php
					foreach($observations as $o){
						?>
						<li class="collection-item"><?= $o['created'] ?> - <?= $o['observation'] ?></li>
						<?php
					}
					?>
					</ul>
				<?php
				}
			?>
		<?php } ?>	
	</div>
			
</div>


</div>
</main>
</div>
<?php include_once(APPPATH.'/views/footer.php'); ?>
</body>
</html>
