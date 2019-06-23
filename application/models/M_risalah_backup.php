<?php

class M_risalah extends CI_Model
{
    var $_table = 'risalah_kode';

    var $table = 'risalah_kode rk';
    var $column_order = array('rk.rk_kode', 'c.r_value','rk.rk_title','c.id_cip','c.r_status'); //set column field database for datatable orderable
    var $column_search = array('rk.rk_kode', 'c.r_value','rk.rk_title','c.id_cip','c.r_status'); //set column field database for datatable searchable
    var $order = array('rk.rk_kode' => 'asc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query($param='')
    {
        $this->db->from($this->table);
        $this->db->join('risalah_editor c','c.id_kode=rk.rk_kode and c.id_cip="'.$param['id_cip'].'"','left');
        $this->db->where_in('rk.rk_kode',$param['kode']);
    
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
        $this->db->join('risalah_editor c','c.id_kode=rk.rk_kode and c.id_cip="'.$param['id_cip'].'"','left');
        $this->db->where_in('rk.rk_kode',$param['kode']);
        return $this->db->count_all_results();
    }
    public function rkode_by_kode($kode){
        return $this->db->where('rk_kode',$kode)->get('risalah_kode');
    }
    public function reditor_by_kode_cip($kode,$id_cip){
        return $this->db->where('id_kode',$kode)->where('id_cip',$id_cip)->get('risalah_editor');
    }
    public function delete($param){
        return $this->db->delete('risalah_editor',$param);
    }
    public function simpan($param){
        $cari = $this->reditor_by_kode_cip($param['id_kode'],$param['id_cip'])->row();
        if (empty($cari)){
            return $this->db->insert('risalah_editor',$param);
        }else{
            return $this->db->where('id_kode',$param['id_kode'])
                ->where('id_cip',$param['id_cip'])
                ->update('risalah_editor',['r_value' => $param['r_value'],'r_status' => $param['r_status']]);
        }
    }
}
