<?php
class Model_Author extends Model{

    public function get_authors(){
		$result = $this->select("SELECT `id`"
                                        ." ,`name`"
                                        ." ,`degree`"
                                        ." FROM `author` ORDER BY `date_add` DESC"
        );
		return $result;
	}

    public function get_author($id){
        $result = $this->select("SELECT `id`"
                                        ." ,`name`"
                                        ." ,`degree`"
                                        ." FROM `author` WHERE id=?", [$id]
        )[0];
        return $result;
    }
}