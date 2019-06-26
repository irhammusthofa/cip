<?php

class M_bab extends CI_Model
{
    var $_table = 'bab_risalah';

    var $table = 'bab_risalah rk';
    var $column_order = array('rk.br_kode', 'c.br_bab'); //set column field database for datatable orderable
    var $column_search = array('rk.br_kode', 'c.br_bab'); //set column field database for datatable searchable
    var $order = array('rk.br_kode' => 'asc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query($param='')
    {
        $this->db->from($this->table);
        $this->db->where('id_tahun',$this->thn_aktif);
    
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
        return $this->db->count_all_results();
    }
    public function all(){

        $this->db->where('id_tahun',$this->thn_aktif);
        return $this->db->order_by('br_position','asc')->get('bab_risalah');
    }
    public function by_id($id){
        $this->db->where('id_tahun',$this->thn_aktif);
        return $this->db->where('br_kode',$id)->get('bab_risalah');
    }
    public function update($id,$data){
        return $this->db->where('br_kode',$id)->update('bab_risalah',$data);
    }
    public function delete($data){
        return $this->db->delete('bab_risalah',$data);
    }
    public function insert($data){
        return $this->db->insert('bab_risalah',$data);
    }
    
}
