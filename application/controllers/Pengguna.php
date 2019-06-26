<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends User_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth();
		$this->load->model('m_pengguna');

	}
	public function index()
	{
		$this->title 	= "Data Pengguna";
		$this->content 	= "pengguna/index";
		$this->assets 	= array('assets');

		$param = array(
		);
		$this->template($param);
		
	}
	public function add()
	{
		$this->title 	= "Form Pengguna";
		$this->content 	= "pengguna/add";
		$this->assets 	= array();
		
		
		$param = array(
		);
		$this->template($param);
	}
	public function edit($id)
	{
		$id = base64_decode($id);
		$this->title 	= "Form Pengguna";
		$this->content 	= "pengguna/edit";
		$this->assets 	= array();
		
		$data['pengguna'] = $this->m_pengguna->by_id($id)->row();
		
		$param = array(
			'data'	=> $data,
		);
		$this->template($param);
	}
	public function save()
	{
		$save = $this->m_pengguna->insert();
		if ($save){
			fs_create_alert(['type' => 'success', 'message' => 'Data berhasil disimpan.']);	
			redirect('admin/pengguna');
		}else{
			fs_create_alert(['type' => 'danger', 'message' => 'Data gagal disimpan, silahkan coba lagi.']);	
			redirect('admin/pengguna/add');
		}

	}
	public function update($id)
	{
		$id = base64_decode($id);
		$pengguna = $this->m_pengguna->by_id($id)->row();
		if (empty($pengguna)){
			fs_create_alert(['type' => 'danger', 'message' => 'Data Pengguna tidak ditemukan.']);	
			redirect('admin/pengguna/edit/'.base64_encode($id));
			return;
		}else{
			
			
			$save = $this->m_pengguna->update($id);
			if ($save){
				fs_create_alert(['type' => 'success', 'message' => 'Data berhasil diupdate.']);	
				redirect('admin/pengguna');
			}else{
				fs_create_alert(['type' => 'danger', 'message' => 'Data gagal diupdate, silahkan coba lagi.']);	
				redirect('admin/pengguna/edit/'.base64_encode($id));
			}
		}

	}
	public function ajax_list()
	{

		$list = $this->m_pengguna->get_datatables();
		$data = array();

		$no = $_POST['start'];

		foreach ($list as $tps) {
			$arrParam = array(
				'id' => $tps->u_id,
				'nama' => $tps->u_name,
			);
			
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
						<li>' . anchor("admin/pengguna/edit/" . base64_encode($tps->u_id), "<i class=\"fa fa-edit\"></i>Edit") . '</li>
						<li>' . anchor("admin/pengguna/hapus/" . base64_encode($tps->u_id), "<i class=\"fa fa-trash\"></i>Hapus") . '</li>
					</ul>
                </div>';
                
			$no++;
			$row = array();
			$row[] = $btngroup;
			$row[] = $tps->u_name;
			$row[] = $tps->u_email;
			$row[] = convert_status_account($tps->u_status,true);
			$row[] = $tps->u_role;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_pengguna->count_all(),
			"recordsFiltered" => $this->m_pengguna->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	public function delete($id)
	{
		$id = base64_decode($id);
		$data['u_id'] = $id;
		
		$pengguna = $this->m_pengguna->by_id($id)->row();
		if (empty($pengguna)){
			fs_create_alert(['type' => 'danger', 'message' => 'Data Pengguna tidak ditemukan.']);	
		}else if ($this->m_pengguna->delete($data)) {
			fs_create_alert(['type' => 'success', 'message' => 'Data Pengguna berhasil dihapus.']);
		} else {
			fs_create_alert(['type' => 'danger', 'message' => 'Data Pengguna gagal dihapus.']);
		}
		redirect('admin/pengguna');
	}
	
}
