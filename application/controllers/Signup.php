<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Signup
*/
class Signup extends User_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		//$this->auth();
		$this->load->model('m_user');
		$this->load->model('m_lokasi');
		$this->load->model('m_fungsi');
		$this->load->model('m_cip');
		$this->load->model('m_jenis');

	}
	public function index(){
		$lokasi = $this->m_lokasi->all()->result();
		$tmp = "";
		foreach ($lokasi as $row) {
			$tmp[$row->l_id] = $row->l_lokasi;
		}
        $data['lokasi'] = $tmp;

		$fungsi = $this->m_fungsi->all()->result();
		$tmp = "";
		foreach ($fungsi as $row) {
			$tmp[$row->id_fungsi] = $row->fungsi;
		}
        $data['fungsi'] = $tmp;

        $jenis = $this->m_jenis->all()->result();
        $data['jenis'][''] = 'Pilih Jenis CIP';

        foreach ($jenis as $row) {
        	$data['jenis'][$row->jc_id] = $row->jc_jenis; 
        }
        $data['kategori'] = [
            ''=>'Pilih Kategori',
            'NEW IDEA'=>'NEW IDEA',
            'REPLIKASI'=>'REPLIKASI',
        ];
        $data['vck'] = [
            ''=>'Pilih Kategori',
            'REVENUE/PROVIT'=>'REVENUE/PROVIT',
            'COST REDUCTION'=>'COST REDUCTION',
        ];
		$data['tahun'][''] = 'Pilih Tahun';
		$i = date('Y');
		do{
			$data['tahun'][$i] = $i;
			$i--;
		}while($i>2000);

		$param = array(
			'data' => $data,
		);
		$this->load->view('signup',$param);
	}
	
	public function dosignup(){
        
		$query = $this->m_cip->signup();
		if ($query['status']===TRUE){
            $alert['message'] 	= 'Pendaftaran berhasil, silahkan cek email dipesan masuk atau spam.';
            $alert['type'] 		= 'success';
            fs_create_alert($alert);
		}else{
			$alert['message'] 	= $query['message'];
			$alert['type'] 		= 'danger';
			fs_create_alert($alert);
		}
		redirect('signup');
	}
}