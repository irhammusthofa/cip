<?php

class M_juri extends CI_Model
{
    var $_table = 'juri';

    var $table = 'juri rk';
    var $column_order = array('rk.j_id', 'rk.j_juri','u.u_name','u.u_email'); //set column field database for datatable orderable
    var $column_search = array('rk.j_id', 'crk.j_juri','u.u_name','u.u_email'); //set column field database for datatable searchable
    var $order = array('rk.j_id' => 'asc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query($param='')
    {
        $this->db->from($this->table);
        $this->db->join('user u','u.u_id=rk.id_user','inner');
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
        $this->db->join('user u','u.u_id=rk.id_user','inner');
        $this->db->where('rk.id_tahun',$this->thn_aktif);
        return $this->db->count_all_results();
    }
    public function all(){
        $this->db->where('id_tahun',$this->thn_aktif);
        return $this->db->order_by('j_id','asc')->get('juri');
    }
    public function by_user($id)
    {
        return $this->db->from('juri j')
            ->join('user u','u.u_id=j.id_user','inner')
            ->where('u.u_id',$id)->get();
    }
    public function by_id($id){
        return $this->db->from('juri j')
            ->join('user u','u.u_id=j.id_user','inner')
            ->where('j.j_id',$id)->get();
    }
    public function update($id){
        $this->db->trans_begin();
            $data_juri = $this->by_id($id)->row();
            $user['u_name'] = $this->input->post('username',TRUE);
            $user['u_email'] = $this->input->post('email',TRUE);
            $user['u_status'] = 1;
            $user['u_role'] = "juri";
            if (!empty($this->input->post('password',TRUE))){
                $user['u_password'] = sha1($this->input->post('password',TRUE));    
            }
            
            $save_user = $this->db->where('u_id',$data_juri->id_user)->update('user',$user);
            $juri['j_juri'] = $this->input->post('nama',TRUE);
            $this->db->where('j_id',$id)->update('juri',$juri);
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
            $juri = $this->by_id($data['j_id'])->row();

            $this->db->delete('juri',$data);
            $this->db->delete('user',['u_id'=>$juri->id_user]);
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
            $user['u_status'] = 1;
            $user['u_role'] = "juri";
            $save_user = $this->db->insert('user',$user);
            if ($save_user){
                $id_user = $this->db->insert_id();    
            }else{
                $this->db->trans_rollback();
                return FALSE;
            }
            $juri['j_juri'] = $this->input->post('nama',TRUE);
            $juri['id_user'] = $id_user;
            $juri['id_tahun'] = $this->thn_aktif;
            $this->db->insert('juri',$juri);
        if ($this->db->trans_status()===FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return TRUE;
        }

    }
    
}
