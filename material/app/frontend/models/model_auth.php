<?php

class Model_Auth extends Model{
	public function check($login, $password){
		$result = $this->select("SELECT * FROM `user` WHERE login=? AND password=?",array($login, $password));
		return $result;
	}
	public function get_role($role){
		$result = $this->select("SELECT * FROM `role` WHERE id=?",array($role));
		return $result;
	}
}