<?php

class M_subbab extends CI_Model
{
    var $_table = 'sub_bab';

    var $table = 'sub_bab rk';
    var $column_order = array('rk.sb_id', 'c.sb_sub_bab'); //set column field database for datatable orderable
    var $column_search = array('rk.sb_id', 'c.sb_sub_bab','c.id_langkah','br.ln_langkah'); //set column field database for datatable searchable
    var $order = array('rk.sb_id' => 'asc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query($param='')
    {
        $this->db->from($this->table);
        $this->db->join('langkah br','br.ln_id=rk.id_langkah','inner');
        $this->db->join('bab_risalah b','b.br_kode=br.id_bab','inner');
        $this->db->where('b.id_tahun',$this->thn_aktif);
    
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
        $this->db->join('langkah br','br.ln_id=rk.id_langkah','inner');
        $this->db->join('bab_risalah b','b.br_kode=br.id_bab','inner');
        $this->db->where('b.id_tahun',$this->thn_aktif);
        return $this->db->count_all_results();
    }
    public function by_bab($id){
        return $this->db->from('sub_bab s')
            ->join('langkah ln','ln.ln_id=s.id_langkah','inner')
            ->where('ln.id_bab',$id)->get();
    }
    public function by_id($id){
        return $this->db->where('sb_id',$id)->get('sub_bab');
    }
    public function update($id,$data){
        return $this->db->where('sb_id',$id)->update('sub_bab',$data);
    }
    public function delete($data){
        return $this->db->delete('sub_bab',$data);
    }
    public function insert($data){
        return $this->db->insert('sub_bab',$data);
    }
    
}
