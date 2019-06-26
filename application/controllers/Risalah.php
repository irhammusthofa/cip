<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Sunra\PhpSimple\HtmlDomParser;
use Dompdf\Dompdf;
use Dompdf\Options;
class Risalah extends User_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->auth();
		$this->load->model('m_risalah');
		$this->load->model('m_bab');
		$this->load->model('m_subbab');
		$this->load->model('m_langkah');

	}
	public function index()
	{
		$this->title 	= "Risalah";
		$this->content 	= "risalah/index";
		$this->assets 	= array('assets');
		$id_cip 		= $this->user->u_name;
		
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
		$param = array(
			'data' 	=> $data,
		);
		$this->template($param);
		$this->load_view('lihat',$data);
		$this->load_view('lihat_komentar');
	}
	private function setCurrentStep($val){
		return $this->session->set_userdata('currentStep',$val);
	}
	private function getCurrentStep(){
		return $this->session->userdata('currentStep');
	}
	function download($id_cip){
		$id_cip = base64_decode($id_cip);
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
		$data['currentStepDesc'] = $this->getCurrentStep();

		$bab = $this->m_bab->by_id($data['currentStep'])->row();
		if (!empty($bab)){
			if ($bab->br_jenis==0){
				$data['urllangkah'] = "/true";
			}
		}

		$data['id_cip'] = $id_cip;
		$param = array(
			'data' 	=> $data,
		);
		$data['val'] 	= '<div style="width: 100%;"> ';
		foreach ($data['bab_risalah'] as $item) {
			$param['id_bab'] 	= $item->br_kode;
			$param['id_cip']	= $data['id_cip'];
			$data_bab = $this->m_bab->by_id($param['id_bab'])->row();
			if($data_bab->br_jenis==0){
				$risalah 		= $this->m_risalah->reditor_bab_by_cip_2($param)->result();
			}else{
				$risalah 		= $this->m_risalah->reditor_bab_by_cip($param)->result();
			}
			
			
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
						if($data_bab->br_jenis==1){
							if ($sub_bab != $row->sb_id){
								$sub_bab = $row->sb_id;
								$data['val'] .= '<h5>'.$row->sb_sub_bab.'</h5>';
							}
						}
						
						$data['val'] .= $elems;
					}
				}
			}
			$data['val'] .= '<div style="page-break-after: always;"></div>';  
		}
		// instantiate and use the dompdf class
		$data['val'] .= '</div>';
		$options = new Options();
		$options->set('isRemoteEnabled', TRUE);
		$dompdf = new Dompdf($options);
		$contxt = stream_context_create([ 
		    'ssl' => [ 
		        'verify_peer' => FALSE, 
		        'verify_peer_name' => FALSE,
		        'allow_self_signed'=> TRUE
		    ] 
		]);
		$dompdf->setHttpContext($contxt);
		//$dompdf->set_option('isRemoteEnabled', TRUE);
		$dompdf->loadHtml($data['val']);

		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4');

		// Render the HTML as PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		$dompdf->stream();
		//$this->load->view('risalah/print',$param);
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
    public function edit2($kode,$id_cip,$langkah=false)
	{
        $kode = base64_decode($kode);
        $id_cip = base64_decode($id_cip);

		$this->title 	= "Edit Risalah";
		$this->content 	= "risalah/edit2";
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
    public function edit3($kode,$id_cip,$langkah=false)
	{
        $kode = base64_decode($kode);
        $id_cip = base64_decode($id_cip);

		$this->title 	= "Edit Risalah";
		$this->content 	= "risalah/edit3";
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
	public function simpan2($kode,$id_cip,$langkah=false){
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
				redirect('admin/verifikasi/risalah/edit/'.base64_encode($kode).'/'.base64_encode($id_cip)."/true");
			
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
				redirect('admin/verifikasi/risalah/edit/'.base64_encode($kode).'/'.base64_encode($id_cip));
			
		}
        
	}
	public function simpan3($kode,$id_cip,$langkah=false){
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
				redirect('pimpinan/verifikasi/risalah/edit/'.base64_encode($kode).'/'.base64_encode($id_cip)."/true");
			
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
				redirect('pimpinan/verifikasi/risalah/edit/'.base64_encode($kode).'/'.base64_encode($id_cip));
			
		}
        
	}
	public function simpanbab($langkah=false){
		$data['id_cip'] 	= $this->user->u_name;
		$data['r_status'] 	= 4;

		$param['id_cip'] 	 = $data['id_cip'];
		$param['id_bab'] 	 = $this->getCurrentStep();
		if ($langkah){
			$mlangkah = $this->m_langkah->by_bab($param['id_bab'])->result();
			$param['id_kode'] = [];
			if (count($mlangkah)>0){
				foreach ($mlangkah as $row) {
					$param['id_kode'][] = $row->ln_id;
					if ($row->ln_ver_pimpinan == 1){
						$data['r_status'] 	= 1;
					}
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
					if ($row->ln_ver_pimpinan == 1){
						$data['r_status'] 	= 1;
					}
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
		
		redirect('user/risalah/');
	}
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
		if (empty($this->input->post('id_cip',TRUE))){
			$param['id_cip']	= $this->user->u_name;
		}else{
			$param['id_cip']	= $this->input->post('id_cip',TRUE);
			$param['id_cip'] 	= base64_decode($param['id_cip']);
		}
		$data_bab = $this->m_bab->by_id($param['id_bab'])->row();
		if($data_bab->br_jenis==0){
			$risalah 		= $this->m_risalah->reditor_bab_by_cip_2($param)->result();
		}else{
			$risalah 		= $this->m_risalah->reditor_bab_by_cip($param)->result();
		}
		
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
					if($data_bab->br_jenis==1){
						if ($sub_bab != $row->sb_id){
							$sub_bab = $row->sb_id;
							$data['val'] .= '<h5>'.$row->sb_sub_bab.'</h5>';
						}
					}
					
					$data['val'] .= $elems;
				}
			}
		}
		echo json_encode(array(
			'status'=>TRUE,
			'count'=>count($risalah),
			'data'=>$data['val'])
		);
	}
	public function lihatkomentar(){
		$param['id_bab'] 	= $this->input->post('id_bab',TRUE);
		$param['id_cip']	= $this->user->u_name;
		$risalah 			= $this->m_risalah->lihat_komentar($param)->row();
		if (empty($risalah)){
			$data['val'] = 'Tidak ada komentar';
		}else{
			$data['val'] = $risalah->k_komentar;
		}
		echo json_encode(array(
			'status'=>TRUE,
			'data'=>$data['val'])
		);
	}
	public function ajax_list()
	{
		$param['id_cip']    = $this->user->u_name;
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
			$btngroup = anchor("user/risalah/edit/" . base64_encode($item->sb_id).'/'. base64_encode($param['id_cip']).$urllangkah, "<i class=\"fa fa-edit\"></i> Edit",array('class'=>'btn btn-success btn-xs'));

			$statusRisalah = '';
			if (empty($item->r_value) && $item->r_status == 0){
				$statusRisalah = label_skin(['type'=>'default','text'=>'belum diisi']);
			}else if (!empty($item->r_value) && $item->r_status == 0){
				$statusRisalah = label_skin(['type'=>'success','text'=>'sudah diisi']);
			}else if ($item->r_status == 1){
				$statusRisalah = label_skin(['type'=>'warning','text'=>'menunggu verifikasi']);
			}else if ($item->r_status == 2){
				$statusRisalah = label_skin(['type'=>'warning','text'=>'revisi']);
			}else if ($item->r_status == 3){
				$statusRisalah = label_skin(['type'=>'success','text'=>'selesai']);
				$btngroup = $btngroupdisabled;
			}else if ($item->r_status == 4){
				$statusRisalah = label_skin(['type'=>'warning','text'=>'menunggu verifikasi admin']);
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
