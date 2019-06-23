<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cek extends User_Controller
{
    var $_kode6 = ['CK1','CK2','CK3','CK4','CK5'];
	public function __construct()
	{
		parent::__construct();
		$this->auth();
		$this->load->model('m_risalah');

	}
	public function index($index)
	{
		$this->title 	= "Check";
		$this->content 	= "cek/index1";
		$this->assets 	= array('assets'.$index);
		
		$data['tahap'] = $index;
		$param = array(
			'data' => $data,
		);
		$this->template($param);
		
    }
    
	public function edit($index,$kode,$id_cip)
	{
        $kode = base64_decode($kode);
        $id_cip = base64_decode($id_cip);

		$this->title 	= "Edit Check";
		$this->content 	= "cek/edit";
        $this->assets 	= array('assets_form');

        $data['rkode']      = $this->m_risalah->rkode_by_kode($kode)->row();
        $data['reditor']    = $this->m_risalah->reditor_by_kode_cip($kode,$id_cip)->row();
        $data['kode']       = $kode;
        $data['id_cip']     = $id_cip;
        $data['tahap']      = $index;
		if (empty($data['reditor'])){
			$data['val'] =  @$data['rkode']->rk_template;
		}else{
			$data['val'] = $data['reditor']->r_value;
		}
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
			redirect('user/cek/edit/'.base64_encode($kode).'/'.base64_encode($id_cip));
        
	}
	public function hapusitem($index,$kode,$id_cip){
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
		redirect('user/cek/'.$index);	
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
	public function ajax_list($index)
	{
        if($index==6) $param['kode'] = $this->_kode6;


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
                        <li>' . anchor("user/cek/edit/".$index.'/' . base64_encode($tps->rk_kode).'/'. base64_encode($param['id_cip']), "<i class=\"fa fa-edit\"></i>Edit") . '</li>
                        <li>' . anchor("user/cek/hapus/".$index.'/' . base64_encode($tps->rk_kode).'/'. base64_encode($param['id_cip']), "<i class=\"fa fa-trash\"></i>Hapus") . '</li>
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
