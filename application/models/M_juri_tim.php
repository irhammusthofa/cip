<?php

class M_juri_tim extends CI_Model
{
    var $_table = 'juri_tim';

    var $table = 'juri_tim jt';
    var $column_order = array('j.j_id', 'j.j_juri','c.t_no_gugus','c.t_nama_gugus'); //set column field database for datatable orderable
    var $column_search = array('j.j_id', 'j.j_juri','c.t_no_gugus','c.t_nama_gugus'); //set column field database for datatable searchable
    var $order = array('jt.jt_id' => 'asc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query($param='')
    {
        $this->db->from($this->table);
        $this->db->join('juri j','j.j_id=jt.id_juri','inner');
        $this->db->join('cip c','c.t_no_gugus=jt.id_tim','inner');
        $this->db->where('j.j_id',$param['id_juri']);
    
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
        $this->db->join('juri j','j.j_id=jt.id_juri','inner');
        $this->db->join('cip c','c.t_no_gugus=jt.id_tim','inner');
        $this->db->where('j.j_id',$param['id_juri']);
        return $this->db->count_all_results();
    }
    public function by_juri($juri){
        return $this->db->where('id_juri',$juri)->order_by('jt_id','asc')->get('juri_tim');
    }
    public function all(){
        return $this->db->order_by('jt_id','asc')->get('juri_tim');
    }
    public function by_id($id){
        return $this->db->from('juri_tim jt')->join('cip c','c.t_no_gugus=jt.id_tim','inner')->where('jt.jt_id',$id)->get();
    }
    public function update($id,$data){
        return $this->db->where('jt_id',$id)->update('juri_tim',$data);
    }
    public function delete($data){
        return $this->db->delete('juri_tim',$data);
    }
    public function insert($data){
        return $this->db->insert('juri_tim',$data);
    }
    
}
