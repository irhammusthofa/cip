<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends User_Controller {

	public function __construct(){
		parent::__construct();
        $this->auth();
	}
	public function index()
	{
		$this->title 	= "Dashboard";
		$this->content 	= "dashboard/index";
		$this->assets 	= array();
        
		$param = array(
        
        );
		$this->template($param);
	}
	public function admin()
	{
		redirect('admin/team');
		$this->title 	= "Dashboard";
		$this->content 	= "dashboard/admin";
		$this->assets 	= array();
        
		$param = array(
        
        );
		$this->template($param);
	}
}
