<?php
class Model_Direction extends Model
{
    public function get_directions()
    {
        $result = $this->select(
            "SELECT `id`"
            . " ,`name`"
            . " FROM `material_direction` ORDER BY `date_add` DESC"
        );
        return $result;
    }
    public function add_direction($name)
    {
        if (!$this->select("SELECT * FROM `material_direction` WHERE `name` = ?", [$name])) {
            return $this->insert(
                "INSERT INTO `material_direction` "
                . "SET `name`=?",
                [$name]
            );
        } else {
            return false;
        }
    }

    public function get_directionById($id)
    {
        $result = $this->select(
            "SELECT `id`"
            . " ,`name`"
            . " FROM `material_direction` WHERE id=?",
            [$id]
        )[0];
        return $result;
    }
    public function edit_direction($id, $name)
    {
        if ($this->select("SELECT * FROM `material_direction` WHERE `id` = ?", [$id])) {
            return $this->update(
                "UPDATE `material_direction` SET `name`=? "
                . " ,`date_edit`=?"
                . " WHERE id=?",
                [$name, $this->current_date, $id]
            );
        }
        return false;
    }
    public function delete_direction($id)
    {
        return $this->delete(
            "DELETE FROM `material_direction`"
            . " WHERE id=?",
            [$id]
        );

    }
}
