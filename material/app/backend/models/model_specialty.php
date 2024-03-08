<?php
class Model_Specialty extends Model
{

    public function get_specialties()
    {
        $result = $this->select(
            "SELECT `id`"
                . " ,`code`"
                . " ,`name`"
                . " FROM `specialty` ORDER BY `date_add` DESC"
        );
        return $result;
    }

    public function get_specialty($id)
    {
        $result = $this->select(
            "SELECT `id`"
                . " ,`code`"
                . " ,`name`"
                . " FROM `specialty` WHERE id=?",
            [$id]
        )[0];
        return $result;
    }

    public function add_specialty($code, $name)
    {

        return $this->insert(
            "INSERT INTO `specialty` "
                . "SET `code`=?,`name`=?,`user_id`=?",
            [$code, $name, $this->user_id]
        );
    }
    public function edit_specialty($id, $code, $name)
    {
        return $this->update(
            "UPDATE `specialty` SET `code`=?"
                . " ,`name`=? "
                . " ,`date_edit`=?"
                . " ,`user_id`=?  WHERE id=?",
            [$code, $name, $this->current_date, $this->user_id, $id]
        );
    }
    public function get_facultys()
    {
        $result = $this->select(
            "SELECT `id`"
                . " ,`name`"
                . " FROM `faculty` ORDER BY `date_add` DESC"
        );
        return $result;
    }
    public function add_faculty($name)
    {
        if (!$this->select("SELECT * FROM `faculty` WHERE `name` = ?", [$name])) {
            return $this->insert(
                "INSERT INTO `faculty` "
                    . "SET `name`=?",
                [$name]
            );
            return true;
        } else {
            return false;
        }
    }
}
