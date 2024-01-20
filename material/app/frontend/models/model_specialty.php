<?php
class Model_Specialty extends Model{

    public function get_specialties(){
		$result = $this->select("SELECT `id`"
                                        ." ,`code`"
                                        ." ,`name`"
                                        ." FROM `specialty` ORDER BY `date_add` DESC"
        );
		return $result;
	}

    public function get_specialty($id){
        $result = $this->select("SELECT `id`"
                                        ." ,`code`"
                                        ." ,`name`"
                                        ." FROM `specialty` WHERE id=?", [$id]
        )[0];
        return $result;
    }

}