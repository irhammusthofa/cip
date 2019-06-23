<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Controller extends CI_Controller {
	public $auth = TRUE; 
	public $layout = "template_admin";
	public $path_theme = "/assets/adminlte";
	public $content = "";
	public $title;
	public $id;
	public $_IS_LOGGEDIN 	= "is_loggedin";
	public $_ROLE 			= "role";
	public $_U_ID 			= "u_id";
	public $user;
	public $assets 			= array();
	public $current_class;
	public $current_method;
	public function __construct(){
		parent::__construct();
		$this->current_class 	= strtolower($this->router->fetch_class()); 
		$this->current_method = strtolower($this->router->fetch_method());

		$this->load->model('m_user');
		$this->init();
	}
	public function auth(){

		$loggedin 		= $this->session->userdata($this->_IS_LOGGEDIN);
		$role 			= $this->session->userdata($this->_ROLE);
		$id 			= $this->session->userdata($this->_U_ID);

		$this->user 	= $this->m_user->by_id($id)->row();

		if (@$loggedin == true){
			if ($this->current_class=="authentication" && $this->current_method=="logout"){
				return false;
			}
			
			if($this->check_role()){
				//redirect('fs-admin/data/barang');
			}else{
				die();//Tidak diizinkan
			}
		}else{
			if ($this->current_class=="authentication" || ($this->current_class=="relawan" && $this->current_method=="print_ringkasan")){
				return false;
			}else{
				redirect('logout');
			}
		}
	}
	private function check_role(){
		if ($this->current_class=="authentication" && $this->current_method=="index"){
			if ($this->user->u_role=="user"){
				redirect('user/dashboard');
			}else if ($this->user->u_role=="juri"){
				redirect('juri/penilaian');
			}else if ($this->user->u_role=="pimpinan"){
				redirect('pimpinan/verifikasi');
			}
			redirect('admin/dashboard');
		}
		return true;
	}
	public function template($param = array()){
		$this->init();

		$param['content'] = $this->content;
		for ($i=0; $i < count($this->assets); $i++) { 
			$this->load->view($this->dir_content().'/'.$this->assets[$i]);	
		}
		$this->load->view("layout/".$this->layout,$param);
	}
	public function init(){
		$this->config->set_item('fs_theme_path',$this->path_theme);
		$this->config->set_item('fs_title',$this->title);
	}
	public function load_view($view,$array = array()){
		$this->load->view($this->dir_content().'/'.$view,$array);

	}
	private function dir_content(){
		$konten = explode("/", $this->content);
		if (count($konten)>0) {
			$dir = substr($this->content, 0,$this->content - strlen($konten[count($konten)-1]) - 1);
		}else{
			$dir = "";
		}
		return $dir;
	}

	public function get_role(){
		return $this->session->userdata($this->_ROLE);
	}
}