<?php

class M_kriteria extends CI_Model
{
    var $_table = 'kriteria';

    var $table = 'kriteria rk';
    var $column_order = array('rk.kp_id', 'rk.kp_kriteria', 'rk.kp_nilai_kriteria','jc.jc_id','jc.jc_jenis'); //set column field database for datatable orderable
    var $column_search = array('rk.kp_id', 'rk.kp_kriteria', 'rk.kp_nilai_kriteria','jc.jc_id','jc.jc_jenis'); //set column field database for datatable searchable
    var $order = array('rk.kp_id' => 'asc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query($param='')
    {
        $this->db->from($this->table);
        $this->db->join('jenis_cip jc','jc.jc_id=rk.id_jenis_cip','inner');
        $this->db->where('rk.id_tahun',$this->thn_aktif);
    
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
        $this->db->join('jenis_cip jc','jc.jc_id=rk.id_jenis_cip','inner');
        $this->db->where('rk.id_tahun',$this->thn_aktif);
        return $this->db->count_all_results();
    }
    public function all(){
        $this->db->where('id_tahun',$this->thn_aktif);
        return $this->db->order_by('kp_id','asc')->get('kriteria');
    }

    public function by_jenis($id){
        return $this->db->where('id_jenis_cip',$id)->get('kriteria');
    }
    public function by_id($id){
        return $this->db->where('kp_id',$id)->get('kriteria');
    }
    public function update($id,$data){
        return $this->db->where('kp_id',$id)->update('kriteria',$data);
    }
    public function delete($data){
        return $this->db->delete('kriteria',$data);
    }
    public function insert($data){
        return $this->db->insert('kriteria',$data);
    }
    
}
