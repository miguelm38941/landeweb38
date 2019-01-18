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

	function __construct(){

		parent::__construct();

		$this->load->model('Mapi');

		$this->load->config('lgedit');

		$this->load->helper('lgedit');

		$this->load->helper('landella_helper');

		$this->load->library('lg');
		$this->load->model('mblog');

		//$this->load->library('Pdf');

		//$this->load->helper('db');

		//$this->check_db();
		
        $CI =& get_instance();
		$CI->load->model('mlg');
		//$this->load->database();

	}



	public function index(){

		echo "11";

	}

	public function posts($id=false){

		$id = is_numeric($id) ? $id:'';

		if($id){
			$results = (array) $this->mblog->getSinglePost($id);
		}else{
			$results = $this->mblog->getPosts();
		}
        header('Content-type: application/json');
        $responseData['success'] = true;
        $responseData['result'] = $results;
        echo json_encode($responseData); 

	}


	public function categories($id=false){

		$id = is_numeric($id) ? $id:'';

		if($id){
			$results = (array) $this->mblog->getSingleCategory($id);
		}else{
			$results = $this->mblog->getCategories();
		}
        header('Content-type: application/json');
        $responseData['success'] = true;
        $responseData['result'] = $results;
        echo json_encode($responseData); 

	}

	public function postspercategories($category_id){

		$category_id = is_numeric($category_id) ? $category_id:'';

		$results = $this->mblog->getPostsPerCategories($category_id);

        header('Content-type: application/json');
        $responseData['success'] = true;
        $responseData['result'] = $results;
        echo json_encode($responseData); 

	}

}

