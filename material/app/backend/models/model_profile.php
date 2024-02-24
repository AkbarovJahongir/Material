<?php
class Model_Profile extends Model{
	
	public function check_current_pass($user_id, $current_pass){
		$result = $this->select("SELECT * FROM `user` WHERE id=? AND password=?",array($user_id, $current_pass));
		return $result;
	}

	public function edit_user_pass($user_id,$password){
		return $this->update("UPDATE `user` SET password=? WHERE id=?", array($password,$user_id));
	}

}