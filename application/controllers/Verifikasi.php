<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Sunra\PhpSimple\HtmlDomParser;

class Verifikasi extends User_Controller
{
	var $_id_cip_selected;
	public function __construct()
	{
		parent::__construct();
		$this->auth();
		$this->load->model('m_risalah');
		$this->load->model('m_cip');
		$this->load->model('m_bab');
		$this->load->model('m_subbab');
		$this->load->model('m_langkah');

    }
    public function lihat($id_cip)
	{
		$this->_id_cip_selected = base64_decode($id_cip);
		$this->title 	= "Risalah";
		$this->content 	= "verifikasi/lihat_risalah";
		$this->assets 	= array('admin_assets_lihat');
		$id_cip 		= $this->_id_cip_selected;
		
		$data['bab_risalah'] = $this->m_bab->all()->result();
		$data['stepStatus']  = '';
		$data['stepStatusDesc']  = '';
		$data['currentStepDesc'] = '';
		$data['urllangkah'] = "";
		$data['id_cip'] = $id_cip;
		$this->session->set_userdata('temp_id_cip_selected',$id_cip);
		$this->setCurrentStep('');
		foreach ($data['bab_risalah'] as $item) {
			$param['id_cip'] 	 = $id_cip;
			$param['id_bab'] 	 = $item->br_kode;
			if ($item->br_jenis==1){
				$q = $this->m_risalah->check_status_by_bab($param);
			}else{
				$q = $this->m_risalah->check_status_by_bab2($param);
			}
			
			if (empty($this->getCurrentStep())){

				$data['stepStatus'][$item->br_kode] = $q;
				
				if ($q==-1 || $q==0){
					$this->setCurrentStep($item->br_kode);
					$data['currentStepDesc'] = $item->br_bab;
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'sedang diisi']);
				}else if ($q==1){
					$this->setCurrentStep($item->br_kode);
					$data['currentStepDesc'] = $item->br_bab;
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'primary','text'=>'menunggu verifikasi pimpinan']);
				}else if ($q==2){
					$this->setCurrentStep($item->br_kode);
					$data['currentStepDesc'] = $item->br_bab;
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'revisi']);
				}else if ($q==4){
					$this->setCurrentStep($item->br_kode);
					$data['currentStepDesc'] = $item->br_bab;
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'menunggu verifikasi admin']);
				}else{
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'success','text'=>'selesai']);
				}
			}else{
				$data['stepStatus'][$item->br_kode] = $q;
				if($q==0 || $q==-1){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'default','text'=>'belum diisi']);
				}else if($q==1){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'primary','text'=>'menunggu verifikasi pimpinan']);
				}else if($q==2){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'revisi']);
				}else if($q==3){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'success','text'=>'selesai']);
				}else if($q==4){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'menunggu verifikasi admin']);
				}
			}
			
			
		}
		if (empty($this->getCurrentStep())){
			fs_create_alert(['type' => 'warning', 'message' => 'Data Risalah sudah selesai dibuat, silahkan download Risalah disini &nbsp;'.anchor('risalah/download/'.base64_encode($id_cip),'Download',array('class'=>'btn btn-xs btn-primary'))]);
		}
		$data['currentStep'] = $this->getCurrentStep();
		$data['currentStepDesc'] = $this->getCurrentStep();

		$bab = $this->m_bab->by_id($data['currentStep'])->row();
		if (!empty($bab)){
			if ($bab->br_jenis==0){
				$data['urllangkah'] = "/true";
			}
		}
		$data['currentStatus'] = $this->check_status($id_cip);
		$param = array(
			'data' 	=> $data,
		);
		$this->template($param);
		$this->load_view('lihat',$data);
		$this->load_view('admin_tolak',$data);
	}
    public function admin(){
        $this->title 	= "Verifikasi Risalah";
		$this->content 	= "verifikasi/admin";
		$this->assets 	= array('admin_assets');

		$param = array(
		);
		$this->template($param);
    }

    public function pimpinanlist(){
        $this->title 	= "Verifikasi Risalah";
		$this->content 	= "verifikasi/pimpinanlist";
		$this->assets 	= array('pimpinan_assets');

		$param = array(
		);
		$this->template($param);
    }
	public function pimpinan($id_cip)
	{
		$id_cip = base64_decode($id_cip);
		$this->title 	= "Verifikasi Risalah";
		$this->content 	= "verifikasi/pimpinan";
		$this->assets 	= array('assets');
		$this->session->set_userdata('temp_id_cip_selected',$id_cip);
		//$id_cip 		= $this->user->u_name;
		
		$data['bab_risalah'] = $this->m_bab->all()->result();
		$data['stepStatus']  = '';
		$data['stepStatusDesc']  = '';
		$data['currentStepDesc'] = '';
		$data['urllangkah'] = "";
		$data['id_cip'] = $id_cip;

		$this->setCurrentStep('');
		foreach ($data['bab_risalah'] as $item) {
			$param['id_cip'] 	 = $id_cip;
			$param['id_bab'] 	 = $item->br_kode;
			if ($item->br_jenis==1){
				$q = $this->m_risalah->check_status_by_bab($param);
			}else{
				$q = $this->m_risalah->check_status_by_bab2($param);
			}
			
			if (empty($this->getCurrentStep())){

				$data['stepStatus'][$item->br_kode] = $q;
				
				if ($q==-1 || $q==0){
					$this->setCurrentStep($item->br_kode);
					$data['currentStepDesc'] = $item->br_bab;
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'sedang diisi']);
				}else if ($q==1){
					$this->setCurrentStep($item->br_kode);
					$data['currentStepDesc'] = $item->br_bab;
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'primary','text'=>'menunggu verifikasi pimpinan']);
				}else if ($q==2){
					$this->setCurrentStep($item->br_kode);
					$data['currentStepDesc'] = $item->br_bab;
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'revisi']);
				}else if ($q==4){
					$this->setCurrentStep($item->br_kode);
					$data['currentStepDesc'] = $item->br_bab;
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'menunggu verifikasi admin']);
				}else{
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'success','text'=>'selesai']);
				}
			}else{
				$data['stepStatus'][$item->br_kode] = $q;
				if($q==0 || $q==-1){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'default','text'=>'belum diisi']);
				}else if($q==1){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'primary','text'=>'menunggu verifikasi pimpinan']);
				}else if($q==2){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'revisi']);
				}else if($q==3){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'success','text'=>'selesai']);
				}else if($q==4){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'menunggu verifikasi admin']);
				}
			}
			
			
		}
		if (empty($this->getCurrentStep())){
			fs_create_alert(['type' => 'warning', 'message' => 'Sedang menunggu proses verifikasi dari admin']);
		}
		$data['currentStep'] = $this->getCurrentStep();
		$data['currentStepDesc'] = $this->getCurrentStep();

		$bab = $this->m_bab->by_id($data['currentStep'])->row();
		if (!empty($bab)){
			if ($bab->br_jenis==0){
				$data['urllangkah'] = "/true";
			}
		}

		$data['currentStatus'] = $this->check_status($id_cip);
		$param = array(
			'data' 	=> $data,
		);
		$this->template($param);
		$this->load_view('lihat',$data);
	}
	public function simpanbab_admin($id_cip,$langkah=false){
		$id_cip = base64_decode($id_cip);
		$data['id_cip'] 	= $id_cip;
		$data['r_status'] 	= 4;

		$param['id_cip'] 	 = $data['id_cip'];
		$param['id_bab'] 	 = $this->getCurrentStep();
		if ($langkah){
			$mlangkah = $this->m_langkah->by_bab($param['id_bab'])->result();
			$param['id_kode'] = [];
			if (count($mlangkah)>0){
				foreach ($mlangkah as $row) {
					$param['id_kode'][] = $row->ln_id;
				}
			}
			$q = $this->m_risalah->check_nilai_by_bab2($param);
			if ($q==2){
				$simpan = $this->m_risalah->simpanbab2($param,$data);
				if ($simpan){
					fs_create_alert(['type' => 'success', 'message' => 'Data berhasil disimpan.']);
				}else{
					fs_create_alert(['type' => 'danger', 'message' => 'Data gagal disimpan.']);
				}
			}else{
				fs_create_alert(['type' => 'danger', 'message' => 'Data belum lengkap']);
			}
		}else{
			$mlangkah = $this->m_subbab->by_bab($param['id_bab'])->result();
			$param['id_kode'] = [];
			if (count($mlangkah)>0){
				foreach ($mlangkah as $row) {
					$param['id_kode'][] = $row->sb_id;
				}
			}
			$q = $this->m_risalah->check_nilai_by_bab($param);
			if ($q==2){
				$simpan = $this->m_risalah->simpanbab($param,$data);
				if ($simpan){
					fs_create_alert(['type' => 'success', 'message' => 'Data berhasil disimpan.']);
				}else{
					fs_create_alert(['type' => 'danger', 'message' => 'Data gagal disimpan.']);
				}
			}else{
				fs_create_alert(['type' => 'danger', 'message' => 'Data belum lengkap']);
			}
		}
		
		redirect('pimpinan/verifikasi/'.base64_encode($id_cip));
	}
	public function simpanbab($id_cip,$langkah=false){
		$id_cip = base64_decode($id_cip);
		$data['id_cip'] 	= $id_cip;
		$data['r_status'] 	= 4;

		$param['id_cip'] 	 = $data['id_cip'];
		$param['id_bab'] 	 = $this->getCurrentStep();
		if ($langkah){
			$mlangkah = $this->m_langkah->by_bab($param['id_bab'])->result();
			$param['id_kode'] = [];
			if (count($mlangkah)>0){
				foreach ($mlangkah as $row) {
					$param['id_kode'][] = $row->ln_id;
				}
			}
			$q = $this->m_risalah->check_nilai_by_bab2($param);
			if ($q==2){
				$simpan = $this->m_risalah->simpanbab2($param,$data);
				if ($simpan){
					fs_create_alert(['type' => 'success', 'message' => 'Data berhasil disimpan.']);
				}else{
					fs_create_alert(['type' => 'danger', 'message' => 'Data gagal disimpan.']);
				}
			}else{
				fs_create_alert(['type' => 'danger', 'message' => 'Data belum lengkap']);
			}
		}else{
			$mlangkah = $this->m_subbab->by_bab($param['id_bab'])->result();
			$param['id_kode'] = [];
			if (count($mlangkah)>0){
				foreach ($mlangkah as $row) {
					$param['id_kode'][] = $row->sb_id;
				}
			}
			$q = $this->m_risalah->check_nilai_by_bab($param);
			if ($q==2){
				$simpan = $this->m_risalah->simpanbab($param,$data);
				if ($simpan){
					fs_create_alert(['type' => 'success', 'message' => 'Data berhasil disimpan.']);
				}else{
					fs_create_alert(['type' => 'danger', 'message' => 'Data gagal disimpan.']);
				}
			}else{
				fs_create_alert(['type' => 'danger', 'message' => 'Data belum lengkap']);
			}
		}
		
		redirect('pimpinan/verifikasi/'.base64_encode($id_cip));
	}
	private function setCurrentStep($val){
		return $this->session->set_userdata('currentStep',$val);
	}
	private function getCurrentStep(){
		return $this->session->userdata('currentStep');
	}
    function tinymce_upload() {
		$config['file_name'] 	= base64_encode(date('Y-m-d H:i:s').rand());
        $config['upload_path'] = 'assets/upload/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('file')) {
            $this->output->set_header('HTTP/1.0 500 Server Error');
            exit;
        } else {
            $file = $this->upload->data();
            $this->output
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode(['location' => base_url().'assets/upload/'.$file['file_name']]))
                ->_display();
            exit;
        }
    }
	public function edit($kode,$id_cip,$langkah=false)
	{
        $kode = base64_decode($kode);
        $id_cip = base64_decode($id_cip);

		$this->title 	= "Edit Risalah";
		$this->content 	= "risalah/edit";
		$this->assets 	= array('assets_form');
		$data['urllangkah'] = "";
		if ($langkah){
			$data['rkode']      = $this->m_risalah->rkode_by_kode2($kode)->row();
			$data['reditor']    = $this->m_risalah->reditor_by_kode_cip2($kode,$id_cip)->row();
			$data['kode']       = $kode;
			$data['id_cip']     = $id_cip;
			if (!empty($data['reditor'])){
				$data['val'] = $data['reditor']->r_value;
			}
			$data['rkode']->sb_sub_bab = $data['rkode']->ln_langkah;
			$data['urllangkah'] = "/true";
		}else{
			$data['rkode']      = $this->m_risalah->rkode_by_kode($kode)->row();
			$data['reditor']    = $this->m_risalah->reditor_by_kode_cip($kode,$id_cip)->row();
			$data['kode']       = $kode;
			$data['id_cip']     = $id_cip;
			if (empty($data['reditor'])){
				$data['val'] =  @$data['rkode']->sb_template;
			}else{
				$data['val'] = $data['reditor']->r_value;
			}
		}
        
		$param = array(
            'data' => $data,
		);
		$this->template($param);
    }
    public function approve($id_bab,$id_cip){
        $id_bab = base64_decode($id_bab);
        $id_cip = base64_decode($id_cip);
        
        $data['id_bab'] = $id_bab;
        $data['id_cip'] = $id_cip;

		$q = $this->m_risalah->admin_approve($data);
		if ($q){
			fs_create_alert(['type' => 'success', 'message' => 'Approve berhasil.']);
		}else{
			fs_create_alert(['type' => 'danger', 'message' => 'Approve gagal.']);
		}
			redirect('admin/verifikasi/lihatrisalah/'.base64_encode($id_cip));
        
	}
	public function tolak($id_bab,$id_cip){
        $id_bab = base64_decode($id_bab);
        $id_cip = base64_decode($id_cip);
        
        $data['id_bab'] 		= $id_bab;
        $data['id_cip'] 		= $id_cip;
        $data['k_komentar'] 	= $this->input->post('komentar',TRUE);

		$q = $this->m_risalah->admin_tolak($data);
		if ($q){
			fs_create_alert(['type' => 'success', 'message' => 'Tolak berhasil.']);
		}else{
			fs_create_alert(['type' => 'danger', 'message' => 'Tolak gagal.']);
		}
			redirect('admin/verifikasi/lihatrisalah/'.base64_encode($id_cip));
        
	}
    public function simpan($kode,$id_cip,$langkah=false){
        $kode = base64_decode($kode);
        $id_cip = base64_decode($id_cip);
		if ($langkah){
			$data['id_kode'] = $kode;
			$data['id_cip'] = $id_cip;
			$data['r_value'] = $this->input->post('editor1');
		

			$q = $this->m_risalah->simpan2($data);
			if ($q){
				fs_create_alert(['type' => 'success', 'message' => 'Data berhasil disimpan.']);
			}else{
				fs_create_alert(['type' => 'danger', 'message' => 'Data gagal disimpan.']);
			}
				redirect('user/risalah/edit/'.base64_encode($kode).'/'.base64_encode($id_cip)."/true");
			
		}else{
			$data['id_kode'] = $kode;
			$data['id_cip'] = $id_cip;
			$data['r_value'] = $this->input->post('editor1');
		

			$q = $this->m_risalah->simpan($data);
			if ($q){
				fs_create_alert(['type' => 'success', 'message' => 'Data berhasil disimpan.']);
			}else{
				fs_create_alert(['type' => 'danger', 'message' => 'Data gagal disimpan.']);
			}
				redirect('user/risalah/edit/'.base64_encode($kode).'/'.base64_encode($id_cip));
			
		}
        
	}
	// public function simpanbab($langkah=false){
	// 	$data['id_cip'] 	= $this->user->u_name;
	// 	$data['r_status'] 	= 1;

	// 	$param['id_cip'] 	 = $data['id_cip'];
	// 	$param['id_bab'] 	 = $this->getCurrentStep();
	// 	if ($langkah){
	// 		$mlangkah = $this->m_langkah->by_bab($param['id_bab'])->result();
	// 		$param['id_kode'] = [];
	// 		if (count($mlangkah)>0){
	// 			foreach ($mlangkah as $row) {
	// 				$param['id_kode'][] = $row->ln_id;
	// 			}
	// 		}
	// 		$q = $this->m_risalah->check_nilai_by_bab2($param);
	// 		if ($q==2){
	// 			$simpan = $this->m_risalah->simpanbab2($param,$data);
	// 			if ($simpan){
	// 				fs_create_alert(['type' => 'success', 'message' => 'Data berhasil disimpan.']);
	// 			}else{
	// 				fs_create_alert(['type' => 'danger', 'message' => 'Data gagal disimpan.']);
	// 			}
	// 		}else{
	// 			fs_create_alert(['type' => 'danger', 'message' => 'Data belum lengkap']);
	// 		}
	// 	}else{
	// 		$mlangkah = $this->m_subbab->by_bab($param['id_bab'])->result();
	// 		$param['id_kode'] = [];
	// 		if (count($mlangkah)>0){
	// 			foreach ($mlangkah as $row) {
	// 				$param['id_kode'][] = $row->sb_id;
	// 			}
	// 		}
	// 		$q = $this->m_risalah->check_nilai_by_bab($param);
	// 		if ($q==2){
	// 			$simpan = $this->m_risalah->simpanbab($param,$data);
	// 			if ($simpan){
	// 				fs_create_alert(['type' => 'success', 'message' => 'Data berhasil disimpan.']);
	// 			}else{
	// 				fs_create_alert(['type' => 'danger', 'message' => 'Data gagal disimpan.']);
	// 			}
	// 		}else{
	// 			fs_create_alert(['type' => 'danger', 'message' => 'Data belum lengkap']);
	// 		}
	// 	}
		
	// 	redirect('user/risalah/');
	// }
	public function hapusitem($kode,$id_cip){
		$kode = base64_decode($kode);
		$id_cip = base64_decode($id_cip);

		$param['id_cip'] = $id_cip;
		$param['id_kode'] = $kode;
		if ($this->m_risalah->delete($param)){
			fs_create_alert(['type' => 'success', 'message' => 'Hapus item berhasil']);	
		}else{
			fs_create_alert(['type' => 'danger', 'message' => 'Hapus item gagal']);	
		}
		redirect('user/risalah/');	
	}
	public function preview(){
		$param['id_bab'] 	= $this->input->post('id_bab',TRUE);
		$param['id_cip']	= $this->user->u_name;
		$risalah 		= $this->m_risalah->reditor_bab_by_cip($param)->result();
		$data['val'] 	= '';
		$bab_risalah 	= '';
		$langkah 		= '';
		$sub_bab 		= '';
		if (count($risalah)>0){
			foreach ($risalah as $row) {
				if (!empty($row->r_value)){
					$dom = HtmlDomParser::str_get_html( $row->r_value );
					$elems = $dom->find('body',0)->innertext();
					if ($bab_risalah != $row->br_kode){
						$bab_risalah = $row->br_kode;
						$data['val'] .= '<h3>'.$row->br_bab.'</h3>';
					}
					if ($langkah != $row->ln_id){
						$langkah = $row->ln_id;
						$data['val'] .= '<h4>'.$row->ln_langkah.'</h4>';
					}
					if ($sub_bab != $row->sb_id){
						$sub_bab = $row->sb_id;
						$data['val'] .= '<h5>'.$row->sb_sub_bab.'</h5>';
					}
					$data['val'] .= $elems;
				}
			}
		}
		echo json_encode(array(
			'status'=>TRUE,
			'data'=>$data['val'])
		);
    }
    private function check_status($id_cip){
    	$id_cip = $id_cip;
    	$data['bab_risalah'] = $this->m_bab->all()->result();
		$data['stepStatus']  = '';
		$data['stepStatusDesc']  = '';
		$data['currentStepDesc'] = '';
		$data['urllangkah'] = "";

		$this->setCurrentStep('');
		foreach ($data['bab_risalah'] as $item) {
			$param['id_cip'] 	 = $id_cip;
			$param['id_bab'] 	 = $item->br_kode;
			if ($item->br_jenis==1){
				$q = $this->m_risalah->check_status_by_bab($param);
			}else{
				$q = $this->m_risalah->check_status_by_bab2($param);
			}
			
			if (empty($this->getCurrentStep())){

				$data['stepStatus'][$item->br_kode] = $q;
				
				if ($q==-1 || $q==0){
					$this->setCurrentStep($item->br_kode);
					$data['currentStepDesc'] = $item->br_bab;
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'sedang diisi']);
				}else if ($q==1){
					$this->setCurrentStep($item->br_kode);
					$data['currentStepDesc'] = $item->br_bab;
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'menunggu verifikasi pimpinan']);
				}else if ($q==2){
					$this->setCurrentStep($item->br_kode);
					$data['currentStepDesc'] = $item->br_bab;
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'revisi']);
				}else if ($q==4){
					$this->setCurrentStep($item->br_kode);
					$data['currentStepDesc'] = $item->br_bab;
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'menunggu verifikasi admin']);
				}else{
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'success','text'=>'selesai']);
				}
			}else{
				$data['stepStatus'][$item->br_kode] = $q;
				if($q==0 || $q==-1){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'default','text'=>'belum diisi']);
				}else if($q==1){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'menunggu verifikasi pimpinan']);
				}else if($q==2){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'revisi']);
				}else if($q==3){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'success','text'=>'selesai']);
				}else if($q==4){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'menunggu verifikasi admin']);
				}
			}
			
			
		}
		$data['currentStep'] = $this->getCurrentStep();
		$status = "";
		foreach ($data['bab_risalah'] as $item) {
            if ($data['stepStatus'][$item->br_kode]==3){
                $status = 3;
            }else if ($data['stepStatus'][$item->br_kode]>0 || $data['currentStep'] == $item->br_kode){
            	$status = $data['stepStatus'][$item->br_kode];
            }else{

            }
        }
        return $status;
    }
    public function pimpinan_team_list()
	{

		$list = $this->m_cip->get_datatables();
		$data = array();

		$no = $_POST['start'];

		foreach ($list as $tps) {
			$arrParam = array(
				'id' => $tps->t_no_gugus,
				'nomor' => $tps->t_no_gugus,
				'nama' => $tps->t_nama_gugus,
			);
			$btnhapus = '<a href="#" onclick="hapusCIP(\''.htmlspecialchars(json_encode($arrParam),ENT_QUOTES).'\')"><i class="fa fa-trash"></i>Hapus</a>';
			$btngroup_disable = '<button type="button" class="btn btn-xs btn-primary" disabled><i class="fa fa-eye"></i> Lihat</button>';
			$btngroup = '<div class="input-group">
					<button type="button" class="btn btn-xs btn-default pull-right dropdown-toggle" data-toggle="dropdown">
						<span> Action
						</span>
						<i class="fa fa-caret-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>' . anchor("user/registrasi/edit/" . base64_encode($tps->t_no_gugus), "<i class=\"fa fa-edit\"></i>Edit") . '</li>
					</ul>
                </div>';
            $status = $this->check_status($tps->t_no_gugus);//$this->m_risalah->check_status_by_cip(['id_cip'=>$tps->t_no_gugus]);
            $statusRisalah = '';
			if ($status == -1){
				$statusRisalah = label_skin(['type'=>'default','text'=>'belum selesai']);
			}else if ($status == 0){
				$statusRisalah = label_skin(['type'=>'default','text'=>'belum selesai']);
			}else if ($status == 1){
				$statusRisalah = label_skin(['type'=>'warning','text'=>'menunggu verifikasi pimpinan']);
			}else if ($status == 2){
				$statusRisalah = label_skin(['type'=>'warning','text'=>'revisi']);
			}else if ($status == 3){
				$statusRisalah = label_skin(['type'=>'success','text'=>'selesai']);
			}else if ($status == 4){
				$statusRisalah = label_skin(['type'=>'warning','text'=>'menunggu verifikasi admin']);
			}
			$btngroup = anchor("pimpinan/verifikasi/" . base64_encode($tps->t_no_gugus), "<i class=\"fa fa-eye\"></i> Lihat",array('class'=>'btn btn-xs btn-primary'));
			if ($status!=1){
				$btngroup = $btngroup_disable;
			}
            
			$no++;
			$row = array();
			$row[] = $btngroup;
			$row[] = $tps->t_no_gugus;
			$row[] = $tps->t_didirikan;
			$row[] = $tps->t_nama_gugus;
			$row[] = $tps->t_judul_cip;
			$row[] = $statusRisalah;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_cip->count_all(),
			"recordsFiltered" => $this->m_cip->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
    public function admin_team_list()
	{

		$list = $this->m_cip->get_datatables();
		$data = array();

		$no = $_POST['start'];

		foreach ($list as $tps) {
			$arrParam = array(
				'id' => $tps->t_no_gugus,
				'nomor' => $tps->t_no_gugus,
				'nama' => $tps->t_nama_gugus,
			);
			$btnhapus = '<a href="#" onclick="hapusCIP(\''.htmlspecialchars(json_encode($arrParam),ENT_QUOTES).'\')"><i class="fa fa-trash"></i>Hapus</a>';
			$btngroup_disable = '<div class="input-group">
			<button type="button" class="btn btn-xs btn-default pull-right dropdown-toggle" data-toggle="dropdown" disabled>
				<span> Action
				</span>
				<i class="fa fa-caret-down"></i>
			</button>
		</div>';
			$btngroup = '<div class="input-group">
					<button type="button" class="btn btn-xs btn-default pull-right dropdown-toggle" data-toggle="dropdown">
						<span> Action
						</span>
						<i class="fa fa-caret-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>' . anchor("user/registrasi/edit/" . base64_encode($tps->t_no_gugus), "<i class=\"fa fa-edit\"></i>Edit") . '</li>
					</ul>
                </div>';
            $status = $this->check_status($tps->t_no_gugus); //$this->m_risalah->check_status_by_cip(['id_cip'=>$tps->t_no_gugus]);
            $statusRisalah = '';
			if ($status == -1){
				$statusRisalah = label_skin(['type'=>'default','text'=>'belum selesai']);
			}else if ($status == 0){
				$statusRisalah = label_skin(['type'=>'default','text'=>'belum selesai']);
			}else if ($status == 1){
				$statusRisalah = label_skin(['type'=>'warning','text'=>'menunggu verifikasi pimpinan']);
			}else if ($status == 2){
				$statusRisalah = label_skin(['type'=>'warning','text'=>'revisi']);
			}else if ($status == 3){
				$statusRisalah = label_skin(['type'=>'success','text'=>'selesai']);
			}else if ($status == 4){
				$statusRisalah = label_skin(['type'=>'warning','text'=>'menunggu verifikasi admin']);
			}
            $btngroup = anchor("admin/verifikasi/lihatrisalah/" . base64_encode($tps->t_no_gugus), "<i class=\"fa fa-eye\"></i> Lihat",array('class'=>'btn btn-xs btn-primary'));
			$no++;
			$row = array();
			$row[] = $btngroup;
			$row[] = $tps->t_no_gugus;
			$row[] = $tps->t_didirikan;
			$row[] = $tps->t_nama_gugus;
			$row[] = $tps->t_judul_cip;
			$row[] = $statusRisalah;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_cip->count_all(),
			"recordsFiltered" => $this->m_cip->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	public function ajax_list()
	{
		$param['id_cip']    = $this->session->userdata('temp_id_cip_selected');
		$param['id_bab']    = $this->input->post('id_bab',TRUE);
		if (empty($param['id_bab'])){
			$param['id_bab']    = $this->getCurrentStep();
		}
		$bab = $this->m_bab->by_id($param['id_bab'])->row();
		
		$list = $this->m_risalah->get_datatables($param);
		$data = array();

		$no = $_POST['start'];

		foreach ($list as $item) {
			if ($bab->br_jenis<1){
				$item->sb_id = $item->ln_id;
				$item->sb_sub_bab = '-';
				$urllangkah = "/true";
			}else{
				$urllangkah = '';
			}
			//if ($item->br_kode!=$param['id_bab']) continue

			$btngroupdisabled = '<div class="input-group">
					<button type="button" class="btn btn-xs btn-default pull-right dropdown-toggle" data-toggle="dropdown" disabled>
						<span> Action
						</span>
						<i class="fa fa-caret-down"></i>
					</button>
					<ul class="dropdown-menu">
					</ul>
				</div>';
			$btngroupdisabled = anchor("", "<i class=\"fa fa-edit\"></i> Edit",array('class'=>'btn btn-success btn-xs','disabled'=>'disabled'));
			$btngroup = '<div class="input-group">
					<button type="button" class="btn btn-xs btn-default pull-right dropdown-toggle" data-toggle="dropdown">
						<span> Action
						</span>
						<i class="fa fa-caret-down"></i>
					</button>
					<ul class="dropdown-menu">
                        <li>' . anchor("user/risalah/edit/" . base64_encode($item->sb_id).'/'. base64_encode($param['id_cip']).$urllangkah, "<i class=\"fa fa-edit\"></i>Edit") . '</li>
					</ul>
				</div>';
			if ($this->user->u_role == "pimpinan"){
				$btngroup = anchor("pimpinan/verifikasi/risalah/edit/" . base64_encode($item->sb_id).'/'. base64_encode($param['id_cip']).$urllangkah, "<i class=\"fa fa-edit\"></i> Edit",array('class'=>'btn btn-success btn-xs'));
			}else if($this->user->u_role=="admin"){
				$btngroup = anchor("admin/verifikasi/risalah/edit/" . base64_encode($item->sb_id).'/'. base64_encode($param['id_cip']).$urllangkah, "<i class=\"fa fa-edit\"></i> Edit",array('class'=>'btn btn-success btn-xs'));	
			}
			

			$statusRisalah = '';
			if (empty($item->r_value) && $item->r_status == 0){
				$statusRisalah = label_skin(['type'=>'default','text'=>'belum diisi']);
			}else if (!empty($item->r_value) && $item->r_status == 0){
				$statusRisalah = label_skin(['type'=>'success','text'=>'sudah diisi']);
			}else if ($item->r_status == 1){
				$statusRisalah = label_skin(['type'=>'warning','text'=>'menunggu verifikasi pimpinan']);
			}else if ($item->r_status == 2){
				$statusRisalah = label_skin(['type'=>'warning','text'=>'revisi']);
			}else if ($item->r_status == 3){
				$statusRisalah = label_skin(['type'=>'success','text'=>'selesai']);
			}else if ($item->r_status == 4){
				$statusRisalah = label_skin(['type'=>'warning','text'=>'menunggu verifikasi admin']);
				//$btngroup = $btngroupdisabled;
			}
			$no++;
			$row = array();
			$row[] = $btngroup;
			$row[] = $item->sb_sub_bab;
			$row[] = $item->ln_langkah;
			$row[] = $item->br_bab;
			$row[] = $statusRisalah;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_risalah->count_all($param),
			"recordsFiltered" => $this->m_risalah->count_filtered($param),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	
}
