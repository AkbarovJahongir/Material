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

	public function add_author( $name, $degree ){

        return $this->insert("INSERT INTO `author` "
                                  ."SET `name`=?,`degree`=?,`user_id`=?",
            [ $name, $degree, $this->user_id ]
        );


	}
	public function edit_author( $id, $name, $degree )
    {
		return $this->update("UPDATE `author` SET `name`=?"
                                                    ." ,`degree`=? "
                                                    ." ,`date_edit`=?"
                                                    ." ,`user_id`=?  WHERE id=?",
            [ $name, $degree, $this->current_date, $this->user_id, $id ]
        );

	}

    public function delete_author( $id )
    {
        $result = $this->select("SELECT `id` FROM `material_author`"
                                ." WHERE `author_id`=?", [$id]
        );

        if ( count($result) > 0 )
            return false;
        else
            return $this->delete("UPDATE `author`"
                                        ." SET `status` = 0"
                                        ." WHERE id=?", [ $id ]
            );

    }

}