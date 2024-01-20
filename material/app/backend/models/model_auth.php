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
}