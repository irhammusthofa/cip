<?php

class M_penilaian extends CI_Model
{
    var $_table = 'cip';

    var $table = 'cip c';
    var $column_order = array('c.t_no_gugus', 'c.t_judul_cip','c.t_nama_gugus','c.t_didirikan','c.t_created','c.t_status'); //set column field database for datatable orderable
    var $column_search = array('c.t_no_gugus', 'c.t_judul_cip','c.t_nama_gugus','c.t_didirikan','c.t_created','c.t_status'); //set column field database for datatable searchable
    var $order = array('c.t_no_gugus' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_cip');
        $this->load->model('m_kriteria');
    }

    private function _get_datatables_query($param='')
    {
        $this->db->from($this->table);
        $this->db->join('juri_tim jt','jt.id_tim=c.t_no_gugus','inner');
        $this->db->join('juri j','j.j_id=jt.id_juri','inner');
        $this->db->join('jenis_cip jc','jc.jc_id=c.id_jenis','inner');
        if (@$param['request_by']=='admin'){
            $this->db->where('jc.jc_id', $param['id_jenis']);
        }else{
            $this->db->where('j.id_user', $this->user->u_id);    
        }
        
        $this->db->where('c.id_tahun', $this->thn_aktif);
    
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
        $this->db->join('juri_tim jt','jt.id_tim=c.t_no_gugus','inner');
        $this->db->join('juri j','j.j_id=jt.id_juri','inner');
        $this->db->join('jenis_cip jc','jc.jc_id=c.id_jenis','inner');
        if (@$param['request_by']=='admin'){
            $this->db->where('jc.jc_id', $param['id_jenis']);
        }else{
            $this->db->where('j.id_user', $this->user->u_id);    
        }
        $this->db->where('c.id_tahun', $this->thn_aktif);
        return $this->db->count_all_results();
    }
    public function all(){
        $this->db->where('id_tahun', $this->thn_aktif);
        return $this->db->order_by('j_id','asc')->get('juri');
    }
    public function by_id($id){
        return $this->db->where('j_id',$id)->get('juri');
    }
    public function update($id,$data){
        return $this->db->where('j_id',$id)->update('juri',$data);
    }
    public function delete($data){
        return $this->db->delete('juri',$data);
    }
    public function insert($data){
        $cari_nilai = $this->db->from('penilaian')
            ->where('id_cip',$data['id_cip'])
            ->where('id_juri',$data['id_juri'])
            ->where('id_kriteria',$data['id_kriteria'])
            ->get()->row();
        if (empty($cari_nilai)){
            return $this->db->insert('penilaian',$data);    
        }else{
            return $this->db->where('pn_id',$cari_nilai->pn_id)->update('penilaian',$data);
        }
        
    }
    public function datanilai_juri($id_cip,$id_juri,$id_jenis){
        return $this->db->from('penilaian p')
            ->join('cip c','c.t_no_gugus=p.id_cip and p.id_cip="'.$id_cip.'"','inner')
            ->join('juri j','j.j_id=p.id_juri and p.id_juri="'.$id_juri.'"','inner')
            ->join('kriteria k','k.kp_id=p.id_kriteria','right')
            ->where('k.id_jenis_cip',$id_jenis)
            ->order_by('k.kp_id')
            ->get();

    }

    public function kriteria_reference($kriteria,$alternatif){
        foreach ($kriteria as $item) {
            $bobot = $this->get_bobot($item,$alternatif);
            $pembagi = $this->get_pembagi($item,$alternatif);
            $kriteria_reference[] = array(
                'kode'          => $item,
                'data'          => array(
                    'c/b'       => ($bobot<2) ? 'COST' : 'BENEFIT',
                    'bobot'     => $bobot,
                    'pembagi'   => $pembagi,
                ),
            );
        }
        return $kriteria_reference;
    }
    public function list_kriteria(){
        return $this->db->select('*')
            ->from('kriteria')
            ->get();
    }
    public function rata2_kriteria($cip,$kriteria){
        //$count = count($this->list_sub_kriteria($kriteria)->result());
        $sum = $this->db->select('sum(pn_nilai) AS nilai')
            ->from('penilaian p')
            ->join('kriteria k','k.kp_id=p.id_kriteria','inner')
            ->where('p.id_cip',$cip)
            ->where('k.kp_id',$kriteria)
            ->get()->row()->nilai;
        //if ($sum==0) return 0;
        return $sum;
    }
    private function get_bobot($kode_kriteria,$alternatif){
        //$tim_saya =  $this->m_cip->by_id($kode)->row();
        //$tim   = $this->m_cip->by_jenis($tim_saya->id_jenis)->result();
        //$tim   = $this->m_cip->all()->result();
        //$kriteria = $this->m_kriteria->by_id($kode_kriteria)->row();
        //return $kriteria->kp_nilai_kriteria;

        $bobot      = [];
        foreach ($alternatif as $item) {
            $rata2 = $this->rata2_kriteria($item,$kode_kriteria);
            $bobot[]    = array('nilai'=>$rata2);
        }
        $tmp = 0;
        foreach ($bobot as $val) {
            $tmp += $val['nilai'];
        }
        if ($tmp==0) return 0;
        return $tmp/count($alternatif);
    }
    private function get_pembagi($kode_kriteria,$alternatif){
        //$tim_saya =  $this->m_cip->by_id($kode)->row();
        //$tim   = $this->m_cip->by_jenis($tim_saya->id_jenis)->result();
        //$tim   = $this->m_cip->all()->result();
        $bobot      = [];
        foreach ($alternatif as $item) {
            $rata2 = $this->rata2_kriteria($item,$kode_kriteria);
            $bobot[]    = array('nilai'=>$rata2);
        }
        $tmp = 0;
        foreach ($bobot as $val) {
            $tmp += ($val['nilai']*$val['nilai']);
        }
        return sqrt($tmp);
    }
    public function ternormalisasi($kriteria,$alternatif,$kriteria_reference){

        //$kriteria       = $this->list_kriteria()->result();
        //$alternatif     = $this->alternatif()->result();
        $alternatif_reference = [];
        foreach ($alternatif as $val) {
            $data = "";
            foreach ($kriteria as $val_k) {
                $nilai              = 0;
                $ref_kriteria       = $this->find_refkriteria($kriteria_reference,$val_k);
                $pembagi            = $ref_kriteria['data']['pembagi'];
                $nilai              = $this->get_nilai($val,$val_k);
                // if ($nilai==0){
                //     $ternormalisasi     = 0;
                // }else{
                //     $ternormalisasi     = $nilai/$pembagi;
                // }
                
                if ($nilai!=0){
                    $ternormalisasi     = $nilai/$pembagi;  
                }else{
                    $ternormalisasi     = 0;
                }

                $bobot              = $ref_kriteria['data']['bobot'];

                $alternatif_reference[] = array(
                    'id_cip'        => $val,
                    'kriteria'      => $val_k,
                    'nilai'         => $nilai,
                    'ternormalisasi'=> $ternormalisasi,
                    'terbobot'      => $ternormalisasi * $bobot,
                );
            }
            
        }
        return $alternatif_reference;
    }
    private function alternatif(){
        return $this->db->select('id_cip')
            ->from('penilaian')
            ->group_by('id_cip')
            ->get();
    }

    private function find_refkriteria($source,$kriteria){
        for($i=0;$i<count($source);$i++){
            if ($kriteria==$source[$i]['kode']){
                return $source[$i];
            }
        }
        return FALSE;
    }

    private function get_nilai($cip,$kode){
        $nilai          = $this->rata2_kriteria($cip,$kode);
        if ($nilai==0) return 0;
        return $nilai;
    }
    public function ideal($kriteria,$kriteria_reference,$alternatif_reference){

        foreach ($kriteria as $item) {
            $ref_kriteria       = $this->find_refkriteria($kriteria_reference,$item);
            $cb                 = $ref_kriteria['data']['c/b'];
            $ref_terbobot       = $this->find_refterbobot($alternatif_reference,$item,'kriteria');
            if ($cb=='BENEFIT'){
                $a_plus = max($ref_terbobot);
                $a_min  = min($ref_terbobot);
            }else{
                $a_plus = min($ref_terbobot);
                $a_min  = max($ref_terbobot);
            }
            $tab_ideal[] = array(
                'kriteria'  => $item,
                'a_plus'    => $a_plus,
                'a_min'     => $a_min,
            );
        }
        return $tab_ideal;
    }
    private function find_refterbobot_kriteria($source,$id_cip,$key,$kriteria){
        $tmp = "";
        for($i=0;$i<count($source);$i++){
            if ($id_cip==$source[$i][$key] && $kriteria==$source[$i]['kriteria']){
                return $source[$i]['terbobot'];
            }
        }
        return 0;
    }
    private function find_refterbobot($source,$kriteria,$key){
        $tmp = [];
        for($i=0;$i<count($source);$i++){
            if ($kriteria==$source[$i][$key]){
                $tmp[] = $source[$i]['terbobot'];
            }
        }
        return $tmp;
    }
    public function relative_closeness($id_cip,$kriteria,$alternatif){
        $array = $this->get_relative_closeness($kriteria,$alternatif);
        for($i=0;$i<count($array);$i++){
            if (@$array[$i]['id_cip']==$id_cip){
                $relative_closeness = array(
                    'id_cip'   => $id_cip,
                    's_plus'        => $array[$i]['s_plus'],
                    's_min'         => $array[$i]['s_min'],
                    'rc'            => $array[$i]['rc']
                );
                return $relative_closeness;
            }
        }
        $relative_closeness = array(
            'id_cip'   => $id_cip,
            's_plus'        => 0,
            's_min'         => 0,
            'rc'            => 0
        );
        return $relative_closeness;
    }

    private function get_relative_closeness($kriteria,$alternatif){
        //$kriteria       = $this->list_kriteria()->result();
        $count_kriteria = count($kriteria);
        //$alternatif     = $this->alternatif($month,$year)->result();
        $count_alternatif = count($alternatif);
        if ($count_alternatif<=0 || $count_kriteria <=0){
            $relative_closeness = array(
                's_plus'        => 0,
                's_min'         => 0,
                'rc'            => 0
            );
            return $relative_closeness;
        }
        $kriteria_reference = $this->kriteria_reference($kriteria,$alternatif);
        $alternatif_reference = $this->ternormalisasi($kriteria,$alternatif,$kriteria_reference);
        
        $tab_ideal = $this->ideal($kriteria,$kriteria_reference,$alternatif_reference);
        
        $relative_closeness = [];
        foreach ($alternatif as $val) {
            $s_plus = 0;
            $s_min  = 0;
            foreach ($tab_ideal as $tab) {
                $ref_terbobot       = $this->find_refterbobot_kriteria($alternatif_reference,$val,'id_cip',$tab['kriteria']);
                $s_plus += ($tab['a_plus']-$ref_terbobot)*($tab['a_plus']-$ref_terbobot);
                $s_min += (($tab['a_min']-$ref_terbobot)*($tab['a_min']-$ref_terbobot));
            }
            $s_plus = sqrt($s_plus);
            $s_min = sqrt($s_min);

            $relative_closeness[] = array(
                'id_cip'        => $val,
                's_plus'        => $s_plus,
                's_min'         => $s_min,
                'rc'            => ($s_min!=0) ? $s_min / ($s_min+$s_plus) : 0,
            );
            
        }
        return $relative_closeness;
        
    }
    public function rangking($id_cip,$kriteria,$alternatif){
        $array = $this->get_relative_closeness($kriteria,$alternatif);
        $rank   = [];
        for($i=0;$i<count($array);$i++){
            $rank[] = array(
                'rc'            => @$array[$i]['rc'],
                'id_cip'   => @$array[$i]['id_cip'],
            );
        }
        arsort($rank);
        $i = 0;
        foreach ($rank as $val) {
            $i++;
            if ($val['id_cip']==$id_cip){
                return $i;
            }
        }
    }
}
