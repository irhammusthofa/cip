<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Langkah extends User_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->auth();
		$this->load->model('m_langkah');
		$this->load->model('m_bab');

	}
	public function index()
	{
		$this->title 	= "Langkah";
		$this->content 	= "langkah/index";
		$this->assets 	= array('assets');
		$param = array(

		);
		$this->template($param);
    }
	public function add()
	{
		$this->title 	= "Tambah Langkah";
		$this->content 	= "langkah/add";
        $this->assets 	= array('assets_form');
        $bab    = $this->m_bab->all()->result();
        $data['bab']['']    = 'Pilih BAB';
        foreach ($bab as $item) {
            $data['bab'][$item->br_kode] = $item->br_bab;
        }
		$param = array(
            'data'=>$data,
		);
		$this->template($param);
	}
	
	public function edit($id)
	{
		$id = base64_decode($id);
		$this->title 	= "Edit Langkah";
		$this->content 	= "langkah/edit";
        $this->assets 	= array('assets_form');
        
        $bab    = $this->m_bab->all()->result();
        $data['bab']['']    = 'Pilih BAB';
        foreach ($bab as $item) {
            $data['bab'][$item->br_kode] = $item->br_bab;
        }

        $data['langkah'] = $this->m_langkah->by_id($id)->row();
        
		$param = array(
			'data' => $data,
		);
		$this->template($param);
    }
    public function simpan(){
        
        $data['ln_id'] 	    = $this->input->post('kode',TRUE);
        $data['ln_langkah'] = $this->input->post('langkah',TRUE);
        $data['id_bab']     = $this->input->post('kode_bab',TRUE);
        $data['ln_ver_pimpinan']     = $this->input->post('ver_pimpinan',TRUE);

        $q = $this->m_langkah->insert($data);
        if ($q){
            fs_create_alert(['type' => 'success', 'message' => 'Data berhasil disimpan.']);
        }else{
            fs_create_alert(['type' => 'danger', 'message' => 'Data gagal disimpan.']);
        }
			redirect('admin/langkah/');
	}
	
    public function update($id){
		$id = base64_decode($id);
        $data['ln_id'] 	    = $this->input->post('kode',TRUE);
        $data['ln_langkah'] = $this->input->post('langkah',TRUE);
        $data['id_bab']     = $this->input->post('kode_bab',TRUE);
        $data['ln_ver_pimpinan']     = $this->input->post('ver_pimpinan',TRUE);

        $q = $this->m_langkah->update($id,$data);
        if ($q){
            fs_create_alert(['type' => 'success', 'message' => 'Data berhasil diupdate.']);
        }else{
            fs_create_alert(['type' => 'danger', 'message' => 'Data gagal diupdate.']);
        }
			redirect('admin/langkah/');
	}
	public function ajax_list()
	{
		$list = $this->m_langkah->get_datatables();
		$data = array();

		$no = $_POST['start'];

		foreach ($list as $item) {
			
			$btngroup = '<div class="input-group">
					<button type="button" class="btn btn-xs btn-default pull-right dropdown-toggle" data-toggle="dropdown">
						<span> Action
						</span>
						<i class="fa fa-caret-down"></i>
					</button>
					<ul class="dropdown-menu">
                        <li>' . anchor("admin/langkah/edit/" . base64_encode($item->ln_id), "<i class=\"fa fa-edit\"></i>Edit") . '</li>
                        <li>' . anchor("admin/langkah/hapus/" . base64_encode($item->ln_id), "<i class=\"fa fa-trash\"></i>Hapus") . '</li>

					</ul>
                </div>';
                
			$no++;
			$row = array();
			$row[] = $btngroup;
			$row[] = $item->ln_id;
			$row[] = $item->ln_langkah;
			$row[] = $item->br_bab;
			$row[] = ($item->ln_ver_pimpinan==0) ? label_skin(['type'=>'default','text'=>'Tidak']) : label_skin(['type'=>'success','text'=>'Ya']);
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_langkah->count_all(),
			"recordsFiltered" => $this->m_langkah->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	public function delete($id)
	{
		$id = base64_decode($id);
		$data['ln_id'] = $id;
		
		if ($this->m_langkah->delete($data)) {
			fs_create_alert(['type' => 'success', 'message' => 'Data berhasil dihapus.']);
		} else {
			fs_create_alert(['type' => 'danger', 'message' => 'Data gagal dihapus.']);
		}
		redirect('admin/langkah');
	}
	
}
