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
    
}