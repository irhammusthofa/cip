<?php

class M_pengguna extends CI_Model
{
    var $_table = 'user';

    var $table = 'user u';
    var $column_order = array('u.u_id', 'u.u_name','u.u_email','u.u_status','u.u_role'); //set column field database for datatable orderable
    var $column_search = array('u.u_id', 'u.u_name','u.u_email','u.u_status','u.u_role'); //set column field database for datatable searchable
    var $order = array('u.u_id' => 'asc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query($param='')
    {
        $this->db->from($this->table);
        $this->db->where_in('u.u_role',['pimpinan','admin']);
    
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
        $this->db->where_in('u.u_role',['pimpinan','admin']);
        return $this->db->count_all_results();
    }
    public function all(){

        $this->db->where_in('u_role',['pimpinan','admin']);
        return $this->db->order_by('u_id','asc')->get('user');
    }
    public function by_id($id){
        return $this->db->from('user u')
            ->where('u.u_id',$id)->get();
    }
    public function update($id){
        $this->db->trans_begin();
            $user['u_name'] = $this->input->post('username',TRUE);
            $user['u_email'] = $this->input->post('email',TRUE);
            if (!empty($this->input->post('password',TRUE))){
                $user['u_password'] = sha1($this->input->post('password',TRUE));
            }
            $user['u_status'] = $this->input->post('status',TRUE);
            $user['u_role'] = $this->input->post('role',TRUE);;
            $save_user = $this->db->where('u_id',$id)->update('user',$user);
        if ($this->db->trans_status()===FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return TRUE;
        }
    }
    public function delete($data){
        $this->db->trans_begin();
            $this->db->delete('user',['u_id'=>$data['u_id']]);
        if ($this->db->trans_status()===FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return TRUE;
        }
    }
    public function insert(){

        $this->db->trans_begin();
            $user['u_name'] = $this->input->post('username',TRUE);
            $user['u_email'] = $this->input->post('email',TRUE);
            $user['u_password'] = sha1($this->input->post('password',TRUE));
            $user['u_status'] = $this->input->post('status',TRUE);
            $user['u_role'] = $this->input->post('role',TRUE);;
            $save_user = $this->db->insert('user',$user);
            
        if ($this->db->trans_status()===FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return TRUE;
        }

    }
    
}
