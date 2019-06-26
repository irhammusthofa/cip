<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kriteria extends User_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth();
		$this->load->model('m_kriteria');
		$this->load->model('m_jenis');

	}
	public function index()
	{
		$this->title 	= "Data Kriteria";
		$this->content 	= "kriteria/index";
		$this->assets 	= array('assets');

		$param = array(
		);
		$this->template($param);

	}
	public function add()
	{
		$this->title 	= "Form Kriteria";
		$this->content 	= "kriteria/add";
		$this->assets 	= array();
		
		$jenis = $this->m_jenis->all()->result();
		$data['jenis'][''] = 'Pilih Jenis CIP';
		foreach ($jenis as $item) {
			$data['jenis'][$item->jc_id] = $item->jc_jenis;
		}
		$param = array(
			'data' => $data,
		);
		$this->template($param);
	}
	public function edit($id)
	{
		$id = base64_decode($id);
		$this->title 	= "Form Kriteria";
		$this->content 	= "kriteria/edit";
		$this->assets 	= array();
		
		$data['kriteria'] = $this->m_kriteria->by_id($id)->row();
		$jenis = $this->m_jenis->all()->result();
		$data['jenis'][''] = 'Pilih Jenis CIP';
		foreach ($jenis as $item) {
			$data['jenis'][$item->jc_id] = $item->jc_jenis;
		}

		$param = array(
			'data'	=> $data,
		);
		$this->template($param);
	}
	public function save()
	{
		$data['kp_id'] = $this->input->post('id',TRUE);
		$data['kp_kriteria'] = $this->input->post('nama',TRUE);
		$data['id_jenis_cip'] = $this->input->post('jenis',TRUE);
		$data['kp_nilai_kriteria'] = $this->input->post('bobot',TRUE);
		$data['id_tahun'] = $this->thn_aktif;

		$save = $this->m_kriteria->insert($data);
		if ($save){
			fs_create_alert(['type' => 'success', 'message' => 'Data berhasil disimpan.']);	
			redirect('admin/kriteria');
		}else{
			fs_create_alert(['type' => 'danger', 'message' => 'Data gagal disimpan, silahkan coba lagi.']);	
			redirect('admin/kriteria/add');
		}

	}
	public function update($id)
	{
		$id = base64_decode($id);
		$kriteria = $this->m_kriteria->by_id($id)->row();
		if (empty($kriteria)){
			fs_create_alert(['type' => 'danger', 'message' => 'Data Juri tidak ditemukan.']);	
			redirect('admin/kriteria/edit/'.base64_encode($id));
			return;
		}else{
			$data['kp_id'] = $this->input->post('id',TRUE);
			$data['kp_kriteria'] = $this->input->post('nama',TRUE);
			$data['id_jenis_cip'] = $this->input->post('jenis',TRUE);
			$data['kp_nilai_kriteria'] = $this->input->post('bobot',TRUE);
			$save = $this->m_kriteria->update($id,$data);
			if ($save){
				fs_create_alert(['type' => 'success', 'message' => 'Data berhasil diupdate.']);	
				redirect('admin/kriteria');
			}else{
				fs_create_alert(['type' => 'danger', 'message' => 'Data gagal diupdate, silahkan coba lagi.']);	
				redirect('admin/kriteria/edit/'.base64_encode($id));
			}
		}

	}
	public function ajax_list()
	{

		$list = $this->m_kriteria->get_datatables();
		$data = array();

		$no = $_POST['start'];

		foreach ($list as $tps) {

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
						<li>' . anchor("admin/kriteria/edit/" . base64_encode($tps->kp_id), "<i class=\"fa fa-edit\"></i>Edit") . '</li>
						<li>' . anchor("admin/kriteria/hapus/" . base64_encode($tps->kp_id), "<i class=\"fa fa-trash\"></i>Hapus") . '</li>
					</ul>
                </div>';
                
			$no++;
			$row = array();
			$row[] = $btngroup;
			$row[] = $tps->kp_id;
			$row[] = $tps->kp_kriteria;
			$row[] = $tps->jc_jenis;
			$row[] = $tps->kp_nilai_kriteria;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_kriteria->count_all(),
			"recordsFiltered" => $this->m_kriteria->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	public function delete($id)
	{
		$id = base64_decode($id);
		$data['kp_id'] = $id;
		
		$kriteria = $this->m_kriteria->by_id($id)->row();
		if (empty($kriteria)){
			fs_create_alert(['type' => 'danger', 'message' => 'Data Kriteria tidak ditemukan.']);	
		}else if ($this->m_kriteria->delete($data)) {
			fs_create_alert(['type' => 'success', 'message' => 'Data Kriteria berhasil dihapus.']);
		} else {
			fs_create_alert(['type' => 'danger', 'message' => 'Data Kriteria gagal dihapus.']);
		}
		redirect('admin/kriteria');
	}
	
}
