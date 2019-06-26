<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembagiantim extends User_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth();
		$this->load->model('m_juri');
		$this->load->model('m_bab');
		$this->load->model('m_cip');
		$this->load->model('m_juri_tim');
		$this->load->model('m_risalah');

	}

	private function setCurrentStep($val){
		return $this->session->set_userdata('currentStep',$val);
	}
	private function getCurrentStep(){
		return $this->session->userdata('currentStep');
	}
	public function index($juri)
	{

		$juri = base64_decode($juri);
		$this->title 	= "Data Pembagian Tim";
		$this->content 	= "pembagiantim/index";
		$this->assets 	= array('assets');
		$data['juri'] = $this->m_juri->by_id($juri)->row();

		$param = array(
			'data' => $data,
		);
		$this->template($param);
	}
	public function add($juri)
	{
		$juri = base64_decode($juri);
		$this->title 	= "Form Pembagian Tim";
		$this->content 	= "pembagiantim/add";
		$this->assets 	= array();
		$data['juri'] = $this->m_juri->by_id($juri)->row();

		$data['pembagiantim'] = $this->m_juri_tim->by_juri($juri)->result();
		if (count($data['pembagiantim'])>=10){
			fs_create_alert(['type' => 'danger', 'message' => '1 Juri maksimal 10 Tim']);	
			redirect('admin/juri/pembagiantim/'. base64_encode($juri));
		}
		$tim = $this->m_cip->tim_belum_dipilih($juri)->result();
		$data['tim'][''] = 'Pilih Tim';
		foreach ($tim as $item) {
			if ($this->check_status($item->t_no_gugus)==3){
				$data['tim'][$item->t_no_gugus] = $item->t_nama_gugus;	
			}
		}
		$param = array(
			'data' => $data,
		);
		$this->template($param);
	}
	public function edit($juri,$id)
	{
		$juri = base64_decode($juri);
		$id = base64_decode($id);
		$this->title 	= "Form Pembagian Tim";
		$this->content 	= "pembagiantim/edit";
		$this->assets 	= array();
		
		$data['juri'] = $this->m_juri->by_id($juri)->row();
		$data['pembagiantim'] = $this->m_juri_tim->by_id($id)->row();
		$tim = $this->m_cip->tim_belum_dipilih($juri)->result();
		$data['tim'][''] = 'Pilih Tim';
		$data['tim'][$data['pembagiantim']->id_tim] = $data['pembagiantim']->t_nama_gugus;
		foreach ($tim as $item) {
			if ($this->check_status($item->t_no_gugus)==3){
				$data['tim'][$item->t_no_gugus] = $item->t_nama_gugus;	
			}
			
		}
		$param = array(
			'data'	=> $data,
		);
		$this->template($param);
	}
	public function save($juri)
	{
		$juri = base64_decode($juri);
		$data['id_juri'] = $juri;
		$data['id_tim'] = $this->input->post('tim',TRUE);

		$save = $this->m_juri_tim->insert($data);
		if ($save){
			fs_create_alert(['type' => 'success', 'message' => 'Data berhasil disimpan.']);	
			redirect('admin/juri/pembagiantim/'. base64_encode($juri));
		}else{
			fs_create_alert(['type' => 'danger', 'message' => 'Data gagal disimpan, silahkan coba lagi.']);	
			redirect('admin/juri/add/'. base64_encode($juri));
		}

	}
	public function update($juri,$id)
	{
		$id = base64_decode($id);
		$juri = base64_decode($juri);
		$ptim = $this->m_juri_tim->by_id($juri)->row();
		if (empty($ptim)){
			fs_create_alert(['type' => 'danger', 'message' => 'Data Pembagian Tim tidak ditemukan.']);	
			redirect('admin/juri/pembagiantim/edit/'.base64_encode($juri).'/'.base64_encode($id));
			return;
		}else{
			$data['id_tim'] = $this->input->post('tim',TRUE);
			$save = $this->m_juri_tim->update($id,$data);
			if ($save){
				fs_create_alert(['type' => 'success', 'message' => 'Data berhasil diupdate.']);	
				redirect('admin/juri/pembagiantim/'.base64_encode($juri));
			}else{
				fs_create_alert(['type' => 'danger', 'message' => 'Data gagal diupdate, silahkan coba lagi.']);	
				redirect('admin/juri/edit/pembagiantim/'.base64_encode($juri).'/'.base64_encode($id));
			}
		}

	}
	private function check_status($id_cip){
    	$id_cip = $id_cip;
    	$data['bab_risalah'] = $this->m_bab->all()->result();
		$data['stepStatus']  = '';
		$data['stepStatusDesc']  = '';
		$data['currentStepDesc'] = '';
		$data['urllangkah'] = "";

		$this->setCurrentStep('');
		foreach ($data['bab_risalah'] as $item) {
			$param['id_cip'] 	 = $id_cip;
			$param['id_bab'] 	 = $item->br_kode;
			if ($item->br_jenis==1){
				$q = $this->m_risalah->check_status_by_bab($param);
			}else{
				$q = $this->m_risalah->check_status_by_bab2($param);
			}
			
			if (empty($this->getCurrentStep())){

				$data['stepStatus'][$item->br_kode] = $q;
				
				if ($q==-1 || $q==0){
					$this->setCurrentStep($item->br_kode);
					$data['currentStepDesc'] = $item->br_bab;
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'sedang diisi']);
				}else if ($q==1){
					$this->setCurrentStep($item->br_kode);
					$data['currentStepDesc'] = $item->br_bab;
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'menunggu verifikasi pimpinan']);
				}else if ($q==2){
					$this->setCurrentStep($item->br_kode);
					$data['currentStepDesc'] = $item->br_bab;
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'revisi']);
				}else if ($q==4){
					$this->setCurrentStep($item->br_kode);
					$data['currentStepDesc'] = $item->br_bab;
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'menunggu verifikasi admin']);
				}else{
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'success','text'=>'selesai']);
				}
			}else{
				$data['stepStatus'][$item->br_kode] = $q;
				if($q==0 || $q==-1){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'default','text'=>'belum diisi']);
				}else if($q==1){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'menunggu verifikasi pimpinan']);
				}else if($q==2){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'revisi']);
				}else if($q==3){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'success','text'=>'selesai']);
				}else if($q==4){
					$data['stepStatusDesc'][$item->br_kode] = label_skin(['type'=>'warning','text'=>'menunggu verifikasi admin']);
				}
			}
			
			
		}
		$data['currentStep'] = $this->getCurrentStep();
		$status = "";
		foreach ($data['bab_risalah'] as $item) {
            if ($data['stepStatus'][$item->br_kode]==3){
                $status = 3;
            }else if ($data['stepStatus'][$item->br_kode]>0 || $data['currentStep'] == $item->br_kode){
            	$status = $data['stepStatus'][$item->br_kode];
            }else{

            }
        }
        return $status;
    }
	public function ajax_list()
	{

		$param['id_juri'] = $this->input->post('id_juri',TRUE);
		$list = $this->m_juri_tim->get_datatables($param);
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
						<li>' . anchor("admin/juri/pembagiantim/edit/". base64_encode($param['id_juri']).'/' . base64_encode($tps->jt_id), "<i class=\"fa fa-edit\"></i>Edit") . '</li>
						<li><div class="divider"></div></li>
						<li>' . anchor("admin/juri/pembagiantim/hapus/". base64_encode($param['id_juri']).'/' . base64_encode($tps->jt_id), "<i class=\"fa fa-trash\"></i>Hapus") . '</li>
					</ul>
                </div>';
                
			$no++;
			$row = array();
			$row[] = $btngroup;
			$row[] = $tps->t_no_gugus;
			$row[] = $tps->t_nama_gugus;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_juri_tim->count_all($param),
			"recordsFiltered" => $this->m_juri_tim->count_filtered($param),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	public function delete($juri,$id)
	{
		$id = base64_decode($id);
		$juri = base64_decode($juri);
		$data['jt_id'] = $id;
		
		$ptim = $this->m_juri_tim->by_id($id)->row();
		if (empty($ptim)){
			fs_create_alert(['type' => 'danger', 'message' => 'Data Tim tidak ditemukan.']);	
		}else if ($this->m_juri_tim->delete($data)) {
			fs_create_alert(['type' => 'success', 'message' => 'Data Tim berhasil dihapus.']);
		} else {
			fs_create_alert(['type' => 'danger', 'message' => 'Data Tim gagal dihapus.']);
		}
		redirect('admin/juri/pembagiantim/'.base64_encode($juri));
	}
	
}
