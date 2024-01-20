<?php
class Model_Common extends Model{

    public function get_types(){
		$result = $this->select("SELECT `id`, `name` FROM `type`");
		return $result;
	}
    public function get_languages(){
        $result = $this->select("SELECT `id`, `code`, `name` FROM `language`");
        return $result;
    }
	public function get_subjects(){
		$result = $this->select("SELECT `id`, `name` FROM `subject`");
		return $result;
	}
    public function get_authors(){
        $result = $this->select("SELECT `id`, `name` FROM `author`");
        return $result;
    }
    public function get_places(){
        $result = $this->select("SELECT `id`, `name` FROM `place`");
        return $result;
    }
    public function get_specialties(){
        $result = $this->select("SELECT `id`, `code`, `name` FROM `specialty`");
        return $result;
    }
    public function get_roles(){
        $result = $this->select("SELECT * FROM `role`");
        return $result;
    }
}