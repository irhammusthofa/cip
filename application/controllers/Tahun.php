<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tahun extends User_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth();
		$this->load->model('m_tahun');

	}
	public function index()
	{
		$this->title 	= "Data Tahun";
		$this->content 	= "tahun/index";
		$this->assets 	= array('assets');

		$param = array(
		);
		$this->template($param);
		$this->load_view('modal_hapus');
	}
	public function changetahun($thn,$redirect){
		$redirect = base64_decode($redirect);
		$this->session->set_userdata('tahun_aktif',$thn);
		redirect($redirect);
	}
	public function add()
	{
		$this->title 	= "Form Tahun";
		$this->content 	= "tahun/add";
		$this->assets 	= array();
		
		
		$param = array(
		);
		$this->template($param);
	}
	public function edit($id)
	{
		$id = base64_decode($id);
		$this->title 	= "Form Tahun";
		$this->content 	= "tahun/edit";
		$this->assets 	= array();
		
		$data['tahun'] = $this->m_tahun->by_id($id)->row();
		
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

		$save = $this->m_tahun->insert();
		if ($save){
			fs_create_alert(['type' => 'success', 'message' => 'Data berhasil disimpan.']);	
			redirect('admin/tahun');
		}else{
			fs_create_alert(['type' => 'danger', 'message' => 'Data gagal disimpan, silahkan coba lagi.']);	
			redirect('admin/tahun/add');
		}

	}
	public function update($id)
	{
		$id = base64_decode($id);
		$tahun = $this->m_tahun->by_id($id)->row();
		if (empty($tahun)){
			fs_create_alert(['type' => 'danger', 'message' => 'Data Tahun tidak ditemukan.']);	
			redirect('admin/tahun/edit/'.base64_encode($id));
			return;
		}else{
			// $data['j_juri'] = $this->input->post('nama',TRUE);

			// $data['u_name'] = $this->input->post('username',TRUE);
			// $data['u_email'] = $this->input->post('email',TRUE);
			// if (!empty($this->input->post('password',TRUE))){
			// 	$data['u_password'] = sha1($this->input->post('password',TRUE));	
			// }
			
			$save = $this->m_tahun->update($id);
			if ($save){
				fs_create_alert(['type' => 'success', 'message' => 'Data berhasil diupdate.']);	
				redirect('admin/tahun');
			}else{
				fs_create_alert(['type' => 'danger', 'message' => 'Data gagal diupdate, silahkan coba lagi.']);	
				redirect('admin/tahun/edit/'.base64_encode($id));
			}
		}

	}
	public function ajax_list()
	{

		$list = $this->m_tahun->get_datatables();
		$data = array();

		$no = $_POST['start'];

		foreach ($list as $tps) {
			$arrParam = array(
				'id' => $tps->thn_id,
			);
			$btnhapus = '<a href="#" onclick="hapusTahun(\''.htmlspecialchars(json_encode($arrParam),ENT_QUOTES).'\')"><i class="fa fa-trash"></i>Hapus</a>';
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
						<li>' . anchor("admin/tahun/edit/" . base64_encode($tps->thn_id), "<i class=\"fa fa-edit\"></i>Edit") . '</li>
						<li>' . anchor("admin/tahun/hapus/" . base64_encode($tps->thn_id), "<i class=\"fa fa-trash\"></i>Hapus") . '</li>
					</ul>
                </div>';
                
			$no++;
			$row = array();
			$row[] = $btngroup;
			$row[] = $tps->thn_id;
			$row[] = ($tps->thn_status==0) ? label_skin(['type'=>'default','text'=>'Tidak Aktif']) : label_skin(['type'=>'success','text'=>'Aktif']);
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_tahun->count_all(),
			"recordsFiltered" => $this->m_tahun->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	public function delete($id)
	{
		$id = base64_decode($id);
		$data['thn_id'] = $id;
		
		$tahun = $this->m_tahun->by_id($id)->row();
		if (empty($tahun)){
			fs_create_alert(['type' => 'danger', 'message' => 'Data Tahun tidak ditemukan.']);	
		}else if ($this->m_tahun->delete($data)) {
			fs_create_alert(['type' => 'success', 'message' => 'Data Tahun berhasil dihapus.']);
		} else {
			fs_create_alert(['type' => 'danger', 'message' => 'Data Tahun gagal dihapus.']);
		}
		redirect('admin/tahun');
	}
	
}
