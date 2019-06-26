<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Babrisalah extends User_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->auth();
		$this->load->model('m_bab');

	}
	public function index()
	{
		$this->title 	= "Bab Risalah";
		$this->content 	= "bab/index";
		$this->assets 	= array('assets');
		$param = array(

		);
		$this->template($param);
		$this->load_view('modal_hapus');
    }
	public function add()
	{
		$this->title 	= "Tambah Bab Risalah";
		$this->content 	= "bab/add";
        $this->assets 	= array('assets_form');

		$param = array(

		);
		$this->template($param);
	}
	
	public function edit($id)
	{
		$id = base64_decode($id);
		$this->title 	= "Edit Bab Risalah";
		$this->content 	= "bab/edit";
        $this->assets 	= array('assets_form');

		$data['bab'] = $this->m_bab->by_id($id)->row();
		$param = array(
			'data' => $data,
		);
		$this->template($param);
    }
    public function simpan(){
        
        $data['br_kode'] 	= $this->input->post('kode',TRUE);
        $data['br_position']	= $this->input->post('position',TRUE);
        $data['br_bab'] 	= $this->input->post('nama',TRUE);
        $data['br_jenis'] 	= $this->input->post('jenis_bab',TRUE);
        $data['id_tahun'] 	= $this->thn_aktif;

        $q = $this->m_bab->insert($data);
        if ($q){
            fs_create_alert(['type' => 'success', 'message' => 'Data berhasil disimpan.']);
        }else{
            fs_create_alert(['type' => 'danger', 'message' => 'Data gagal disimpan.']);
        }
			redirect('admin/bab/');
	}
	
    public function update($id){
		$id = base64_decode($id);
        $data['br_kode'] 		= $this->input->post('kode',TRUE);
        $data['br_position']	= $this->input->post('position',TRUE);
        $data['br_bab'] 		= $this->input->post('nama',TRUE);
        $data['br_jenis'] 	= $this->input->post('jenis_bab',TRUE);

        $q = $this->m_bab->update($id,$data);
        if ($q){
            fs_create_alert(['type' => 'success', 'message' => 'Data berhasil diupdate.']);
        }else{
            fs_create_alert(['type' => 'danger', 'message' => 'Data gagal diupdate.']);
        }
			redirect('admin/bab/');
	}
	public function ajax_list()
	{
		$list = $this->m_bab->get_datatables();
		$data = array();

		$no = $_POST['start'];

		foreach ($list as $item) {
			$arrParam = array(
				'kode' => $item->br_kode,
				'deskripsi' => $item->br_bab,
			);
			$btnhapus = '<a href="#" onclick="hapusItem(\''.htmlspecialchars(json_encode($arrParam),ENT_QUOTES).'\')"><i class="fa fa-trash"></i>Hapus</a>';
			
			$btngroup = '<div class="input-group">
					<button type="button" class="btn btn-xs btn-default pull-right dropdown-toggle" data-toggle="dropdown">
						<span> Action
						</span>
						<i class="fa fa-caret-down"></i>
					</button>
					<ul class="dropdown-menu">
                        <li>' . anchor("admin/bab/edit/" . base64_encode($item->br_kode), "<i class=\"fa fa-edit\"></i>Edit") . '</li>
                        <li>' . anchor("admin/bab/hapus/" . base64_encode($item->br_kode), "<i class=\"fa fa-trash\"></i>Hapus") . '</li>

					</ul>
                </div>';
                
			$no++;
			$row = array();
			$row[] = $btngroup;
			$row[] = $item->br_position;
			$row[] = $item->br_kode;
			$row[] = $item->br_bab;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_bab->count_all(),
			"recordsFiltered" => $this->m_bab->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	public function delete($id)
	{
		$id = base64_decode($id);
		$data['br_kode'] = $id;
		
		if ($this->m_bab->delete($data)) {
			fs_create_alert(['type' => 'success', 'message' => 'Data Bab berhasil dihapus.']);
		} else {
			fs_create_alert(['type' => 'danger', 'message' => 'Data Bab gagal dihapus.']);
		}
		redirect('admin/bab');
	}
	
}
