<?php
class Model_Faculty extends Model
{
    public function get_facultys()
    {
        $result = $this->select(
            "SELECT `id`"
            . " ,`name`"
            . " FROM `faculty` ORDER BY `date_add` DESC"
        );
        return $result;
    }
    public function get_kafedra()
    {
        $result = $this->select(
            "SELECT k.`id`"
            . " ,k.`name`"
            . " ,`f`.`name` AS `facultyName`"
            . " FROM `kafedra` AS k"
            . " INNER JOIN `faculty` AS `f` ON `f`.id = k.faculty_id"
            . " ORDER BY k.`date_add` DESC"
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
        } else {
            return false;
        }
    }
    public function add_kafedra($name, $faculty)
    {
        if (!$this->select("SELECT * FROM `kafedra` WHERE `name` = ? AND `faculty_id` = ?", [$name, $faculty])) {
            return $this->insert(
                "INSERT INTO `kafedra` "
                . "SET `name`=?, "
                . "`faculty_id` = ?",
                [$name, $faculty]
            );
        } else {
            return false;
        }
    }

    public function get_facultyById($id)
    {
        $result = $this->select(
            "SELECT `id`"
            . " ,`name`"
            . " FROM `faculty` WHERE id=?",
            [$id]
        )[0];
        return $result;
    }
    public function get_kafedraById($id)
    {
        $result = $this->select(
            "SELECT k.`id`"
            . " ,k.`name`"
            . " ,`f`.`id` AS f_id"
            . " ,`f`.`name` AS `facultyName`"
            . " FROM `kafedra` AS k"
            . " INNER JOIN `faculty` AS `f` ON `f`.id = k.faculty_id"
            . " WHERE k.id=?",
            [$id]
        )[0];
        return $result;
    }
    public function edit_faculty($id, $name)
    {
        if (!$this->select("SELECT * FROM `faculty` WHERE `name` = ?", [$name])) {
            return $this->update(
                "UPDATE `faculty` SET `name`=? "
                . " ,`date_edit`=?"
                . " WHERE id=?",
                [$name, $this->current_date, $id]
            );
        }
        return false;
    }
    public function edit_kafedra($id, $name,$faculty)
    {
        if (!$this->select("SELECT * FROM `kafedra` WHERE `name` = ? AND `faculty_id` = ?", [$name, $faculty])) {
            return $this->update(
                "UPDATE `kafedra` SET `name`=? "
                . ", `faculty_id`=?"
                . " ,`date_edit`=?"
                . " WHERE id=?",
                [$name, $faculty, $this->current_date, $id]
            );
        }
        return false;
    }
    public function delete_faculty($id)
    {
        return $this->delete(
            "DELETE FROM `faculty`"
            . " WHERE id=?",
            [$id]
        );

    }
    public function delete_kafedra($id)
    {
        return $this->delete(
            "DELETE FROM `kafedra`"
            . " WHERE id=?",
            [$id]
        );

    }
}
