<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penilaian extends User_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth();
		$this->load->model('m_penilaian');
		$this->load->model('m_cip');
		$this->load->model('m_juri');
		$this->load->model('m_kriteria');
		$this->load->model('m_jenis');

	}

	public function admin()
	{
		$this->title 	= "Data Penilaian";
		$this->content 	= "penilaian/admin";
		$this->assets 	= array('assets_admin');

		$jenis = $this->m_jenis->all()->result();
		foreach ($jenis as $item) {
			$data['jenis_cip'][$item->jc_id] = $item->jc_jenis;
		}
		$param = array(
			'data' => $data,
		);
		$this->template($param);

	}
	public function index()
	{
		$this->title 	= "Data Penilaian";
		$this->content 	= "penilaian/index";
		$this->assets 	= array('assets');

		$param = array(
			
		);
		$this->template($param);

	}
	public function listkriteria($idcip)
	{
		$idcip = base64_decode($idcip);
		$this->title 	= "Data Penilaian";
		$this->content 	= "penilaian/list_kriteria";
		$this->assets 	= array();
		$juri = $this->m_juri->by_user($this->user->u_id)->row();
		$tim 			= $this->m_cip->by_id($idcip)->row();
		$data['id_cip'] = $idcip;
		$data['nilai']  = $this->m_penilaian->datanilai_juri($idcip,$juri->j_id,$tim->id_jenis)->result();
		$param = array(
			'data' => $data,
			
		);
		$this->template($param);

	}

	public function lihat($id_cip)
	{
		$id_cip = base64_decode($id_cip);
		$this->title 	= "Data Penilaian";
		$this->content 	= "penilaian/lihat";
		$this->assets 	= array('assets_lihat');

		$tim 			= $this->m_cip->by_id($id_cip)->row();
		$kriteria 		= $this->m_kriteria->by_jenis($tim->id_jenis)->result();
		$tmp_kriteria 	= [];
		foreach ($kriteria as $item) {
			$tmp_kriteria[] = $item->kp_id;
		}
		$kriteria = $tmp_kriteria;
		$data['tim'] = $this->m_cip->by_jenis($tim->id_jenis)->result();
		$alternatif 	= [];
		foreach ($data['tim'] as $item) {
			$alternatif[] = $item->t_no_gugus;
		}
		$data['kriteria-reference'] = $this->m_penilaian->kriteria_reference($kriteria,$alternatif);
		$data['ternormalisasi'] 	= $this->m_penilaian->ternormalisasi($kriteria,$alternatif,$data['kriteria-reference']);
		$data['ideal'] 				= $this->m_penilaian->ideal($kriteria,$data['kriteria-reference'],$data['ternormalisasi']);

		$data['kriteria']			= $kriteria;
		$data['alternatif']			= $alternatif;
		$param = array(
			'data'=>$data,
		);
		$this->template($param);

	}
	public function edit($id)
	{
		$id = base64_decode($id);
		$this->title 	= "Form Penilaian";
		$this->content 	= "juri/edit";
		$this->assets 	= array();
		
		$data['juri'] = $this->m_juri->by_id($id)->row();
		
		$param = array(
			'data'	=> $data,
		);
		$this->template($param);
	}
	public function save($id_cip)
	{
		$id_cip = base64_decode($id_cip);
		$tim 			= $this->m_cip->by_id($id_cip)->row();
		$juri = $this->m_juri->by_user($this->user->u_id)->row();
		$data['nilai']  = $this->m_penilaian->datanilai_juri($id_cip,$juri->j_id,$tim->id_jenis)->result();
		$this->db->trans_begin();
		foreach ($data['nilai'] as $item) {
			$nilai['pn_nilai'] 		= $this->input->post('nilai_'.$item->kp_id,TRUE);
			$nilai['pn_komentar'] 	= $this->input->post('komentar_'.$item->kp_id,TRUE);

			$nilai['id_cip']			= $id_cip;
			$nilai['id_kriteria']	= $item->kp_id;
			$nilai['id_juri']		= $juri->j_id;
			$this->m_penilaian->insert($nilai);
		}
		if ($this->db->trans_status()===FALSE){
			$this->db->trans_rollback();
			fs_create_alert(['type' => 'danger', 'message' => 'Data gagal disimpan.']);	
			redirect('juri/penilaian/'.base64_encode($id_cip));
		}else{
			$this->db->trans_commit();
			fs_create_alert(['type' => 'success', 'message' => 'Data berhasil disimpan.']);	
			redirect('juri/penilaian/'.base64_encode($id_cip));
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
			$data['j_juri'] = $this->input->post('nama',TRUE);
			$save = $this->m_juri->update($id,$data);
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

		$list = $this->m_penilaian->get_datatables();
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
						<li>' . anchor("juri/penilaian/" . base64_encode($tps->t_no_gugus), "<i class=\"fa fa-edit\"></i>Input Nilai") . '</li>
						<li>' . anchor("juri/penilaian/hasil/" . base64_encode($tps->t_no_gugus), "<i class=\"fa fa-print\"></i>Hasil Topsis") . '</li>
					</ul>
                </div>';
               

			$kriteria 		= $this->m_kriteria->by_jenis($tps->id_jenis)->result();
			$tmp_kriteria 	= [];
			foreach ($kriteria as $item) {
				$tmp_kriteria[] = $item->kp_id;
			}
			$kriteria = $tmp_kriteria;
			$tim = $this->m_cip->by_jenis($tps->id_jenis)->result();
			$alternatif 	= [];
			foreach ($tim as $item) {
				$alternatif[] = $item->t_no_gugus;
			}

			$no++;
			$row = array();
			$row[] = $btngroup;
			$row[] = $tps->t_no_gugus;
			$row[] = $tps->t_nama_gugus;
			$row[] = $tps->jc_jenis;
			$row[] = round($this->m_penilaian->relative_closeness($tps->t_no_gugus,$kriteria,$alternatif)['s_plus'],4);
			$row[] = round($this->m_penilaian->relative_closeness($tps->t_no_gugus,$kriteria,$alternatif)['s_min'],4);
			$row[] = round($this->m_penilaian->relative_closeness($tps->t_no_gugus,$kriteria,$alternatif)['rc'],4);
			$row[] = $this->m_penilaian->rangking($tps->t_no_gugus,$kriteria,$alternatif);
			$data[] = $row;
		}


		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_penilaian->count_all(),
			"recordsFiltered" => $this->m_penilaian->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	public function ajax_admin()
	{
		$param['id_jenis'] = $this->input->post('id_jenis');
		$param['request_by'] = 'admin';
		$list = $this->m_penilaian->get_datatables($param);
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
						<li>' . anchor("juri/penilaian/hasil/" . base64_encode($tps->t_no_gugus), "<i class=\"fa fa-print\"></i>Hasil Topsis") . '</li>
					</ul>
                </div>';
               

			$kriteria 		= $this->m_kriteria->by_jenis($tps->id_jenis)->result();
			$tmp_kriteria 	= [];
			foreach ($kriteria as $item) {
				$tmp_kriteria[] = $item->kp_id;
			}
			$kriteria = $tmp_kriteria;
			$tim = $this->m_cip->by_jenis($tps->id_jenis)->result();
			$alternatif 	= [];
			foreach ($tim as $item) {
				$alternatif[] = $item->t_no_gugus;
			}

			$no++;
			$row = array();
			$row[] = $btngroup;
			$row[] = $tps->t_no_gugus;
			$row[] = $tps->t_nama_gugus;
			$row[] = $tps->jc_jenis;
			$row[] = round($this->m_penilaian->relative_closeness($tps->t_no_gugus,$kriteria,$alternatif)['s_plus'],4);
			$row[] = round($this->m_penilaian->relative_closeness($tps->t_no_gugus,$kriteria,$alternatif)['s_min'],4);
			$row[] = round($this->m_penilaian->relative_closeness($tps->t_no_gugus,$kriteria,$alternatif)['rc'],4);
			$row[] = $this->m_penilaian->rangking($tps->t_no_gugus,$kriteria,$alternatif);
			$data[] = $row;
		}


		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_penilaian->count_all($param),
			"recordsFiltered" => $this->m_penilaian->count_filtered($param),
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
