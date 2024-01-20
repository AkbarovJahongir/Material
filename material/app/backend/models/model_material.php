<?php
class Model_Material extends Model
{

    public function get_materials()
    {
        $result = $this->select("SELECT material.`id`"
            . " ,material.`name`"
            . " ,`type`.`name` AS `type`"
            . " ,material.`language_id`"
            . " ,DATE_FORMAT(material.`date_publish`, \"%d/%m/%Y\") AS `date_publish`"
            . " ,material.`pub_place_id`"
            . " ,material.`count`"
            . " ,material.`file_path`"
            . " FROM `material` AS material"
            . " INNER JOIN `type` AS `type` ON material.`type_id` = `type`.`id`"
            . " WHERE material.`status` = 1"
            . " ORDER BY material.`date_add` DESC");
        return $result;
    }
    public function get_material_authors($id)
    {
        $result = $this->select("SELECT a.`id`, a.`name` FROM `material_author` m_a "
            . " LEFT JOIN `author` a ON a.`id` = m_a.`author_id`"
            . " WHERE m_a.`material_id`=?", [$id]);
        return $result;
    }
    public function get_material_subjects($id)
    {
        $result = $this->select("SELECT s.`id`, s.`name` FROM `material_subject` m_s "
            . " LEFT JOIN `subject` s ON s.`id` = m_s.`subject_id`"
            . " WHERE m_s.`material_id`=?", [$id]);
        return $result;
    }
    public function get_material_specialties($id)
    {
        $result = $this->select("SELECT s.`id`, s.`name` FROM `material_specialty` m_s "
            . " LEFT JOIN `specialty` s ON s.`id` = m_s.`specialty_id`"
            . " WHERE m_s.`material_id`=?", [$id]);
        return $result;
    }

    public function get_material_authors_id($id)
    {
        $author_id = [];
        $result = $this->select("SELECT `author_id` FROM `material_author`"
            . " WHERE `material_id`=?", [$id]);
        foreach ($result as $item) {
            array_push($author_id, $item["author_id"]);
        }
        return $author_id;
    }
    public function get_material_subjects_id($id)
    {
        $subject_id = [];
        $result = $this->select("SELECT `subject_id` FROM `material_subject`"
            . " WHERE `material_id`=?", [$id]);
        foreach ($result as $item) {
            array_push($subject_id, $item["subject_id"]);
        }
        return $subject_id;
    }
    public function get_material_specialties_id($id)
    {
        $specialty_id = [];
        $result = $this->select("SELECT `specialty_id`  FROM `material_specialty`"
            . " WHERE `material_id`=?", [$id]);
        foreach ($result as $item) {
            array_push($specialty_id, $item["specialty_id"]);
        }
        return $specialty_id;
    }

    public function get_material($id)
    {
        $result = $this->select("SELECT `id`"
            . " ,`name`"
            . " ,`type_id`"
            . " ,`language_id`"
            . " ,DATE_FORMAT(`date_publish`, \"%d/%m/%Y\") AS `date_publish`"
            . " ,`pub_place_id`"
            . " ,`count`"
            . " ,`file_path`"
            . " FROM `material` WHERE id=?", [$id])[0];
        return $result;
    }

    public function add_material($name, $type_id, $language_id, $date_publish, $pub_place_id, $count, $jsons, $unique_filename)
    {
        try {
            
            $id = $this->insert_get_id(
                "INSERT INTO `material` SET `name`=?,`type_id`=?,`language_id`=?,"
                    . "`date_publish`=?,`pub_place_id`=?,`count`=?,`user_id`=?,`file_path`=?",
                [$name, $type_id, $language_id, $date_publish, $pub_place_id, $count, $this->user_id, $unique_filename]
            );
            if ($id) {
                $authors = $jsons["authors"];
                $subjects = $jsons["subjects"];
                $specialties = $jsons["specialties"];

                foreach ($authors as $author) {
                    $this->insert("INSERT INTO `material_author` (`material_id`, `author_id`)"
                        . " VALUES (?, ?)", [$id, $author]);
                }
                foreach ($subjects as $subject) {
                    $this->insert("INSERT INTO `material_subject` (`material_id`, `subject_id`)"
                        . " VALUES (?, ?)", [$id, $subject]);
                }
                foreach ($specialties as $specialty) {
                    $this->insert("INSERT INTO `material_specialty` (`material_id`, `specialty_id`)"
                        . " VALUES (?, ?)", [$id, $specialty]);
                }
            }
        } 
        catch (Exception $ex) {
            return false;
        }
        return true;
    }
    public function edit_material($id, $name, $type_id, $language_id, $date_publish, $pub_place_id, $count, $file_path, $jsons)
    {
        $result = $this->update(
            "UPDATE `material` SET `name`=?"
                . " ,`type_id`=? "
                . " ,`language_id`=?"
                . " ,`date_publish`=?"
                . " ,`pub_place_id`=?"
                . " ,`count`=?"
                . " ,`file_path`=?"
                . " ,`date_edit`=?"
                . " ,`user_id`=?  WHERE id=?",
            [
                $name, $type_id, $language_id, $date_publish, $pub_place_id, $count, $file_path, $this->current_date, $this->user_id, $id
            ]
        );

        if ($result) {
            $authors = $jsons["authors"];
            $subjects = $jsons["subjects"];
            $specialties = $jsons["specialties"];

            $this->delete("DELETE FROM `material_author` WHERE `material_id`=?", [$id]);
            $this->delete("DELETE FROM `material_subject` WHERE `material_id`=?", [$id]);
            $this->delete("DELETE FROM `material_specialty` WHERE `material_id`=?", [$id]);

            foreach ($authors as $author) {
                $this->insert("INSERT INTO `material_author` (`material_id`, `author_id`)"
                    . " VALUES (?, ?)", [$id, $author]);
            }
            foreach ($subjects as $subject) {
                $this->insert("INSERT INTO `material_subject` (`material_id`, `subject_id`)"
                    . " VALUES (?, ?)", [$id, $subject]);
            }
            foreach ($specialties as $specialty) {
                $this->insert("INSERT INTO `material_specialty` (`material_id`, `specialty_id`)"
                    . " VALUES (?, ?)", [$id, $specialty]);
            }
        } else {
            return false;
        }

        return true;
    }
    public function delete_material($id)
{
    $result = $this->select("SELECT COUNT(*) as count FROM `material` WHERE `id`=?", [$id]);

    if ($result === false || $result[0]['count'] < 0) {
        return false;
    } else {
        return $this->delete("UPDATE `material` SET `status` = 0 WHERE id=?", [$id]);
    }
}

}
