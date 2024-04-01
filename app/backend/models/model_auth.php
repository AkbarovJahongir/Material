<?php

class Model_Auth extends Model{
	public function get_role($role){
		$result = $this->select("SELECT * FROM `role` WHERE id=?",array($role));
		return $result;
	}
	public function get_user($id){
		$result = $this->select("SELECT * FROM `user` WHERE id=?",array($id));
		return $result;
	}
	public function check($login, $password){
		//echo hash_hmac('SHA256',$password, 'p0l!t3kh');
		$result = $this->select("SELECT * FROM `user` WHERE login=? AND password=?",array($login, hash_hmac('SHA256',$password, 'p0l!t3kh')));
		return $result;
	}
}