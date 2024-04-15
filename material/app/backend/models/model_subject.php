<?php
class Model_Subject extends Model{

    public function get_subjects(){
		$result = $this->select("SELECT `id`"
                                        ." ,`name`"
                                        ." FROM `subject` ORDER BY `date_add` DESC"
        );
		return $result;
	}
    public function get_types(){
		$result = $this->select("SELECT `id`"
                                        ." ,`name`"
                                        ." FROM `type` ORDER BY `date_add` DESC"
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

	public function add_subject( $name ){

        return $this->insert("INSERT INTO `subject` "
                                  ."SET `name`=?,`user_id`=?",
            [ $name, $this->user_id ]
        );


	}
	public function edit_subject( $id, $name )
    {
		return $this->update("UPDATE `subject` SET `name`=?"
                                                    ." ,`date_edit`=?"
                                                    ." ,`user_id`=?  WHERE id=?",
            [ $name, $this->current_date, $this->user_id, $id ]
        );

	}
    public function get_typeById($id)
    {
        $result = $this->select(
            "SELECT `id`"
            . " ,`name`"
            . " FROM `type` WHERE id=?",
            [$id]
        )[0];
        return $result;
    }
    public function add_type($name)
    {
        if (!$this->select("SELECT * FROM `type` WHERE `name` = ?", [$name])) {
            return $this->insert(
                "INSERT INTO `type` "
                . "SET `name`=?, `date_add`=?",
                [$name,$this->current_date,]
            );
        } else {
            return false;
        }
    }
    public function edit_type($id, $name)
    {
        if (!$this->select("SELECT * FROM `type` WHERE `name` = ?", [$name])) {
            return $this->update(
                "UPDATE `type` SET `name`=? "
                . " ,`date_edit`=?"
                . " WHERE id=?",
                [$name, $this->current_date, $id]
            );
        }
        return false;
    }
}