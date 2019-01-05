<html>
<head>
<?php
	include_once(APPPATH.'/views/head.php');
?>
<script type="text/javascript">
$(document).ready(function(){
	$("#educateur").on('change',function(){
		var datas = {
			"id":<?= $infos['id'] ?>,
			"educateur" : $(this).val()
		}
		$.post('<?= site_url('/backend/pvv/educateur') ?>',datas,function(){
		});
	});
});
</script>
</head>
<body>
<?php
	include_once(APPPATH.'/views/menu.php');
?>
<main>
<div class="container">
<h2>Profil PVV</h2>
<div class="row">

	<div class="col s6">
		<table>
<?php

	foreach($infos as $k => $v){
		echo '<tr>';
		echo "<th>$k</th>";
		if($k == "id") continue;
		
		$edus = get_educateurs();
		if($k == "educateur"){

			echo "<td>";
			if($this->ion_auth->in_group(array('agent'))){
				echo '<select id="educateur">';
				echo '<option value="'.$v.'">';
				echo (!empty($v))? $edus[$v]:'';
				echo '</option>';
				foreach($edus as $kk => $vv){
					echo '<option value="'.$kk.'">'.$vv.'</option>';
				}
				echo '</select>';
			}else{
				echo (!empty($v))? $edus[$v]:'';
			}
			echo "</td>";
		}else{
			echo "<td>".$v."</td>";
		}
		echo '</tr>';
	}
?>
		</table>
		<h5>Ordonnances</h5>
		<?php	
			echo lgedit_generate_table('ordonnances',$ordonnances['datas'],$ordonnances['options']);
		?>
	</div>
	<div class="col s6">
		<h5>Observations</h5>
		<form method="POST" action="<?= site_url('/backend/pvv/note') ?>">
		<input type="hidden" name="id" value="<?= $infos['id'] ?>"/>
		<textarea id="observation" name="observation"></textarea>
		<input class="btn" type="submit" value-"envoyer">
		</form>
		<ul class="collection">
<?php
		foreach($observations as $o){
?>
      <li class="collection-item"><?= $o['created'] ?> - <?= $o['observation'] ?></li>
<?php
		}
?>
		</ul>
			
	</div>
</div>



</div>
</main>
</body>
</html>
