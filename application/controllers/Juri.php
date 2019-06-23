<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Juri extends User_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth();
		$this->load->model('m_juri');

	}
	public function index()
	{
		$this->title 	= "Data Juri";
		$this->content 	= "juri/index";
		$this->assets 	= array('assets');

		$param = array(
		);
		$this->template($param);
		$this->load_view('modal_hapus');
	}
	public function add()
	{
		$this->title 	= "Form Juri";
		$this->content 	= "juri/add";
		$this->assets 	= array();
		
		
		$param = array(
		);
		$this->template($param);
	}
	public function edit($id)
	{
		$id = base64_decode($id);
		$this->title 	= "Form Juri";
		$this->content 	= "juri/edit";
		$this->assets 	= array();
		
		$data['juri'] = $this->m_juri->by_id($id)->row();
		
		$param = array(
			'data'	=> $data,
		);
		$this->template($param);
	}
	public function save()
	{
		// $data['j_juri'] = $this->input->post('nama',TRUE);
		// $data['u_name'] = $this->input->post('username',TRUE);
		// $data['u_email'] = $this->input->post('email',TRUE);
		// $data['u_password'] = sha1($this->input->post('password',TRUE));

		$save = $this->m_juri->insert();
		if ($save){
			fs_create_alert(['type' => 'success', 'message' => 'Data berhasil disimpan.']);	
			redirect('admin/juri');
		}else{
			fs_create_alert(['type' => 'danger', 'message' => 'Data gagal disimpan, silahkan coba lagi.']);	
			redirect('admin/juri/add');
		}

	}
	public function update($id)
	{
		$id = base64_decode($id);
		$juri = $this->m_juri->by_id($id)->row();
		if (empty($juri)){
			fs_create_alert(['type' => 'danger', 'message' => 'Data Juri tidak ditemukan.']);	
			redirect('admin/juri/edit/'.base64_encode($id));
			return;
		}else{
			// $data['j_juri'] = $this->input->post('nama',TRUE);

			// $data['u_name'] = $this->input->post('username',TRUE);
			// $data['u_email'] = $this->input->post('email',TRUE);
			// if (!empty($this->input->post('password',TRUE))){
			// 	$data['u_password'] = sha1($this->input->post('password',TRUE));	
			// }
			
			$save = $this->m_juri->update($id);
			if ($save){
				fs_create_alert(['type' => 'success', 'message' => 'Data berhasil diupdate.']);	
				redirect('admin/juri');
			}else{
				fs_create_alert(['type' => 'danger', 'message' => 'Data gagal diupdate, silahkan coba lagi.']);	
				redirect('admin/juri/edit/'.base64_encode($id));
			}
		}

	}
	public function ajax_list()
	{

		$list = $this->m_juri->get_datatables();
		$data = array();

		$no = $_POST['start'];

		foreach ($list as $tps) {
			$arrParam = array(
				'id' => $tps->j_id,
				'nama' => $tps->j_juri,
			);
			$btnhapus = '<a href="#" onclick="hapusJuri(\''.htmlspecialchars(json_encode($arrParam),ENT_QUOTES).'\')"><i class="fa fa-trash"></i>Hapus</a>';
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
						<li>' . anchor("admin/juri/edit/" . base64_encode($tps->j_id), "<i class=\"fa fa-edit\"></i>Edit") . '</li>
						<li>' . anchor("admin/juri/pembagiantim/" . base64_encode($tps->j_id), "<i class=\"fa fa-user\"></i>Pembagian Tim") . '</li>
						<li><div class="divider"></div></li>
						<li>' . anchor("admin/juri/hapus/" . base64_encode($tps->j_id), "<i class=\"fa fa-trash\"></i>Hapus") . '</li>
					</ul>
                </div>';
                
			$no++;
			$row = array();
			$row[] = $btngroup;
			$row[] = $tps->j_juri;
			$row[] = $tps->u_name;
			$row[] = $tps->u_email;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_juri->count_all(),
			"recordsFiltered" => $this->m_juri->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	public function delete($id)
	{
		$id = base64_decode($id);
		$data['j_id'] = $id;
		
		$juri = $this->m_juri->by_id($id)->row();
		if (empty($juri)){
			fs_create_alert(['type' => 'danger', 'message' => 'Data Juri tidak ditemukan.']);	
		}else if ($this->m_juri->delete($data)) {
			fs_create_alert(['type' => 'success', 'message' => 'Data Juri berhasil dihapus.']);
		} else {
			fs_create_alert(['type' => 'danger', 'message' => 'Data Juri gagal dihapus.']);
		}
		redirect('admin/juri');
	}
	
}
