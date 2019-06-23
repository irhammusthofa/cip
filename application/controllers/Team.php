<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Team extends User_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth();
		$this->load->model('m_cip');
		$this->load->model('m_lokasi');
		$this->load->model('m_fungsi');
		$this->load->model('m_jenis');

	}
	public function index()
	{
		$this->title 	= "Data Team";
		$this->content 	= "team/index";
		$this->assets 	= array('assets');

		$param = array(
		);
		$this->template($param);
		$this->load_view('modal_hapus');
	}
	public function add()
	{
		$this->title 	= "Form Registrasi";
		$this->content 	= "team/add";
		$this->assets 	= array('assets_form');
		

		$lokasi = $this->m_lokasi->all()->result();
		$tmp = "";
		foreach ($lokasi as $row) {
			$tmp[$row->l_id] = $row->l_lokasi;
		}
        $data['lokasi'] = $tmp;

		$fungsi = $this->m_fungsi->all()->result();
		$tmp = "";
		foreach ($fungsi as $row) {
			$tmp[$row->id_fungsi] = $row->fungsi;
		}
        $data['fungsi'] = $tmp;
        
        $jenis = $this->m_jenis->all()->result();
        $data['jenis'][''] = 'Pilih Jenis CIP';

        foreach ($jenis as $row) {
        	$data['jenis'][$row->jc_id] = $row->jc_jenis; 
        }

        $data['kategori'] = [
            ''=>'Pilih Kategori',
            'NEW IDEA'=>'NEW IDEA',
            'REPLIKASI'=>'REPLIKASI',
        ];
        $data['vck'] = [
            ''=>'Pilih Kategori',
            'REVENUE/PROVIT'=>'REVENUE/PROVIT',
            'COST REDUCTION'=>'COST REDUCTION',
        ];
		$data['tahun'][''] = 'Pilih Tahun';
		$i = date('Y');
		do{
			$data['tahun'][$i] = $i;
			$i--;
		}while($i>2000);

		$param = array(
			'data'	=> $data,

		);
		$this->template($param);
	}
	public function edit($id)
	{
		$id = base64_decode($id);
		$this->title 	= "Form Registrasi";
		$this->content 	= "team/edit";
		$this->assets 	= array('assets_form');
		

		$lokasi = $this->m_lokasi->all()->result();
		$tmp = "";
		foreach ($lokasi as $row) {
			$tmp[$row->l_id] = $row->l_lokasi;
		}
        $data['lokasi'] = $tmp;

		$fungsi = $this->m_fungsi->all()->result();
		$tmp = "";
		foreach ($fungsi as $row) {
			$tmp[$row->id_fungsi] = $row->fungsi;
		}
        $data['fungsi'] = $tmp;
        
        $jenis = $this->m_jenis->all()->result();
        $data['jenis'][''] = 'Pilih Jenis CIP';

        foreach ($jenis as $row) {
        	$data['jenis'][$row->jc_id] = $row->jc_jenis; 
        }
        
        $data['kategori'] = [
            ''=>'Pilih Kategori',
            'NEW IDEA'=>'NEW IDEA',
            'REPLIKASI'=>'REPLIKASI',
        ];
		$data['tahun'][''] = 'Pilih Tahun';
		$i = date('Y');
		do{
			$data['tahun'][$i] = $i;
			$i--;
		}while($i>2000);

		$data['team'] = $this->m_cip->by_id($id)->row();
		$selected['lokasi'] = $data['team']->id_lokasi;
		$selected['fungsi'] = $data['team']->id_fungsi;
		$selected['jenis'] = $data['team']->id_jenis;
		$selected['kategori'] = $data['team']->t_kategori;
		$selected['didirikan'] = $data['team']->t_didirikan;

		$param = array(
			'data'	=> $data,
			'selected' => $selected,
		);
		$this->template($param);
	}
	public function update($id)
	{
		$id = base64_decode($id);
		$team = $this->m_cip->by_id($id)->row();
		if (empty($team)){
			fs_create_alert(['type' => 'danger', 'message' => 'Data Team tidak ditemukan.']);	
			redirect('user/registrasi/edit/'.base64_encode($id));
			return;
		}else{
			$this->db->trans_begin();
			$data['u_email']            = $this->input->post('email',TRUE);
			$cek_email = $this->m_user->by_email($data['u_email'])->row();
			if (!empty($cek_email)){
				if ($cek_email->u_id!=$team->id_user){
					fs_create_alert(['type' => 'danger', 'message' => 'Email yang anda masukan sudah terdaftar,']);	
					redirect('user/registrasi/edit/'.base64_encode($id));
				}else{
					$password 			= $this->input->post('password',TRUE);
					if (!empty($password)){
						$data['u_password'] = sha1($password);
					}
						$this->db->where('u_name',$id)->update('user',$data);
						$team = array();
						$team['t_nama_gugus']           = $this->input->post('nama_gugus',TRUE);
						$team['t_judul_cip']            = $this->input->post('judul_cip',TRUE);
						$team['t_nama_perusahaan']      = $this->input->post('nama_perusahaan',TRUE);
						$team['t_direktorat']           = $this->input->post('direktorat',TRUE);
						$team['t_didirikan']            = $this->input->post('didirikan',TRUE);
						$team['id_jenis']            	= $this->input->post('jenis_cip',TRUE);
						$team['t_fasilitator']          = $this->input->post('fasilitator',TRUE);
						$team['t_ketua']                = $this->input->post('ketua',TRUE);
						$team['t_anggota']              = json_encode($this->input->post('anggota',TRUE));
						$team['t_kategori']             = $this->input->post('kategori',TRUE);
						$team['t_sekretaris']           = $this->input->post('sekretaris',TRUE);;
						$team['t_thn_pelaksanaan']      = $this->input->post('tahun_pelaksanaan',TRUE);;
						$team['t_no_pekerja']           = $this->input->post('no_pekerja',TRUE);;
						$team['id_lokasi']              = $this->input->post('lokasi',TRUE);
						$team['id_fungsi']              = $this->input->post('fungsi',TRUE);

						if ($this->db->where('t_no_gugus',$id)->update('cip',$team)){
							$arr = 'Data berhasil diupdate';
						}else{
							$arr = 'Data gagal diupdate, silahkan coba kembali';
						}
					
				}
			}	
			if ($this->db->trans_status()===FALSE){
				$this->db->trans_rollback();
				fs_create_alert(['type' => 'danger', 'message' => $arr]);	
			}else{
				$this->db->trans_commit();
				fs_create_alert(['type' => 'success', 'message' => $arr]);	
			}
			redirect('user/registrasi/edit/'.base64_encode($id));
		}

	}
	public function ajax_list()
	{

		$list = $this->m_cip->get_datatables();
		$data = array();

		$no = $_POST['start'];

		foreach ($list as $tps) {
			$arrParam = array(
				'id' => $tps->t_no_gugus,
				'nomor' => $tps->t_no_gugus,
				'nama' => $tps->t_nama_gugus,
			);
			$btnhapus = '<a href="#" onclick="hapusCIP(\''.htmlspecialchars(json_encode($arrParam),ENT_QUOTES).'\')"><i class="fa fa-trash"></i>Hapus</a>';
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
						<li>' . anchor("user/registrasi/edit/" . base64_encode($tps->t_no_gugus), "<i class=\"fa fa-edit\"></i>Edit") . '</li>
					</ul>
                </div>';
                
			$no++;
			$row = array();
			$row[] = $btngroup;
			$row[] = $tps->t_no_gugus;
			$row[] = $tps->t_didirikan;
			$row[] = $tps->t_nama_gugus;
			$row[] = $tps->t_judul_cip;
			$row[] = $tps->t_created;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_cip->count_all(),
			"recordsFiltered" => $this->m_cip->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	public function delete($id)
	{
		$id = urldecode($id);
		$data['id_admin'] = $this->user->u_id;
		$data['sk_id'] = $id;
		
		$saksi = $this->m_saksi->by_id($id)->row();
		if (empty($saksi)){
			fs_create_alert(['type' => 'danger', 'message' => 'Data Saksi tidak ditemukan.']);	
		}else if($saksi->id_admin != $this->user->u_id){
			fs_create_alert(['type' => 'danger', 'message' => 'Data Saksi tidak ditemukan.']);	
		}else if ($this->m_saksi->delete($data)) {
			fs_create_alert(['type' => 'success', 'message' => 'Data Saksi berhasil dihapus.']);
		} else {
			fs_create_alert(['type' => 'danger', 'message' => 'Data Saksi gagal dihapus.']);
		}
		redirect('operator/saksi');
	}
	
}
