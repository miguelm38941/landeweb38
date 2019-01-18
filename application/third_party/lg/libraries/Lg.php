<?php

class Lg {

    var $context;
    var $cookie;
    var $headers;

    function __construct(){
        $CI =& get_instance();
		$CI->load->config('lgedit');
		$CI->load->helper('lgedit');
		$CI->load->model('mlg');
	}

	function set_data($table,$id,$datas,$replace=false){
        $CI =& get_instance();
		return $CI->mlg->set_table_data($table,$id,$datas,$replace);
	}

	function fetch_datas($table,$filters=array(),$metadatas=false){
		/*if($table=='ordonnances'){
			var_dump($user['username']);
		}*/
        $CI =& get_instance();
		$datas = $CI->mlg->get_table_datas($table,$filters,$metadatas,$exists);
		if($exists){ 
			$res = $this->_filter($datas,$filters,$metadatas);
			return $res;
		}else{ 
			return $datas;
		}
	}

	function get_datas($table,$filters=array(),$metadatas=false){
		/*if($table=='ordonnances'){
			var_dump($user['username']);
		}*/
        $CI =& get_instance();
		$datas = $CI->mlg->get_table_datas($table,$filters,$metadatas,$exists);
		if(!$exists){ 
			$res = $this->_filter($datas,$filters,$metadatas);
			return $res;
		}else{ 
			return $datas;
		}
	}
	
	function get_device($sn){
		$CI =& get_instance();
		return $CI->mlg->get_device($sn);
	}
	
	function get_finger($username){
		$CI =& get_instance();
		$user = $CI->mlg->get_user_by_username($username);
		$pvv=$this->get_data('pvv',array('username' => $username));
		return $CI->mlg->get_finger($pvv['id']);
	}
	
	function count_finger($pvvid){
		$CI =& get_instance();
		return $CI->mlg->get_finger_count($pvvid);
	}
	
	function get_user_by_entityid($entityid){
		$CI =& get_instance();
		return $CI->mlg->get_user_by_entityid($entityid);
	}
	
	function get_user_by_username($username){
		$CI =& get_instance();
		return $CI->mlg->get_user_by_username($username);
	}
	
	function get_max_finger($user_id){
		$CI =& get_instance();
		return $CI->mlg->get_max_finger($user_id);
	}
	
	function get_user($id){
		$CI =& get_instance();
		return $CI->mlg->get_user($id);
	}
	
	function get_user_company($prepose_id){
		$CI =& get_instance();
		$prepose = isset($prepose_id) ? $this->get_user($prepose_id):'';
		$pharmacie=$this->get_data('pharmacie',array('id' => $prepose['company']),true);
		return $pharmacie['nom'];
	}

	function get_company($id){
		$CI =& get_instance();
		$company = $CI->mlg->get_organisation($id);
		return json_decode($company['datas']);
	}

	function get_current_user_or_company_id(){
		$CI =& get_instance();
		if ($CI->ion_auth->in_group(array('pharmacie'))) {
			$cid = $CI->session->userdata('organisation');
			//$pharmacie=$CI->lg->get_data('pharmacie',array('id'=>$cid),true);	
			return $cid;
		}else {
			$uid = $CI->session->userdata('organisation');
			return $uid;
		}
	}

	function get_data($table,$filters=array(),$metadatas=false){
        $CI =& get_instance();
		$datas = $CI->mlg->get_table_datas($table,$filters,$metadatas,$exists);
		//var_dump($filters); exit;
		if(!$exists){
			$res = $this->_filter($datas,$filters,$metadatas);
			return count($res) > 0 ? $res[0] : false;
		}else{
			return $datas[0];
		}
	}

	function _filter($datas,$filters,$metadatas=false){
		//print_r($datas);
		$res=array();
		foreach($datas as $d){
			$r = json_decode($d['datas'],true);
			$r['id']=$d['id'];
			if($metadatas){
				$r['user']=$d['user'];
				$r['created']=$d['created'];
				$r['updated']=$d['updated'];
			}
			$add=true;

			foreach($filters as $k => $v){
				if(!is_array($v)){
					if(in_array($v,array('isset','!isset'))){
						//echo 0;
						if($v == "isset" && !isset($r[$k])){
							$add=false;
						//	echo 1;
						}else if($v == "!isset" && isset($r[$k])){
							$add=false;
						//	echo 2;
						}
					}else{
						if(!isset($r[$k]) ||  $r[$k] != $v){
							$add=false;
						}
					}
				}else if(!isset($r[$k]) || ( is_array($v) && !in_array($r[$k],$v))){
					$add=false;
				}
			}			

			if($add){
				$res[]=$r;
			}
		}
		//echo "<pre>";
		//print_r($res);
		//return $res;	
		return array_values($res);	
	}
}

?>
