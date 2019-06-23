<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Overview extends User_Controller
{
    var $_kode = ['OV1','OV2'];
	public function __construct()
	{
		parent::__construct();
		$this->auth();
		$this->load->model('m_risalah');

	}
	public function index()
	{
		$this->title 	= "Overview";
		$this->content 	= "overview/index";
		$this->assets 	= array('assets');
		$data['kode_struktur']		= "OV4";
		$data['kode_jadwal']    	= "OV5";
        $data['id_cip']     	= $this->user->u_name;
		$data['status_struktur']	= $this->m_risalah->reditor_by_kode_cip($data['kode_struktur'],$data['id_cip'])->row();
		$data['status_jadwal']	= $this->m_risalah->reditor_by_kode_cip($data['kode_jadwal'],$data['id_cip'])->row();
		$data['icon_struktur'] = '';
		$data['icon_jadwal'] = '';
		if (empty($data['status_struktur'])){
			$data['status_struktur'] = 0;
			$data['icon_struktur'] = '<i class="fa fa-close"></i>';
			$data['color_btn_struktur'] = 'danger';
		}else{
			$data['status_struktur'] = $data['status_struktur']->r_status;
			$data['icon_struktur'] = '<i class="fa fa-check"></i>';
			$data['color_btn_struktur'] = 'success';
		}
		if (empty($data['status_jadwal'])){
			$data['status_jadwal'] = 0;
			$data['icon_jadwal'] = '<i class="fa fa-close"></i>';
			$data['color_btn_jadwal'] = 'danger';
		}else{
			$data['status_jadwal'] = $data['status_jadwal']->r_status;
			$data['icon_jadwal'] = '<i class="fa fa-check"></i>';
			$data['color_btn_jadwal'] = 'success';
		}
		

		$param = array(
			'data'	=> $data,
		);
		$this->template($param);
		$this->load_view('modal_hapus');
    }
    
	public function edit($kode,$id_cip)
	{
        $kode = base64_decode($kode);
        $id_cip = base64_decode($id_cip);

		$this->title 	= "Edit Overview";
		$this->content 	= "overview/edit";
        $this->assets 	= array('assets_form');

        $data['rkode']      = $this->m_risalah->rkode_by_kode($kode)->row();
        $data['reditor']    = $this->m_risalah->reditor_by_kode_cip($kode,$id_cip)->row();
        $data['kode']       = $kode;
        $data['id_cip']     = $id_cip;
		$param = array(
            'data' => $data,
		);
		$this->template($param);
    }
    public function simpan($kode,$id_cip){
        $kode = base64_decode($kode);
        $id_cip = base64_decode($id_cip);

        $data['id_kode'] = $kode;
        $data['id_cip'] = $id_cip;
        $data['r_value'] = $this->input->post('editor1');

        $data['r_status'] = $this->input->post('status',TRUE);
        if ($data['r_status']=="simpan"){
            $data['r_status'] = 1;
        }else{
            $data['r_status'] = 0;
        }

        $q = $this->m_risalah->simpan($data);
        if ($q){
            fs_create_alert(['type' => 'success', 'message' => 'Data berhasil disimpan.']);
        }else{
            fs_create_alert(['type' => 'danger', 'message' => 'Data gagal disimpan.']);
        }
			redirect('user/overview/edit/'.base64_encode($kode).'/'.base64_encode($id_cip));
        
	}
	public function hapuslampiran($kode,$id_cip){
		$kode = base64_decode($kode);
		$id_cip = base64_decode($id_cip);

        $data['reditor']    = $this->m_risalah->reditor_by_kode_cip($kode,$id_cip)->row();
		$param['id_cip'] = $id_cip;
		$param['id_kode'] = $kode;
		if ($this->m_risalah->delete($param)){
			unlink(base_url('assets/lampiran/'.$data['reditor']->r_value));
			fs_create_alert(['type' => 'success', 'message' => 'Hapus lampiran berhasil']);	
			redirect('user/overview/');	
		}else{
			fs_create_alert(['type' => 'danger', 'message' => 'Hapus lampiran gagal']);	
			if ($kode=="OV4"){ // KodeStruktur Organisasi
				redirect('user/overview/upload/strukturorganisasi/'.base64_encode($kode).'/'.base64_encode($id_cip));	
			}else{
				redirect('user/overview/upload/jadwalkegiatan/'.base64_encode($kode).'/'.base64_encode($id_cip));
			}
		}
	}

	public function hapusitem($kode,$id_cip){
		$kode = base64_decode($kode);
		$id_cip = base64_decode($id_cip);

        $data['reditor']    = $this->m_risalah->reditor_by_kode_cip($kode,$id_cip)->row();
		$param['id_cip'] = $id_cip;
		$param['id_kode'] = $kode;
		if ($this->m_risalah->delete($param)){
			fs_create_alert(['type' => 'success', 'message' => 'Hapus item berhasil']);	
		}else{
			fs_create_alert(['type' => 'danger', 'message' => 'Hapus item gagal']);	
		}
		redirect('user/overview/');	
	}
	public function strukturorganisasi($kode,$id_cip){
		$kode = base64_decode($kode);
        $id_cip = base64_decode($id_cip);

		$this->title 		= "Upload Struktur Organisasi";
		$this->content 		= "overview/uploadstruktur";
        $this->assets 		= array('assets_form');

        $data['rkode']      = $this->m_risalah->rkode_by_kode($kode)->row();
        $data['reditor']    = $this->m_risalah->reditor_by_kode_cip($kode,$id_cip)->row();
        $data['kode']       = $kode;
		$data['id_cip']     = $id_cip;
		if (!empty($data['reditor'])){
			$data['src']	= base_url('assets/lampiran/'.$data['reditor']->r_value);
		}else{
			$data['src']	= '';
		}
		$param = array(
            'data' => $data,
		);
		$this->template($param);
	}
	public function jadwalkegiatan($kode,$id_cip){
		$kode = base64_decode($kode);
        $id_cip = base64_decode($id_cip);

		$this->title 		= "Jadwal Kegiatan";
		$this->content 		= "overview/jadwalkegiatan";
        $this->assets 		= array('assets_form');

        $data['rkode']      = $this->m_risalah->rkode_by_kode($kode)->row();
        $data['reditor']    = $this->m_risalah->reditor_by_kode_cip($kode,$id_cip)->row();
        $data['kode']       = $kode;
        $data['id_cip']     = $id_cip;

		if (!empty($data['reditor'])){
			$data['src']	= base_url('assets/lampiran/'.$data['reditor']->r_value);
		}else{
			$data['src']	= '';
		}

		$param = array(
            'data' => $data,
		);
		$this->template($param);
	}
	public function uploadlampiran($kode,$id_cip){
		$kode = base64_decode($kode);
		$id_cip = base64_decode($id_cip);
		
		$upload = $this->do_upload('lampiran',$id_cip.$kode);
		if ($upload['status']){
			$param['id_kode']		= $kode;
			$param['id_cip']		= $id_cip;
			$param['r_value']		= $upload['file_name'];
			$param['r_status']		= 1;

			$simpan = $this->m_risalah->simpan($param);
			if ($simpan){
				fs_create_alert(['type' => 'success', 'message' => 'Data berhasil diupload']);
				redirect('user/overview');	
			}else{
				fs_create_alert(['type' => 'success', 'message' => 'Gagal simpan data, silahkan coba lagi']);
				if ($kode=="OV4"){ // KodeStruktur Organisasi
					redirect('user/overview/upload/strukturorganisasi/'.base64_encode($kode).'/'.base64_encode($id_cip));	
				}else{
					redirect('user/overview/upload/jadwalkegiatan/'.base64_encode($kode).'/'.base64_encode($id_cip));
				}
			}
		}else{
			fs_create_alert(['type' => 'danger', 'message' => $upload['message']]);
			if ($kode=="OV4"){ // KodeStruktur Organisasi
				redirect('user/overview/upload/strukturorganisasi/'.base64_encode($kode).'/'.base64_encode($id_cip));	
			}else{
				redirect('user/overview/upload/jadwalkegiatan/'.base64_encode($kode).'/'.base64_encode($id_cip));
			}

		}
	}
	public function do_upload($name,$file_name)
    {
		$config['allowed_types']        = "jpeg|jpg|png";
		$config['max_size']             = 5000;
		$config['file_name']			= $file_name;
		$config['upload_path']			= 'assets/lampiran/';
		$config['overwrite'] 			= TRUE;

		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload($name)){
			$error = $this->upload->display_errors();
			return array('status'=>false,'message'=>$error);
		}else{
			return array('status'=>true,'message'=>'Berhasil','file_name'=>$this->upload->data('file_name'));
		}
    }
	public function ajax_list()
	{
        $param['kode']      = $this->_kode;
        $param['id_cip']    = $this->user->u_name;
		$list = $this->m_risalah->get_datatables($param);
		$data = array();

		$no = $_POST['start'];

		foreach ($list as $tps) {
			$arrParam = array(
				'kode' => $tps->rk_kode,
				'id_cip' => $param['id_cip'],
				'judul' => $tps->rk_title,
			);
			$btnhapus = '<a href="#" onclick="hapusRisalah(\''.htmlspecialchars(json_encode($arrParam),ENT_QUOTES).'\')"><i class="fa fa-trash"></i>Hapus</a>';
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
                        <li>' . anchor("user/overview/edit/" . base64_encode($tps->rk_kode).'/'. base64_encode($param['id_cip']), "<i class=\"fa fa-edit\"></i>Edit") . '</li>
                        <li>' . anchor("user/overview/hapus/" . base64_encode($tps->rk_kode).'/'. base64_encode($param['id_cip']), "<i class=\"fa fa-trash\"></i>Hapus") . '</li>
					</ul>
                </div>';
                
			$no++;
			$row = array();
			$row[] = $btngroup;
			$row[] = $tps->rk_title;
			$row[] = conv_status_risalah($tps->r_status,true);
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
