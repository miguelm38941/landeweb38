<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	private $global_access = array('pnls','admin','ministere');
	private $can_command = array('pharmacie','zonesante','regionsante');
	private $haveStock = array('pharmacie','regionsante','zonesante');
	private $time_limit_ver = '10';
	private $time_limit_reg = '15';

	function __construct(){
		parent::__construct();
		$this->load->helper('lgedit');
		$this->load->library('email');
		$this->load->library('Pdf');
		$this->load->helper('lgpdf');
		$this->load->helper('cookie');
		$this->load->model('mblog');

		/*if(!$this->ion_auth->logged_in()){
			redirect('auth/login');			
		}*/
		/*
		$this->client_id = false;
		if($this->ion_auth->in_group('clients')){
			$id = $this->session->userdata('user_id');	
			$this->client_id = $this->mlns->get_client_from_userid($id);
			//echo $this->client_id;die();
			if(!is_numeric($this->client_id)) die('CLIENT NOT ASSIGNED');

			//redirect('clients');			
		}
		*/
	}

	public function index(){
		$this->load->view('welcome');
		///redirect('backend/welcome');
	}

	function validate_data($input, $callback){
		if(($input) && $callback($input)):
			return $input;
		endif;	
		return false;	
		/*
		$name = strip_tags( trim( $_POST[ ‘name’ ] ) ); // Strip php and html tags
		$pageID = (int) $_POST[ ‘page_ID’ ]; //cast type
		is_bool(), is_float(), is_numberic(), is_int() // check type
		if ( isset( $_POST[ ‘comment’ ] ) )
		$comment = htmlentities ( trim ( $_POST[ ‘comment’ ] ) , ENT_NOQUOTES );  // conveet htlm and php tags		
		$pageID = mysql_real_escape_string( $_POST[ ‘page_ID’ ] ); // SQL Injection
		*/
	}

	function getDbTables($t){
		$tables = $this->config->item('lgedit_tables');
		if(!isset($tables['articles'])||!isset($a)) die("Oups! Url incorrect");
		return $tables;
	}

	public function articles($action,$id=false){

		$a = ($action) ? strip_tags( $action ):'';

		switch ($action) {
			case 'rediger_un_article':
				$this->rediger($id);
				break;
			case 'liste_des_articles':
				$this->articles_list($categoryid=false);
				break;
			case 'liste_des_categories':
				$this->categories_list();
				break;
			default:
				$this->load->view('page_not_found',array());
				break;
		}

	}

	private function rediger($id=false){

		//$tables = getDbTables('blog_posts');

		$datas['referer']=isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : false;
		$datas['table']='blog_posts';
		$datas['datas']=array();

		if( ($id) && is_numeric($id) ): // Nouvelle article
			$datas['title']='Editer un article';
			$datas['datas'] = (array) $this->mblog->getSinglePost($id);
		//var_dump($datas['datas']); exit;
		else:
			$datas['title']='Ajouter un nouvel article';
		endif;
		$this->load->view('lgedit/insert',$datas);
		return;

	}

	private function articles_list($categoryid=false){

		//$tables = getDbTables('blog_posts');

		$datas['referer']=isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : false;

		$filters=array();

		$datas=array();
		//$datas['datas']=$this->lg->fetch_datas('blog_posts',$filters,true);
		$datas['datas']=$this->mblog->getPosts();
		$datas['table']="blog_posts";
		$datas['title']="Tous les articles";
		//$datas['datas'] = $this->mblog->getPosts();
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => true,
				'can_delete' => true,
				'hide_columns' => array('id')
				//'dbclick' => '/taaps/projects'
				);
		//var_dump($datas['datas']); exit;
		$this->load->view('lgedit/show',$datas);
		return;

	}

	private function categories_list(){

		//$tables = getDbTables('blog_posts');

		$datas['referer']=isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : false;

		$filters=array();

		$datas=array();
		//$datas['datas']=$this->lg->fetch_datas('blog_posts',$filters,true);
		$datas['datas']=$this->mblog->getCategories();
		$datas['table']="blog_categories";
		$datas['title']="Toutes les cat&eacute;gories";
		//$datas['datas'] = $this->mblog->getPosts();
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => false,
				'can_delete' => false,
				'hide_columns' => array('id')
				//'dbclick' => '/taaps/projects'
				);
		//var_dump($datas['datas']); exit;
		$this->load->view('lgedit/show',$datas);
		return;

	}
	
	function createLog($user_name, $time, $sn) {
		global $conn;
		
		$ins = $this->db->insert('finger_log',array('user_name' => $user_name, 'data' => date('Y-m-d H:i:s', strtotime($time))." (PC Time) | ".$sn." (SN)"));
		if ($ins) {
			return 1;				
		} else {
			return "Error insert log data!";
		}
		
	}

}




