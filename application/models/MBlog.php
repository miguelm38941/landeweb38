<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MBlog extends Mlg {

	function __construct(){
		parent::__construct();
	}

	function getPosts(){
		$sql = "SELECT blog_posts.id, blog_posts.title, CONCAT(SUBSTR(blog_posts.article,1,100),'...') as article, blog_categories.nom as category
				FROM blog_posts, blog_categories
				WHERE blog_posts.category=blog_categories.id";
		$query = $this->db->query($sql, array());
		return $query->result_array(); 
	}

	function getSinglePost($id){
		$sql = "SELECT blog_posts.id, blog_posts.title, blog_posts.article, blog_categories.nom as category
				FROM blog_posts, blog_categories
				WHERE blog_posts.category=blog_categories.id
				AND blog_posts.id=?";
		$query = $this->db->query($sql, array($id));
		return $query->row(); 
	}

	function getCategories(){
		//$this->db->where('user_id',$userid);
		//$this->db->order_by('finger_id','DESC');
		return $this->db->get('blog_categories')->result_array();
	}

	function getSingleCategory($id){
		$this->db->where('id',$id);
		return $this->db->get('blog_categories')->row();
	}

	function getPostsPerCategories($category_id){
		$sql = "SELECT blog_posts.id, blog_posts.title, blog_posts.article, blog_categories.nom as category
				FROM blog_posts, blog_categories
				WHERE blog_posts.category=blog_categories.id
				AND blog_posts.category=?";
		$query = $this->db->query($sql, array($category_id));
		return $query->result_array(); 
	}
}


?>
