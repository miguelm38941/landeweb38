<?php

function lgedit_add_url($table){
	return site_url('/lgedit/add/'.$table);
}

function lgedit_generate_cards($t,$datas=array(),$links=false){
	$CI =& get_instance();
	$CI->load->config('lgedit');

	$tables = $CI->config->item('lgedit_tables');
	if(!isset($tables[$t])) return "table doesnt exists";

	$table = $tables[$t];

	$html ="<div data-table='$t' class='lgedit_cards row'>";

	foreach($datas as $data){

	$color = isset($data['ccolor']) ? $data['ccolor'] : 'blue-grey darken-1';
	$html .= "<div class='col s12 m6 l4'>";
	$html .= '<div class="card '.$color.' darken-3" data-id="'.$data['id'].'".>
            <div class="card-content white-text">
              <span class="card-title">'.$data['ctitle'];

	if(isset($data['creveal']) && !empty($data['creveal'])){
		$html.='<i class="material-icons right activator">more_vert</i>';
	}
	$html.='</span>
            	<p>'.$data['ccontent'].'</p>
			</div>';
	
	if(isset($data['creveal']) && !empty($data['creveal'])){
		$html.='<div class="card-reveal">
      <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
      <p>'.$data['creveal'].'</p></div>';

	};
    $html .='<div class="card-action">
              <a class="copy" data-id="'.$data['id'].'" href="#">COPY</a>
              <a class="delete" data-id="'.$data['id'].'" href="#">DEL</a>';

    //$html .='<a href="'.site_url($link[1].$data['id']).'">'.$link[0].'</a>';
    
	foreach($links as $lk => $lv){
		$html .='<a href="'.site_url($lv.$data['id']).'">'.$lk.'</a>';
	}
    $html .='</div></div>';
	$html .= "</div>";
	}

	$html .= "</div>";
	return $html;	
	
}

function lgedit_table_option($options){

	$opt['can_edit']=isset($options['can_edit']) ? $options['can_edit'] : true; 
	$opt['can_delete']=isset($options['can_delete']) ? $options['can_delete'] : true; 
	$opt['can_copy']=isset($options['can_delete']) ? $options['can_delete'] : true; 
	$opt['btn_ordonnances']=isset($options['btn_ordonnances']) ? $options['btn_ordonnances'] : false; 
	$opt['links']=isset($options['links']) ? $options['links'] : false;
	$opt['buttons']=isset($options['buttons']) ? $options['buttons'] : false;
	$opt['dbclick']=isset($options['dbclick']) ? $options['dbclick'] : false;
	$opt['hide_columns']=isset($options['hide_columns']) ? $options['hide_columns'] : array();
	$opt['columns']=isset($options['columns']) ? $options['columns'] : array();

	return $opt; 
}


function lgedit_generate_table($t,$datas=array(),$options=array()){

	$CI =& get_instance();
	$CI->load->config('lgedit');

	$tables = $CI->config->item('lgedit_tables');
	if(!isset($tables[$t])) return "table doesnt exists";

	$opt = lgedit_table_option($options);
	$table = $tables[$t];

	$table['fields']  = array_merge($table['fields'],$opt['columns']);

	$html = "<div class='lgedit_table' data-table=\"$t\">";
	$html .= '
		<form>
        <div class="input-field">
          <input id="lgedit_search" type="search" />
          <label for="lgedit_search"><i class="material-icons">search</i></label>
        </div>
      </form>

	';
	$html .= "<table class='highlight'>";
	$html .= "<thead>";
	$html.='<tr>';
	foreach($table['fields'] as $k => $v){
		$l = isset($v['label']) ? $v['label'] : $k;
		//$c = isset($v['table_hide']) ? 'hide' : ''; 
		$c = in_array($k,$opt['hide_columns']) ? "hide" : "";
		$html.="<th class='$c'>$l</th>";
	}
	/*
	if(is_array($opt['buttons']) && !empty($opt['buttons'])){
		$html.="<th width='100px'></th>";
	}
	if(is_array($opt['links']) && !empty($opt['links'])){
		$html.="<th width='100px'></th>";
	}
	if($opt['can_edit'] || $opt['can_copy'] || $opt['can_delete']){
		$html.="<th width='100px'></th>";
	}*/
	$html.="</tr>";
	$html .= "</thead>";
	$html .= "<tbody>";

	foreach($datas as $d){

		$ccolor = '';
		if(isset($d['ccolor'])){
			$ccolor = $d['ccolor']." lighten-3";
		}

		$dblclick = $opt['dbclick'] ? site_url($opt['dbclick']."/".$d[$table['id']]) : "";  
		
		$html.='<tr data-id="'.$d[$table['id']].'" class="'.$ccolor.'" data-dblclick="'.$dblclick.'">';
		foreach($table['fields'] as $kk => $vv){

			$val = isset($d[$kk]) ? $d[$kk] : "";
			$dvals='';
			if(in_array($vv['type'],array('select','select_multi','checkboxs'))){
			
				$vals = $vv['values'];
				if(!is_array($vals)){
					$vals = call_user_func($vals,'all');
				}

				$json_val = json_encode($vals);
				$multi = in_array($vv['type'],array('select_multi','checkboxs')) ? true : false;
				$dvals = "data-values='".$json_val."' data-real='$val' data-multi=$multi";

				if($multi){
					$nval=json_decode($val,true);
					if($nval){
						$val=array();
						foreach($nval as $v){
							$val[] = isset($vals[$v]) ? $vals[$v] : ''; 	
						}
						$val = implode(",",$val);
					}
				}else{
					$val = isset($vals[$val]) ? $vals[$val] : '';
				}
			}

			//$c = isset($vv['table_hide']) ? 'hide' : ''; 
			$c = in_array($kk,$opt['hide_columns']) ? "hide" : "";

			$html .= "<td data-name='$kk' class='$c' $dvals>";
			$html .= $val;
			$html .= "</td>";
		}

		if(is_array($opt['buttons']) && !empty($opt['buttons'])){
			$html .= "<th style='width:100px' class='buttons'>";
			foreach($opt['buttons'] as $k => $v){
				$html .= '<span><a class="btn" href="'.site_url($v."/".$d[$table['id']]).'">'.$k.'</a></span>';
			}
			$html .= "</th>";
		}
		
		if(is_array($opt['links']) && !empty($opt['links'])){
			$html .= "<th style='width:100px' class='links center'>";
			foreach($opt['links'] as $k => $v){
				$html .= '<span><a href="'.site_url($v."/".$d[$table['id']]).'" <i class="material-icons dp48">'.$k.'</i></a></span>';
			}
			$html .= "</th>";
		}
		

		if($opt['can_edit'] || $opt['can_copy'] || $opt['can_delete'] || $opt['btn_ordonnances']){
			$html .= "<th style='width:100px' class='actions'>";
			if($opt['can_edit']){
				$html .= "<span><i class=\"material-icons dp48 edit\">edit</i></span>";
			}
			if($opt['can_copy']){
				$html .= "<span><i class=\"material-icons dp48 copy\">add</i></span>";
			}
			if($opt['can_delete']){
				$html .= "<span><i class=\"material-icons dp48 delete\">delete</i></span>";
			}
			if($opt['btn_ordonnances']){
				$html .= "<span><i class=\"material-icons dp48 edit\">Ordonnances</i></span>";
			}
		}
		$html .= "</th>";
		$html.="</tr>";
	}
	$html .= "</tbody>";
	$html .="</table>";
	$html .= "</div>";

	return $html;
}

function lgedit_generate_form($t,$values=array(),$update=false){
	$CI =& get_instance();
	$CI->load->config('lgedit');

	$tables = $CI->config->item('lgedit_tables');
	if(!isset($tables[$t])) return "table doesnt exists";

	$table = $tables[$t];

	//$v = $visible ? '' : 'hide';
	$v = '';
	$html = "<div id='lgedit_form' class='".$v."'>";

	$html .= "<form action='#' method='POST' data-table=\"$t\">";	
	foreach($table['fields'] as $k => $v){
		if($k == $table['id']) continue;

		$l = isset($v['label']) ? $v['label'] : $k;
		$val = isset($values[$k]) ? $values[$k] : '';
		$r = isset($v['required']) ? 'required' : '' ;
		$c = isset($v['form_hide']) ? 'hide' : ''; 

		$bd = isset($v['browser-default']) && $v['browser-default'] ? 'browser-default' : ''; 
		$html .= '<div class="row '.$c.'">';
	
		if($v['type'] == "select" || $v['type'] == "select_multi"){
		
			$m = $v['type'] == "select_multi" ? 'multiple' : '';
		
	        $html.='<div class="input-field col s12">
				<select id="lgedit_'.$k.'" name="'.$k.'" class="validate '.$bd.'" '.$r.' '.$m.'>';

			$vals = $v['values'];
			if(!is_array($vals)){
				$vals = call_user_func($vals);
			}
			if($val && !is_array($val) && isset($vals[$val])){
				$html.='<option value="'.$val.'" selected>'.$vals[$val].'</option>';
			}else{
				$html.='<option value="" disabled selected>'.$l.'</option>';
			}

			if(isset($v['opt']) && $v['opt']){
				foreach($vals as $kk => $vv){
					$html .="<optgroup label=\"$kk\">";
					foreach($vv as $kkk => $vvv){
      					$html .='<option value="'.$kkk.'">'.$vvv.'</option>';
					}
					$html .="</optgroup>";
				}
			}else{
				foreach($vals as $kk => $vv){
      				$html .='<option value="'.$kk.'">'.$vv.'</option>';
				}
			}

			$html .='</select>';
          	$html .='<label for="lgedit_'.$k.'">'.$l.'</label>';
			$html .='</div>';

		}else if($v['type'] == "checkboxs"){
			$vals = $v['values'];
			if(!is_array($vals)){
				$vals = call_user_func($vals);
			}
			$col = isset($v['cols']) ? 12/$v['cols'] : 12;
			$html .= "<h5>$l</h5>";

			foreach($vals as $kk => $vv){
				$checked = is_array($val) && in_array($kk,$val) ? 'checked' : '';
				$html.="<div class='col s$col'>";
				$html.='<input id="checkbox'.$k.$kk.'" type="checkbox" name="'.$k.'[]" value="'.$kk.'" '.$checked.'/>';
				$html.='<label for="checkbox'.$k.$kk.'">'.$vv.'</label>';
				$html.="</div>";
			}

		}else if($v['type'] == "textarea"){
			$html .= '<div class="input-field col s12">';
			$html.="<textarea id='lgedit_$k' class='materialize-textarea' name='$k'>$val</textarea>";
			$html.='<label for="legedit_'.$k.'">'.$l.'</label>';
			$html .= "</div>";
		
		}else if($v['type'] == "list"){
			$html .= "<label>$l</label>";
			$html .= "<div class='row list-items'>";

			$val = json_decode($val,true);

			if(is_array($val)){
				foreach($val as $vval){
					$html .= "<div class='row list-item'>";
					foreach($v['values'] as $kkk => $vvv){
						$html .= "<div class='col'>";
						if($vvv['type'] != "select"){
							$html .= "<input type='".$vvv['type']."' name='{$k}_{$kkk}[]' value='{$vval[$kkk]}' placeholder='".$vvv['label']." required'/>";
						}else{
							$html .= "<select class='browser-default' name='{$k}_{$kkk}[]' required>";
							if(!is_array($vvv['values'])){
								$vvals = call_user_func($vvv['values']);
							}
							$html .= '<option value="'.$vval[$kkk].'">'.$vvals[$vval[$kkk]].'</option>';
							foreach($vvals as $kkkk => $vvvv){
								$html .= '<option value="'.$kkkk.'">'.$vvvv.'</option>';
							}
							$html .= '</select>';	

						}
						$html .= '</div>';	
					}
					$html .= "<div class='col'>";
					$html .= '<a class="btn btn-del-list-item"><i class="material-icons">delete</i></a>';
					$html .= '</div>';	
					$html .= '</div>';	
				}
			}else{
				$html .= "<div class='row list-item'>";
				foreach($v['values'] as $kkk => $vvv){
					$html .= "<div class='col'>";
					if($vvv['type'] != "select"){
						$html .= "<input type='".$vvv['type']."' name='{$k}_{$kkk}[]' placeholder='".$vvv['label']." required'/>";
					}else{
						$html .= "<select class='browser-default' name='{$k}_{$kkk}[]' required>";
						if(!is_array($vvv['values'])){
							$vvals = call_user_func($vvv['values']);
						}
						foreach($vvals as $kkkk => $vvvv){
							$html .= '<option value="'.$kkkk.'">'.$vvvv.'</option>';
						}
						$html .= '</select>';	
					}
					$html .= '</div>';	
				}
				$html .= "<div class='col'>";
				$html .= '<a class="btn btn-del-list-item"><i class="material-icons">delete</i></a>';
				$html .= '</div>';	
				$html .= '</div>';
			}

			$html .= '<a class="btn-floating btn-add-list-item"><i class="material-icons">add</i></a>';
			$html .= '</div>';
		}else{
			$c1 = $v['type'] == "date" ? 'datepicker' : '';
			
			$t = 'text';
			switch($v['type']){
				case 'date':
					$t = 'text';
					if(!$val || empty($val)){
						$val = date('Y-m-d');
					}
					break;
				default:
					$t = $v['type'];
			
			}

			
			$html .= '<div class="input-field col s12">
          			<input id="lgedit_'.$k.'" name="'.$k.'" type="'.$t.'" class="validate '.$c1.'" value="'.$val.'" '.$r.'/>
          	 		<label for="lgedit_'.$k.'">'.$l.'</label>
        		</div>';
		}

		$html .="</div>";
	}

	$html .= '<div class="row">
		<button class="btn waves-effect waves-light" type="submit" name="action">'.($update ? 'Modifier' : 'Ajouter' ).'
  		</button>
		<button class="btn waves-effect waves-light" type="reset" name="action">Reset
  		</button>
	</div>';

	$html .= "</form>";
	$html .= "</div>";

	return $html;	
}

?>
