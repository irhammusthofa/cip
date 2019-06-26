<?php

class M_risalah extends CI_Model
{
    var $_table = 'sub_bab';

    var $table = 'sub_bab sb';
    var $table2 = 'langkah sb';
    var $column_order = array('sb.sb_id', 'c.r_value','sb.sb_sub_bab','c.id_cip','c.r_status','ln.ln_langkah','br.br_bab'); //set column field database for datatable orderable
    var $column_order2 = array('sb.ln_id', 'c.r_value','sb.sb_sub_bab','c.id_cip','c.r_status','ln.ln_langkah','br.br_bab'); //set column field database for datatable orderable
    var $column_search2 = array('sb.ln_id', 'c.r_value','sb.sb_sub_bab','c.id_cip','c.r_status','ln.ln_langkah','br.br_bab'); //set column field database for datatable searchable
    var $column_search = array('sb.sb_id', 'c.r_value','sb.sb_sub_bab','c.id_cip','c.r_status','ln.ln_langkah','br.br_bab'); //set column field database for datatable searchable
    var $order = array('sb.sb_id' => 'asc'); // default order
    var $order2 = array('sb.ln_id' => 'asc'); // default order

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_bab');
    }

    private function _get_datatables_query($param='')
    {
        $this->db->from($this->table);
        $this->db->join('langkah ln','ln.ln_id=sb.id_langkah','inner');
        if (empty($param['id_bab'])){
            $param['id_bab'] = 'notfound';
        }
        $this->db->join('bab_risalah br','br.br_kode=ln.id_bab and br.br_kode="'.$param['id_bab'].'"','inner');
        $this->db->join('risalah_editor c','c.id_kode=sb.sb_id and c.id_cip="'.$param['id_cip'].'"','left');
        
    
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
    private function _get_datatables_query2($param='')
    {
        $this->db->from($this->table2);
        $this->db->join('bab_risalah br','br.br_kode=sb.id_bab and br.br_kode="'.$param['id_bab'].'"','inner');
        $this->db->join('risalah_editor_2 c','c.id_kode=sb.ln_id and c.id_cip="'.$param['id_cip'].'"','left');
        
    
        $i = 0;
        foreach ($this->column_search2 as $item) // loop column
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

                if(count($this->column_search2) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order2))
        {
            $order = $this->order2;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables($param='')
    {

        $bab = $this->m_bab->by_id($param['id_bab'])->row();
        if (!empty($bab)){
            if ($bab->br_jenis==1){
                $this->_get_datatables_query($param);
            }else{
                $this->_get_datatables_query2($param);
            }
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }else{
            
            $this->_get_datatables_query($param);
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
        
        
        
    }

    function count_filtered($param='')
    {
        $bab = $this->m_bab->by_id($param['id_bab'])->row();
        if (!empty($bab)){
            if ($bab->br_jenis==1){
                $this->_get_datatables_query($param);
            }else{
                $this->_get_datatables_query2($param);
            }
        }else{
            $this->_get_datatables_query($param);
        }

        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($param='')
    {
        $bab = $this->m_bab->by_id($param['id_bab'])->row();
        if (!empty($bab)){
            if ($bab->br_jenis==1){
                $this->db->from($this->table);
                $this->db->join('langkah ln','ln.ln_id=sb.id_langkah','inner');
                $this->db->join('bab_risalah br','br.br_kode=ln.id_bab and br.br_kode="'.$param['id_bab'].'"','inner');
                $this->db->join('risalah_editor c','c.id_kode=sb.sb_id and c.id_cip="'.$param['id_cip'].'"','left');
                
            }else{
                $this->db->from($this->table2);
                $this->db->join('bab_risalah br','br.br_kode=sb.id_bab and br.br_kode="'.$param['id_bab'].'"','inner');
                $this->db->join('risalah_editor_2 c','c.id_kode=sb.ln_id and c.id_cip="'.$param['id_cip'].'"','left');
                
            }
        }else{
            $param['id_bab'] = 'notfound';
            $this->db->from($this->table);
            $this->db->join('langkah ln','ln.ln_id=sb.id_langkah','inner');
            $this->db->join('bab_risalah br','br.br_kode=ln.id_bab and br.br_kode="'.$param['id_bab'].'"','inner');
            $this->db->join('risalah_editor c','c.id_kode=sb.sb_id and c.id_cip="'.$param['id_cip'].'"','left');
        }
        
        return $this->db->count_all_results();
    }
    
    public function reditor_bab_by_cip_2($param){
        return $this->db->from('risalah_editor_2 re')
                ->join('langkah ln','ln.ln_id=re.id_kode','inner')
                ->join('bab_risalah br','br.br_kode=ln.id_bab','inner')
                ->where('id_cip',$param['id_cip'])
                ->where('br.br_kode',$param['id_bab'])
                ->order_by('br.br_kode','asc')
                ->order_by('ln.ln_id','asc')
                ->get();
    }
    public function reditor_bab_by_cip($param){
        return $this->db->from('risalah_editor re')
                ->join('sub_bab sb','sb.sb_id=re.id_kode','inner')
                ->join('langkah ln','ln.ln_id=sb.id_langkah','inner')
                ->join('bab_risalah br','br.br_kode=ln.id_bab','inner')
                ->where('id_cip',$param['id_cip'])
                ->where('br.br_kode',$param['id_bab'])
                ->order_by('br.br_kode','asc')
                ->order_by('ln.ln_id','asc')
                ->order_by('sb.sb_id','asc')
                ->get();
    }
    public function reditor_all_by_cip($id_cip){
        return $this->db->from('risalah_editor re')
                ->join('sub_bab sb','sb.sb_id=re.id_kode','inner')
                ->join('langkah ln','ln.ln_id=sb.id_langkah','inner')
                ->join('bab_risalah br','br.br_kode=ln.id_bab','inner')
                ->where('id_cip',$id_cip)
                ->order_by('br.br_kode','asc')
                ->order_by('ln.ln_id','asc')
                ->order_by('sb.sb_id','asc')
                ->get();
    }
    public function check_status_by_bab($param='')
    {
        $query = $this->db->from($this->table)
                ->join('langkah ln','ln.ln_id=sb.id_langkah','inner')
                ->join('bab_risalah br','br.br_kode=ln.id_bab and br.br_kode="'.$param['id_bab'].'"','inner')
                ->join('risalah_editor c','c.id_kode=sb.sb_id and c.id_cip="'.$param['id_cip'].'"','left');
        $q = $query->get()->result();
        if (count($q) <= 0){
            return -1;
        }else{
            $status = 5;
            foreach ($q as $item) {
                if ($status > $item->r_status) $status = $item->r_status;
            }
            return $status;
        }
        
    }
    public function check_status_by_bab2($param='')
    {
        $query = $this->db->from('langkah ln')
                ->join('bab_risalah br','br.br_kode=ln.id_bab and br.br_kode="'.$param['id_bab'].'"','inner')
                ->join('risalah_editor_2 c','c.id_kode=ln.ln_id and c.id_cip="'.$param['id_cip'].'"','left');
        $q = $query->get()->result();
        if (count($q) <= 0){
            return -1;
        }else{
            $status = 5;
            foreach ($q as $item) {
                if ($status > $item->r_status) $status = $item->r_status;
            }
            return $status;
        }
        
    }
    public function check_nilai_by_bab($param='')
    {
        $query = $this->db->from($this->table)
                ->join('langkah ln','ln.ln_id=sb.id_langkah','inner')
                ->join('bab_risalah br','br.br_kode=ln.id_bab and br.br_kode="'.$param['id_bab'].'"','inner')
                ->join('risalah_editor c','c.id_kode=sb.sb_id and c.id_cip="'.$param['id_cip'].'"','left');
        $q = $query->get()->result();
        if (count($q) <= 0){
            return -1;
        }else{
            foreach ($q as $item) {
                if (empty($item->r_value)) return 1;
            }
            return 2;
        }
        
    }
    public function check_nilai_by_bab2($param='')
    {
        $query = $this->db->from('langkah ln')
                ->join('bab_risalah br','br.br_kode=ln.id_bab and br.br_kode="'.$param['id_bab'].'"','inner')
                ->join('risalah_editor_2 c','c.id_kode=ln.ln_id and c.id_cip="'.$param['id_cip'].'"','left');
        $q = $query->get()->result();
        if (count($q) <= 0){
            return -1;
        }else{
            foreach ($q as $item) {
                if (empty($item->r_value)) return 1;
            }
            return 2;
        }
        
    }
    public function check_status_by_cip_2($param='')
    {
        $query = $this->db->from('sub_bab sb')
                ->join('risalah_editor c','c.id_kode=sb.sb_id and c.id_cip="'.$param['id_cip'].'"','left');
        $q = $query->get()->result();
        if (count($q) <= 0){
            return -1;
        }else{
            $status = 5;
            foreach ($q as $item) {
                if (empty($item->r_value) && $item->r_status == 0){
                    if (-1 < $status){
                        $status = -1;    
                    }
                }else if (!empty($item->r_value) && $item->r_status == 0){
                    if (0 < $status){
                        $status = 0;    
                    }
                }else if($item->r_status === NULL || empty($item->r_status)){
                    $status = -1;    
                }else{ 
                    if ($item->r_status == 1 || $item->r_status==4){
                        $status = $item->r_status; 
                    }else if ($status > $item->r_status){
                        $status = $item->r_status;    
                    }
                }
            }
            return $status;
        }
        
    }
    public function check_status_by_cip($param='')
    {
        $query = $this->db->from('langkah ln')
                ->join('risalah_editor_2 c','c.id_kode=ln.ln_id and c.id_cip="'.$param['id_cip'].'"','left');
        $q = $query->get()->result();
        if (count($q) <= 0){
            return -1;
        }else{
            $status = 5;
            foreach ($q as $item) {
                if (empty($item->r_value) && $item->r_status == 0){
                    if (-1 < $status){
                        $status = -1;    
                    }
                }else if (!empty($item->r_value) && $item->r_status == 0){
                    if (0 < $status){
                        $status = 0;    
                    }
                }else if($item->r_status === NULL || empty($item->r_status)){
                    $status = -1;    
                }else{ 
                    if ($item->r_status == 1 || $item->r_status==4){
                        $status = $item->r_status; 
                    }else if ($status > $item->r_status){
                        $status = $item->r_status;    
                    }
                }
            }
            return $status;
        }
        
    }
    public function admin_approve($param='')
    {
        $bab = $this->m_bab->by_id($param['id_bab'])->row();
        if ($bab->br_jenis==0){
            $query = $this->db->from('langkah ln')
                ->join('bab_risalah br','br.br_kode=ln.id_bab and br.br_kode="'.$param['id_bab'].'"','inner')
                ->join('risalah_editor_2 c','c.id_kode=ln.ln_id and c.id_cip="'.$param['id_cip'].'"','left')
                ->get()->result();
            $id_risalah = [];
            foreach ($query as $val) {
                $id_risalah[] = $val->r_id;
            }
            return $this->db->where_in('r_id',$id_risalah)->update('risalah_editor_2',['r_status'=>3]);
        }else{
            $query = $this->db->from('sub_bab sb')
                ->join('langkah ln','ln.ln_id=sb.id_langkah','inner')
                ->join('bab_risalah br','br.br_kode=ln.id_bab and br.br_kode="'.$param['id_bab'].'"','inner')
                ->join('risalah_editor c','c.id_kode=sb.sb_id and c.id_cip="'.$param['id_cip'].'"','left')
                ->get()->result();
            $id_risalah = [];
            foreach ($query as $val) {
                $id_risalah[] = $val->r_id;
            }
            return $this->db->where_in('r_id',$id_risalah)->update('risalah_editor',['r_status'=>3]);
        }
        
    }
    public function admin_tolak($param='')
    {
        $bab = $this->m_bab->by_id($param['id_bab'])->row();
        if ($bab->br_jenis==0){
            $query = $this->db->from('langkah ln')
                ->join('bab_risalah br','br.br_kode=ln.id_bab and br.br_kode="'.$param['id_bab'].'"','inner')
                ->join('risalah_editor_2 c','c.id_kode=ln.ln_id and c.id_cip="'.$param['id_cip'].'"','left')
                ->get()->result();
            $id_risalah = [];
            foreach ($query as $val) {
                $id_risalah[] = $val->r_id;
            }

            if (count($id_risalah)>0){
                 $cari_komentar = $this->db->where('id_cip',$param['id_cip'])
                    ->where('id_bab',$param['id_bab'])
                    ->get('komentar')->row();
                if (empty($cari_komentar)){
                    $this->db->insert('komentar',$param);
                }else{
                    $this->db->where('id_cip',$param['id_cip'])
                    ->where('id_bab',$param['id_bab'])
                    ->update('komentar',$param);
                }
            }           
            return $this->db->where_in('r_id',$id_risalah)->update('risalah_editor_2',['r_status'=>2]);
        }else{
            $query = $this->db->from('sub_bab sb')
                ->join('langkah ln','ln.ln_id=sb.id_langkah','inner')
                ->join('bab_risalah br','br.br_kode=ln.id_bab and br.br_kode="'.$param['id_bab'].'"','inner')
                ->join('risalah_editor c','c.id_kode=sb.sb_id and c.id_cip="'.$param['id_cip'].'"','left')
                ->get()->result();
            $id_risalah = [];
            foreach ($query as $val) {
                $id_risalah[] = $val->r_id;
            }

            if (count($id_risalah)>0){
                 $cari_komentar = $this->db->where('id_cip',$param['id_cip'])
                    ->where('id_bab',$param['id_bab'])
                    ->get('komentar')->row();
                if (empty($cari_komentar)){
                    $this->db->insert('komentar',$param);
                }else{
                    $this->db->where('id_cip',$param['id_cip'])
                    ->where('id_bab',$param['id_bab'])
                    ->update('komentar',$param);
                }
            }

            return $this->db->where_in('r_id',$id_risalah)->update('risalah_editor',['r_status'=>2]);

        }
        
    }
    public function lihat_komentar($param){
        return $this->db
            ->where('id_bab',$param['id_bab'])
            ->where('id_cip',$param['id_cip'])
            ->get('komentar');
            
    }
    public function rkode_by_kode2($kode){
        return $this->db->where('ln_id',$kode)->get('langkah');
    }
    public function rkode_by_kode($kode){
        return $this->db->where('sb_id',$kode)->get('sub_bab');
    }
    public function reditor_by_kode_cip2($kode,$id_cip){
        return $this->db->where('id_kode',$kode)->where('id_cip',$id_cip)->get('risalah_editor_2');
    }
    public function reditor_by_kode_cip($kode,$id_cip){
        return $this->db->where('id_kode',$kode)->where('id_cip',$id_cip)->get('risalah_editor');
    }
    public function delete($param){
        return $this->db->delete('risalah_editor',$param);
    }
    public function simpanbab($param,$data){
        return $this->db
            ->where('id_cip',$param['id_cip'])
            ->where_in('id_kode',$param['id_kode'])
            ->update('risalah_editor',$data);
    }
    public function simpanbab2($param,$data){
        return $this->db->where('id_cip',$param['id_cip'])
            ->where_in('id_kode',$param['id_kode'])
            ->update('risalah_editor_2',$data);
    }
    public function simpan($param){
        $cari = $this->reditor_by_kode_cip($param['id_kode'],$param['id_cip'])->row();
        if (empty($cari)){
            return $this->db->insert('risalah_editor',$param);
        }else{
            if (empty(@$param['r_status']) || @$param['r_status'] === NULL){
                return $this->db->where('id_kode',$param['id_kode'])
                    ->where('id_cip',$param['id_cip'])
                    ->update('risalah_editor',['r_value' => $param['r_value']]);
            }else{
                return $this->db->where('id_kode',$param['id_kode'])
                ->where('id_cip',$param['id_cip'])
                ->update('risalah_editor',['r_value' => $param['r_value'],'r_status' => $param['r_status']]);    
            }
        }
    }
    public function simpan2($param){
        $cari = $this->reditor_by_kode_cip2($param['id_kode'],$param['id_cip'])->row();
        if (empty($cari)){
            return $this->db->insert('risalah_editor_2',$param);
        }else{

            if (empty(@$param['r_status']) || @$param['r_status'] === NULL){
                return $this->db->where('id_kode',$param['id_kode'])
                    ->where('id_cip',$param['id_cip'])
                    ->update('risalah_editor_2',['r_value' => $param['r_value']]);
            }else{
                return $this->db->where('id_kode',$param['id_kode'])
                    ->where('id_cip',$param['id_cip'])
                    ->update('risalah_editor_2',['r_value' => $param['r_value'],'r_status' => $param['r_status']]);    
            }
            
        }
    }
}
