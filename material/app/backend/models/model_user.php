<?php
class Model_User extends Model
{
	public function check_account($login)
	{
		return $this->select("SELECT id FROM `user` WHERE login=?", array($login));
	}
	public function get_users()
	{
		if ($_SESSION["uid"]["role_id"] == 2) {
			$result = $this->select("SELECT u.*, r.name AS role_name FROM `user` u, `role` r WHERE r.id=u.role_id AND u.role_id IN (2, 5) ORDER BY u.date_add");
		} elseif ($_SESSION["uid"]["role_id"] == 3) {
			$result = $this->select("SELECT u.*, r.name AS role_name FROM `user` u, `role` r WHERE r.id=u.role_id AND u.role_id <> (SELECT `id` FROM role where `name` = 'admin') ORDER BY u.date_add");
		}
		return $result;
	}
	public function get_user($user_id)
	{
		//$result = $this->select("SELECT u.*, r.name as role_name FROM `user` u, `role` r WHERE r.id=u.role_id AND u.id=?",array($user_id));
		$result = $this->select("SELECT * FROM `user` WHERE id=?", array($user_id));
		return $result;
	}
	public function get_user_login($user_id)
	{
		$result = $this->select("SELECT login FROM `user` WHERE id=?", array($user_id));
		return $result[0]['login'];
	}
	public function add_user($name, $login, $password, $access, $role, $unique_filename,$kafedra)
	{
		$date_now = date('Y-m-d H:i:s', strtotime('+5 hours'));

		// Хешируем пароль
		$hashed_password = hash_hmac('SHA256',$password, 'J@h0n');
		//echo $name,' \n', $login,'  \n', $hashed_password,'  \n', $access,' \n ', $role,'  \n', $date_now,'  \n', $unique_filename,'  \n',$kafedra,'  \n';
		return $this->insert_get_Id(
			"INSERT INTO `user` SET name=?,login=?,password=?,access=?,role_id=?,date_add=?,image_url=?,kafedra_id=?",
			array($name, $login, $hashed_password, $access, $role, $date_now, $unique_filename,$kafedra)
		);
	}

	public function edit_user($user_id, $name, $login, $kafedra, $access, $image_url, $role)
	{
		$date_now = date('Y-m-d H:i:s', strtotime('+5 hours'));
		echo $user_id, $name, $login, $kafedra, $access, $role;	
		return $this->update("UPDATE `user` SET name=?,login=?,kafedra_id=?,access=?,role_id=?,date_edit=?,image_url=? WHERE id=?", array($name, $login, $kafedra, $access, $role, $date_now, $image_url, $user_id));
	}

	public function reset_password($user_id, $password)
	{
		$hashed_password = hash_hmac('SHA256',$password, 'J@h0n');
		return $this->update("UPDATE `user` SET password=? WHERE id=?", array($hashed_password, $user_id));
	}
	public function access_user($user_id, $access)
	{
		return $this->update("UPDATE `user` SET access=? WHERE id=?", array($access, $user_id));
	}
	public function get_roles()
	{
		if ($_SESSION["uid"]["role"] == 2) {
			$result = $this->select("SELECT * FROM `role` WHERE id in (4,5)");
		} elseif ($_SESSION["uid"]["role"] == 1) {
			$result = $this->select("SELECT * FROM `role`");
		}
		return $result;
	}
	
}
