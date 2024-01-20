<?php
class Model{
	private $pdo = null;
	private $stmt = null;

	public $current_date;
	public $user_id;

	function __construct(){
		try {
		  $this->pdo = new PDO(
		    "mysql:host=localhost;dbname=material;charset=utf8",
		    "root", "root", [
		      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		      PDO::ATTR_EMULATE_PREPARES => false,
		    ]
		  );
		  $this->current_date = date('Y-m-d H:i:s', strtotime('+5 hours'));
		  if ( isset($_SESSION["uid"]) )
		    $this->user_id = $_SESSION["uid"]["id"];
		} catch (Exception $ex) { die($ex->getMessage()); }
	}

	function __destruct(){
		if ($this->stmt!==null) { $this->stmt = null; }
		if ($this->pdo!==null) { $this->pdo = null; }
	}

	function select($sql, $cond=null){
	    $result = false;
		try {
		  $this->stmt = $this->pdo->prepare($sql);
		  $this->stmt->execute($cond);
		  $result = $this->stmt->fetchAll();
		  // print_r($result);
		} catch (Exception $ex) { die($ex->getMessage()); }
		$this->stmt = null;

        return $result;
	}

	function insert($sql, $cond=null){
		try {
		  $this->stmt = $this->pdo->prepare($sql);
		  return $this->stmt->execute($cond);
		} catch (Exception $ex) {
			die($ex->getMessage());
			return false;
		}
		return false;
	}
	
	function insert_get_id($sql, $cond=null){
		$result = false;
		try {
		  $this->stmt = $this->pdo->prepare($sql);
		  $this->stmt->execute($cond);
		  return $this->pdo->lastInsertId();
		} catch (Exception $ex) {
			die($ex->getMessage());
			return false;
		}
		return false;
	}

	function update($sql, $cond=null){
		try {
		  $this->stmt = $this->pdo->prepare($sql);
		  return $this->stmt->execute($cond);
		} catch (Exception $ex) {
			die($ex->getMessage());
			return false;
		}
		return false;
	}

    function delete($sql, $cond=null){
        try {
            $this->stmt = $this->pdo->prepare($sql);
            return $this->stmt->execute($cond);
        } catch (Exception $ex) {
            die($ex->getMessage());
            return false;
        }
        return false;
    }

	public function get_data(){
	
	}
}
?>