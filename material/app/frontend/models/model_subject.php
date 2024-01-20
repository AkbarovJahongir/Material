<?php
class Model_Subject extends Model{

    public function get_subjects(){
		$result = $this->select("SELECT `id`"
                                        ." ,`name`"
                                        ." FROM `subject` ORDER BY `date_add` DESC"
        );
		return $result;
	}

    public function get_subject($id){
        $result = $this->select("SELECT `id`"
                                        ." ,`name`"
                                        ." FROM `subject` WHERE id=?", [$id]
        )[0];
        return $result;
    }

}