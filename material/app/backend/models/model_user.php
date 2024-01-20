<?php
class Model_User extends Model
{
	public function check_account($login)
	{
		return $this->select("SELECT id FROM `user` WHERE login=?", array($login));
	}
	public function get_users()
	{
		//if ($_SESSION["uid"]["role"]==2) {
		//$result = $this->select("SELECT u.*, r.name AS role_name FROM `user` u, `role` r WHERE r.id=u.role_id AND u.role_id IN (4, 5) ORDER BY u.date_add");
		//}elseif ($_SESSION["uid"]["role"]==1) {
		$result = $this->select("SELECT u.*, r.name AS role_name FROM `user` u, `role` r WHERE r.id=u.role_id AND u.role_id <> 4 ORDER BY u.date_add");
		//}
		return $result;
	}
	public function get_user($user_id)
	{
		//$result = $this->select("SELECT u.*, r.name as role_name FROM `users` u, `roles` r WHERE r.id=u.role AND u.id=?",array($user_id));
		$result = $this->select("SELECT u.*, r.name as role_name
									FROM `user` u
									INNER JOIN `role` r ON r.id=u.role_id
									WHERE u.id=?", array($user_id));
		return $result;
	}
	public function get_user_login($user_id)
	{
		$result = $this->select("SELECT login FROM `users` WHERE id=?", array($user_id));
		return $result[0]['login'];
	}
	public function add_user($name, $login, $password, $access, $role, $unique_filename)
	{
		$date_now = date('Y-m-d H:i:s', strtotime('+5 hours'));

		// Хешируем пароль
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

		return $this->insert_get_Id(
			"INSERT INTO `user` SET name=?,login=?,password=?,access=?,role=?,date_add=?,image_url=?",
			array($name, $login, $hashed_password, $access, $role, $date_now, $unique_filename)
		);
	}

	public function edits_user($user_id, $name, $login, $password, $access, $role, $image_url)
	{
		$date_now = date('Y-m-d H:i:s', strtotime('+5 hours'));
		return $this->update("UPDATE `user` SET name=?,login=?,password=?,access=?,role=?,date_edit=?,image_url=? WHERE id=?", array($name, $login, $password, $access, $role, $date_now, $image_url, $user_id));
	}

	public function reset_password($user_id, $password)
	{
		return $this->update("UPDATE `users` SET password=? WHERE id=?", array($password, $user_id));
	}
	public function access_user($user_id, $access)
	{
		return $this->update("UPDATE `user` SET access=? WHERE id=?", array($access, $user_id));
	}
	public function randomPassword()
	{
		//$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$alphabet = '1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 6; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
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
