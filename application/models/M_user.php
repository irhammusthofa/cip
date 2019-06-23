<?php
/**
* M_user
*/
class M_user extends CI_Model
{
	public function login($param){
		return $this->db->where('u_name',$param['u_name'])
			->where('u_password',sha1($param['u_password']))
			->get('user');
	}
	public function signup($data){
		if (count($this->by_email($data['u_email'])->result())>0){
			return array(
				'status' => FALSE,
				'message'=> 'Email yang anda masukan sudah terdaftar,'
			);
		}else{
			$password 			= rand(1000,9999);
			$data['u_password'] = sha1($password);
			$data['u_status']	= 1;
			$data['u_role']	= 'user';
			if($this->insert($data)){
				$data['password'] = $password;
				$this->sendemailsignup($data);
				return array(
					'status' => TRUE,
					'message'=> 'Pendaftaran berhasil,'
				);
			}else{
				return array(
					'status' => FALSE,
					'message'=> 'Pendaftaran gagal, silahkan coba kembali,'
				);
			}
		}
	}
	public function sendemailsignup($data){
		$this->load->library('email');

		$this->email->from('Wahyumarutiadjie09@gmail.com', 'Registrasi Team CIP');
		$this->email->to($data['u_email']);
		$this->email->set_mailtype("html");

		$this->email->subject('Signup');
		$this->email->message('Akun anda berhasil didaftarkan, berikut ini adalah username dan password anda : <br> Username : <b>'.$data['u_name'].'</b><br> Password : <b>'.$data['password'].'</b>');

		return $this->email->send();
	}
	public function by_email($id){
		return $this->db->where('u_email',$id)->get('user');
	}
	public function by_id($id){
		return $this->db->where('u_id',$id)->get('user');
	}
	public function insert($data){
		return $this->db->insert('user',$data);
	}
	public function auth_token($token){
		$this->db->select('*')
			->from('user')
			->where("u_password",$token);

		$query = $this->db->get()->row();
		if (count($query)>0){
			return array(
					'status' 	=> TRUE,
					'login'		=> TRUE,
	                'message' 	=> 'Token Valid', 
				);
		}else{
			return array(
					'status' 	=> FALSE,
					'login'		=> FALSE,
	                'message' 	=> 'Token salah/sudah tidak dapat digunakan lagi.', 
				);
		}
	}
	public function update_akun($data){
		return $this->db->where('u_id',$this->user->u_id)->update('user',$data);
	}
}