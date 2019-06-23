<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subbab extends User_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->auth();
		$this->load->model('m_langkah');
		$this->load->model('m_subbab');

	}
	public function index()
	{
		$this->title 	= "Sub Bab";
		$this->content 	= "subbab/index";
		$this->assets 	= array('assets');
		$param = array(

		);
		$this->template($param);

    }
	public function add()
	{
		$this->title 	= "Tambah Sub Bab";
		$this->content 	= "subbab/add";
        $this->assets 	= array('assets_form');
        $bab    = $this->m_langkah->all()->result();

        $data['langkah']['']    = 'Pilih Langkah';
        foreach ($bab as $item) {
			if ($item->br_jenis<1){
				continue;
			}else{
				$data['langkah'][$item->ln_id] = $item->ln_langkah;
			}
        }
		$param = array(
            'data'=>$data,
		);
		$this->template($param);
	}
	
	public function edit($id)
	{
		$id = base64_decode($id);
		$this->title 	= "Edit Sub Bab";
		$this->content 	= "subbab/edit";
        $this->assets 	= array('assets_form');
        
        $bab    = $this->m_langkah->all()->result();
        $data['langkah']['']    = 'Pilih Langkah';
        foreach ($bab as $item) {
            if ($item->br_jenis<1){
				continue;
			}else{
				$data['langkah'][$item->ln_id] = $item->ln_langkah;
			}
        }

        $data['subbab'] = $this->m_subbab->by_id($id)->row();
        
		$param = array(
			'data' => $data,
		);
		$this->template($param);
    }
    public function simpan(){
        
        $data['sb_id'] 	    = $this->input->post('kode',TRUE);
        $data['sb_sub_bab'] = $this->input->post('subbab',TRUE);
        $data['sb_template'] = $this->input->post('template');
        $data['id_langkah']     = $this->input->post('langkah',TRUE);

        $q = $this->m_subbab->insert($data);
        if ($q){
            fs_create_alert(['type' => 'success', 'message' => 'Data berhasil disimpan.']);
        }else{
            fs_create_alert(['type' => 'danger', 'message' => 'Data gagal disimpan.']);
        }
			redirect('admin/subbab/');
	}
	
    public function update($id){
		$id = base64_decode($id);
        $data['sb_id'] 	    = $this->input->post('kode',TRUE);
        $data['sb_sub_bab'] = $this->input->post('subbab',TRUE);
        $data['sb_template'] = $this->input->post('template');
        $data['id_langkah']     = $this->input->post('langkah',TRUE);

        $q = $this->m_subbab->update($id,$data);
        if ($q){
            fs_create_alert(['type' => 'success', 'message' => 'Data berhasil diupdate.']);
        }else{
            fs_create_alert(['type' => 'danger', 'message' => 'Data gagal diupdate.']);
        }
			redirect('admin/subbab/');
	}
	public function ajax_list()
	{
		$list = $this->m_subbab->get_datatables();
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
                        <li>' . anchor("admin/subbab/edit/" . base64_encode($item->sb_id), "<i class=\"fa fa-edit\"></i>Edit") . '</li>
                        <li>' . anchor("admin/subbab/hapus/" . base64_encode($item->sb_id), "<i class=\"fa fa-trash\"></i>Hapus") . '</li>

					</ul>
                </div>';
                
			$no++;
			$row = array();
			$row[] = $btngroup;
			$row[] = $item->sb_id;
			$row[] = $item->sb_sub_bab;
			$row[] = $item->ln_langkah;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_subbab->count_all(),
			"recordsFiltered" => $this->m_subbab->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	public function delete($id)
	{
		$id = base64_decode($id);
		$data['sb_id'] = $id;
		
		if ($this->m_subbab->delete($data)) {
			fs_create_alert(['type' => 'success', 'message' => 'Data berhasil dihapus.']);
		} else {
			fs_create_alert(['type' => 'danger', 'message' => 'Data gagal dihapus.']);
		}
		redirect('admin/subbab');
	}
	
}
