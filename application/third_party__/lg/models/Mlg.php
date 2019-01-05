<?php

class Mlg extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	function set_table_data_normal($table,$id,$datas,$replace=false){
		$res=false;
		if(is_numeric($id)){
			$this->db->where('id',$id);
			$res = $this->db->get($table)->row_array();
		}
		
		if($res){
			if($replace){
				$this->db->where('id',$id);
				$this->db->delete($table);
				$this->db->insert($table,$datas);
				return $this->db->insert_id();
			}else{
				$this->db->where('id',$id);
				$this->db->update($table,$datas);
			}
		}else{
			$this->db->insert($table,$datas);
			return $this->db->insert_id();
		}
						
	}
	
	function set_table_data($table,$id,$datas,$replace=false){
		$CI =& get_instance();
		if($this->db->table_exists($table)){
			return $this->set_table_data_normal($table,$id,$datas,$replace);
		}

		$user=0;
		if(isset($CI->session)){
			$uid = $CI->session->userdata('user_id');	
			if(is_numeric($uid)){
				$user=$uid;
			}	
		}

		$res=false;
		if(is_numeric($id)){
			$this->db->where('id',$id);
			$this->db->where('table_name',$table);
			$res = $this->db->get('lg_datas')->row_array();
		}
		if($res && !empty($res)){
			if(!$replace){
				$old = json_decode($res['datas'],true);
				$datas=array_merge($old,$datas);
				$datas = json_encode($datas,JSON_PRETTY_PRINT);	
			}
			$this->db->where('id',$id);
			$this->db->where('table_name',$table);
			$this->db->update('lg_datas',array('datas' => $datas));
			$this->db->insert('lg_datas_log',array('table_name' => $table, 'user' => $user , 'operation' => 'MOD', 'new_datas' => $datas, 'old_datas' => json_encode($old)));
			return $this->db->insert_id();	
		}else{
			$this->db->insert('lg_datas',array('table_name'=> $table,'user' => $user,'datas' => json_encode($datas), 'created' => date('Y-m-d H:i:s')));
			$this->db->insert('lg_datas_log',array('table_name' => $table, 'user' => $user , 'operation' => 'ADD', 'new_datas' => json_encode($datas), 'old_datas' => ''));
			return $this->db->insert_id();	
		}
	}

	function get_table_datas($table,$filters=array(),$metadatas=false,&$exists=false){
		
		if(isset($filters['id'])){
			if(is_array($filters['id'])){ 
				$this->db->where_in('id',$filters['id']);
			}else{
				$this->db->where('id',$filters['id']);
			}
		}
		
		$ord = isset($GLOBALS['lg_order_by']) ?  $GLOBALS['lg_order_by'] : 'DESC';
		$this->db->order_by('id',$ord);
		
		if($this->db->table_exists($table)){
			$exists=true;
			foreach($filters as $k => $v){
				if(in_array($k,array('id','user'))) continue;
				$this->db->where($k,$v);
			}
			return $this->db->get($table)->result_array();
		}else{
			if(isset($filters['user'])){
				$this->db->where('user',$filters['user']);
			}
			$exists=false;
			$this->db->where('table_name',$table);
			//echo '---'.$table; var_dump($this->db->get('lg_datas')->result_array());
			return $this->db->get('lg_datas')->result_array();
		}
	}

	function get_user($id){
		$this->db->where('id',$id);
		return $this->db->get('users')->row_array();
	}

	function get_users(){
		return $this->db->get('users')->result_array();
	}	

}


?>
