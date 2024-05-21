<?php
class Model_Place extends Model
{
    public function get_places()
    {
        $result = $this->select(
            "SELECT `id`"
            . " ,`name`"
            . " FROM `place` ORDER BY `date_add` DESC"
        );
        return $result;
    }
    public function add_place($name)
    {
        if (!$this->select("SELECT * FROM `place` WHERE `name` = ?", [$name])) {
            return $this->insert(
                "INSERT INTO `place` "
                . "SET `name`=?",
                [$name]
            );
        } else {
            return false;
        }
    }

    public function get_palceById($id)
    {
        $result = $this->select(
            "SELECT `id`"
            . " ,`name`"
            . " FROM `place` WHERE id=?",
            [$id]
        )[0];
        return $result;
    }
    public function edit_place($id, $name)
{
    $existingPlace = $this->select("SELECT * FROM `place` WHERE `id` = ?", [$id]);

    if ($existingPlace) {
        return $this->update(
            "UPDATE `place` SET `name`=?, `date_edit`=? WHERE `id`=?",
            [$name, $this->current_date, $id]
        );
    }

    return false;
}
    public function delete_place($id)
    {
        return $this->delete(
            "DELETE FROM `place`"
            . " WHERE id=?",
            [$id]
        );

    }
}
