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
	
	function get_user($id){
		$CI =& get_instance();
		return $CI->mlg->get_user($id);
	}
	
	function get_data($table,$filters=array(),$metadatas=false){
        $CI =& get_instance();
		$datas = $CI->mlg->get_table_datas($table,$filters,$metadatas,$exists);
		//var_dump($datas);
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
