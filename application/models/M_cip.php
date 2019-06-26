<?php

class M_cip extends CI_Model
{
    var $_table = 'cip';

    var $table = 'cip c';
    var $column_order = array('c.t_no_gugus', 'c.t_judul_cip','c.t_nama_gugus','c.t_didirikan','c.t_created','c.t_status'); //set column field database for datatable orderable
    var $column_search = array('c.t_no_gugus', 'c.t_judul_cip','c.t_nama_gugus','c.t_didirikan','c.t_created','c.t_status'); //set column field database for datatable searchable
    var $order = array('c.t_no_gugus' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_juri_tim');
    }

    private function _get_datatables_query($param='')
    {
        $this->db->from($this->table);
        $this->db->where('id_tahun',$this->thn_aktif);
        if ($this->user->u_role=='user'){
            $this->db->where('id_user',$this->user->u_id);
        }
        
    
        $i = 0;
        foreach ($this->column_search as $item) // loop column
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables($param='')
    {
        $this->_get_datatables_query($param);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($param='')
    {
        $this->_get_datatables_query($param);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($param='')
    {
        $this->db->from($this->table);
        $this->db->where('id_tahun',$this->thn_aktif);
        if ($this->user->u_role=='user'){
            $this->db->where('id_user',$this->user->u_id);
        }
        return $this->db->count_all_results();
    }
    public function all(){
        return $this->db->from('cip c')
            ->where('id_tahun',$this->thn_aktif)
            ->get();
    }
    public function by_id($id){
        return $this->db->from('cip c')
            ->join('user u','u.u_id=c.id_user','inner')
            ->where('id_tahun',$this->thn_aktif)
            ->where('c.t_no_gugus',$id)->get();
    }
    public function by_jenis($id){
        return $this->db->from('cip c')
            ->join('user u','u.u_id=c.id_user','inner')
            ->where('id_tahun',$this->thn_aktif)
            ->where('c.id_jenis',$id)->get();
    }
    public function signup(){
        $this->db->trans_begin();
        $data['u_email']            = $this->input->post('email',TRUE);

        if (count($this->m_user->by_email($data['u_email'])->result())>0){
			$arr = array(
				'status' => FALSE,
				'message'=> 'Email yang anda masukan sudah terdaftar,'
			);
		}else{
            $temp_id            = $this->generate_id();
            $password 			= rand(1000,9999);
            $data['u_name']     = $temp_id['origin'];
			$data['u_password'] = sha1($password);
			$data['u_status']	= 1;
			$data['u_role']	= 'user';
			if($this->m_user->insert($data)){
                $last_id = $this->db->insert_id();
				$data['password'] = $password;
                $this->m_user->sendemailsignup($data);
                $team['t_no_gugus']             = $data['u_name'];
                $team['t_nama_gugus']           = $this->input->post('nama_gugus',TRUE);
                $team['t_judul_cip']            = $this->input->post('judul_cip',TRUE);
                $team['t_nama_perusahaan']      = $this->input->post('nama_perusahaan',TRUE);
                $team['t_direktorat']           = $this->input->post('direktorat',TRUE);
                $team['t_didirikan']            = $this->input->post('didirikan',TRUE);
                $team['id_jenis']               = $this->input->post('jenis_cip',TRUE);
                $team['t_fasilitator']          = $this->input->post('fasilitator',TRUE);
                $team['t_ketua']                = $this->input->post('ketua',TRUE);
                $team['t_anggota']              = json_encode($this->input->post('anggota',TRUE));
                $team['t_kategori']             = $this->input->post('kategori',TRUE);
                $team['t_created']              = date('Y-m-d');
                $team['t_status']               = 1;
                $team['t_sekretaris']           = $this->input->post('sekretaris',TRUE);;
                $team['t_no_pekerja']           = $this->input->post('no_pekerja',TRUE);;
                $team['t_thn_pelaksanaan']      = $this->input->post('tahun_pelaksanaan',TRUE);;
                $team['id_lokasi']              = $this->input->post('lokasi',TRUE);
                $team['id_fungsi']              = $this->input->post('fungsi',TRUE);
                $team['id_user']                = $last_id;
                $team['id_temp']                = $temp_id['temp'];
                $team['id_tahun']               = $this->thn_aktif;
                $this->db->insert('cip',$team);
				$arr = array(
					'status' => TRUE,
					'message'=> 'Pendaftaran berhasil,'
				);
			}else{
				$arr = array(
					'status' => FALSE,
					'message'=> 'Pendaftaran gagal, silahkan coba kembali,'
				);
			}
		}
        
        if ($this->db->trans_status()===FALSE){
            $this->db->trans_rollback();
            return $arr;
        }else{
            $this->db->trans_commit();
            return $arr;
        }
    }
    public function tim_belum_dipilih($juri){
        $juri_tim = $this->m_juri_tim->by_juri($juri)->result();
        $id_tim = '';
        foreach ($juri_tim as $item) {
            $id_tim[] = $item->id_tim;
        }
        $this->db->from('cip c');
        if (!empty($id_tim)){
            $this->db->where_not_in('c.t_no_gugus',$id_tim); 
        }
        
        return $this->db->get();
    }
    public function generate_id(){
        // nomor/CIP-PTG/Tahun contoh (12/CIP-PTG/2019)
        $tabel = 'cip';
        $kolom = 'id_temp';
        $lebar = 3;
        $awalan = "CIP-PTG/".date('Y')."/";
        if(empty($awalan)){
            $query="select $kolom from $tabel order by $kolom desc limit 1";
        }else{
            $query="select $kolom from $tabel where $kolom like '%$awalan%' order by $kolom desc limit 1";
        }
        $hasil          = $this->db->query($query)->row();
        $jumlahrecord   = count($hasil);
        if($jumlahrecord == 0)
            $nomor=1;
        else
        {
            $row=$hasil;
            $nomor=intval(substr($row->$kolom,strlen($awalan)))+1;
        }
        if($lebar>0){
            $origin = str_pad($nomor,$lebar,"0",STR_PAD_LEFT)."/".substr($awalan,0,strlen($awalan)-1);
            $angka = $awalan.str_pad($nomor,$lebar,"0",STR_PAD_LEFT);
        }else{
            $origin = $nomor."/".substr($awalan,0,strlen($awalan)-1);
            $angka = $awalan.$nomor;
        }
        return array('temp'=>$angka,'origin'=>$origin);
    }
}
