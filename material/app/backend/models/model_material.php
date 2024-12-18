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
            . " ,kafedra.`name` AS kafedra"
            . " ,faculty.`name` AS faculty"
            . " ,material.`status` AS status_id"
            . " ,material_status.`desciption` AS `status`"
            . " ,material.`comment`"
            . " ,material.`conference_name`"
            . " ,material.`name_jurnal`"
            . " ,md.`name` AS direction"
            . " ,material.`url`"
            . " FROM `material` AS material"
            . " INNER JOIN `type` AS `type` ON material.`type_id` = `type`.`id`"
            . " INNER JOIN `kafedra` AS `kafedra` ON material.`kafedra_id` = `kafedra`.`id`"
            . " INNER JOIN `faculty` AS `faculty` ON kafedra.`faculty_id` = `faculty`.`id`"
            . " INNER JOIN `material_direction` AS `md` ON material.`material_direction_id` = `md`.`id`"
            . " INNER JOIN `material_status` AS `material_status` ON material_status.`id` = `material`.`status`"
            . " WHERE material.`status` <> 0 "
            . " ORDER BY material.`date_add` DESC");
        return $result;
    }

    public function get_materialByuserId($id, $user_id)
    {
        if ($id == 4) {
            return $this->select("SELECT DISTINCT  material.`id`"
                . " ,material.`name`"
                . " ,`type`.`name` AS `type`"
                . " ,material.`language_id`"
                . " ,DATE_FORMAT(material.`date_publish`, \"%d/%m/%Y\") AS `date_publish`"
                . " ,material.`pub_place_id`"
                . " ,material.`count`"
                . " ,material.`file_path`"
                . " ,kafedra.`name` AS kafedra"
                . " ,faculty.`name` AS faculty"
                . " ,material.`file_path`"
                . " ,material.`status` AS status_id"
                . " ,material_status.`desciption` AS `status`"
                . " ,material.`comment`"
                . " ,material.`conference_name`"
                . " ,material.`name_jurnal`"
                . " ,md.`name` AS direction"
                . " ,material.`url`"
                . " ,mdd.`name` AS MD"
                . " FROM `material` AS material"
                . " INNER JOIN `type` AS `type` ON material.`type_id` = `type`.`id`"
                . " INNER JOIN `user` AS `user` ON material.`user_id` = `user`.`id`"
                . " INNER JOIN `kafedra` AS `kafedra` ON material.`kafedra_id` = `kafedra`.`id`"
                . " INNER JOIN `faculty` AS `faculty` ON kafedra.`faculty_id` = `faculty`.`id`"
                . " INNER JOIN `material_direction` AS `md` ON material.`material_direction_id` = `md`.`id`"
                . " INNER JOIN `material_status` AS `material_status` ON material_status.`id` = `material`.`status`"
                . " LEFT JOIN `material_direction_dictionary` AS `mdd` ON mdd.`id` = `material`.`material_direction_dictionary_id`"
                . " WHERE material.`status` = 2 ");
        } 
        else if ($id == 1) {
            return $this->select(" SELECT DISTINCT material.`id`"
            ." ,material.`name`"
            ." ,`type`.`name` AS `type`"
            ." ,material.`language_id`"
            ." ,material.`date_publish`"
            ." ,material.`pub_place_id`"
            ." ,material.`count`"
            ." ,material.`file_path`"
            ." ,kafedra.`name` AS kafedra"
            ." ,faculty.`name` AS faculty"
            ." ,material_status.`desciption` AS `status`"
            ." ,material.`comment`"
            ." ,material.`conference_name`"
            ." ,material.`name_jurnal`"
            ." ,md.`name` AS direction"
            ." ,material.`url`"
            ." ,mdd.`name` AS MD"
            ." FROM `material` AS material"
            ." INNER JOIN `type` ON material.`type_id` = `type`.`id`"
            ." INNER JOIN `kafedra` ON material.`kafedra_id` = `kafedra`.`id`"
            ." INNER JOIN `faculty` ON kafedra.`faculty_id` = `faculty`.`id`"
            ." INNER JOIN `material_direction` AS `md` ON material.`material_direction_id` = `md`.`id`"
            ." INNER JOIN `material_status` ON material_status.`id` = material.`status`"
            ." LEFT JOIN `material_direction_dictionary` AS `mdd` ON mdd.`id` = material.`material_direction_dictionary_id`"
            ." INNER JOIN `user` ON `material`.`user_id` = user.id"
            ." INNER JOIN material_author ON material.id = material_author.material_id"
            ." INNER JOIN author ON material_author.author_id = author.id"
            ." WHERE `user`.`role_id` = ? AND material.`user_id` = ?", 
                [$id, $user_id]);
        }

        return $this->select(
            " SELECT DISTINCT material.`id`"
            ." ,material.`name`"
            ." ,`type`.`name` AS `type`"
            ." ,material.`language_id`"
            ." ,DATE_FORMAT(material.`date_publish`, \"%d/%m/%Y\") AS `date_publish`"
            ." ,material.`pub_place_id`"
            ." ,material.`count`"
            ." ,material.`file_path`"
            ." ,kafedra.`name` AS kafedra"
            ." ,faculty.`name` AS faculty"
            ." ,material.`status` AS status_id"
            ." ,material_status.`desciption` AS `status`"
            ." ,material.`comment`"
            ." ,material.`conference_name`"
            ." ,material.`name_jurnal`"
            ." ,md.`name` AS direction"
            ." ,material.`url`"
            ." ,mdd.`name` AS MD"
            ." FROM `material` AS material"
            ." INNER JOIN `type` ON material.`type_id` = `type`.`id`"
            ." INNER JOIN `kafedra` ON material.`kafedra_id` = `kafedra`.`id`"
            ." INNER JOIN `faculty` ON kafedra.`faculty_id` = `faculty`.`id`"
            ." INNER JOIN `material_direction` AS `md` ON material.`material_direction_id` = `md`.`id`"
            ." INNER JOIN `material_status` ON material_status.`id` = material.`status`"
            ." LEFT JOIN `material_direction_dictionary` AS `mdd` ON mdd.`id` = material.`material_direction_dictionary_id`"
            ." INNER JOIN `user` ON `material`.`user_id` = user.id"
            ." INNER JOIN material_author ON material.id = material_author.material_id"
            ." INNER JOIN author ON material_author.author_id = author.id"
            ." WHERE material.`status` IN (1,5) AND `material`.`kafedra_id` = (SELECT kafedra_id FROM `user` WHERE id = ?)",
            [$user_id]
        );
        
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
            . " ,(SELECT `name` FROM kafedra WHERE id = `kafedra_id`)"
            . " ,`conference_name`"
            . " ,`name_jurnal`"
            . " ,`url`"
            . " ,`material_direction_id`"
            . " ,`material_direction_dictionary_id`"
            . " FROM `material` WHERE id=?", [$id])[0];
        return $result;
    }

    public function add_material($name, $type_id, $language_id, $date_publish, $pub_place_id, $count, $jsons, $unique_filename, $kafedra, $nameOfTheConference, $namejurnal, $url, $direction, $direction_dictionary)
    {
        try {
            if (!$this->select("SELECT * FROM `material` WHERE `name` = ? AND `language_id` = ?", [$name, $language_id])) {
                $kafedra_id = $this->select("SELECT id FROM kafedra WHERE name=? LIMIT 1", [$kafedra])[0]["id"];
                //echo $kafedra_id;
                $id = $this->insert_get_id(
                    "INSERT INTO `material` SET `name`=?,`type_id`=?,`language_id`=?,"
                    . "`date_publish`=?,`pub_place_id`=?,`count`=?,`user_id`=?,`file_path`=?,`kafedra_id`=?, `conference_name`=?, `name_jurnal`=?, `url`=?, `material_direction_id`=?,`material_direction_dictionary_id`=?",
                    [$name, $type_id, $language_id, $date_publish, $pub_place_id, $count, $this->user_id, $unique_filename, $kafedra_id, $nameOfTheConference, $namejurnal, $url, $direction, $direction_dictionary]
                );
                if ($id) {
                    $authors = $jsons["authors"];

                    foreach ($authors as $author) {
                        $this->insert("INSERT INTO `material_author` (`material_id`, `author_id`)"
                            . " VALUES (?, ?)", [$id, $author]);
                    }
                }
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            return false;
        }
    }
    public function edit_material($id, $name, $type_id, $language_id, $date_publish, $pub_place_id, $count, $file_path, $jsons, $kafedra, $nameOfTheConference, $namejurnal, $url, $direction, $direction_dictionary)
    {
        //echo 'hi';
        $kafedra_id = $this->select("SELECT id FROM kafedra WHERE name=? LIMIT 1", [$kafedra])[0]["id"];
        //echo $kafedra_id;
        $result = $this->update(
            "UPDATE `material` SET `name`=?"
            . " ,`type_id`=? "
            . " ,`language_id`=?"
            . " ,`date_publish`=?"
            . " ,`pub_place_id`=?"
            . " ,`count`=?"
            . " ,`file_path`=?"
            . " ,`date_edit`=?"
            . " ,`kafedra_id`=?"
            . " ,`conference_name`=?"
            . " ,`name_jurnal`=?"
            . " ,`url`=?"
            . " ,`material_direction_id`=?"
            . " ,`material_direction_dictionary_id`=?"
            . " ,`status` = 1 WHERE id=?",
            [
                $name,
                $type_id,
                $language_id,
                $date_publish,
                $pub_place_id,
                $count,
                $file_path,
                $this->current_date,
                $kafedra_id,
                $nameOfTheConference,
                $namejurnal,
                $url,
                $direction,
                $direction_dictionary,
                $id
            ]
        );

        if ($result) {
            $authors = $jsons["authors"];

            $this->delete("DELETE FROM `material_author` WHERE `material_id`=?", [$id]);

            foreach ($authors as $author) {
                $this->insert("INSERT INTO `material_author` (`material_id`, `author_id`)"
                    . " VALUES (?, ?)", [$id, $author]);
            }
        } else {
            return false;
        }

        return true;
    }
    public function confirm_material($id, $user_role)
    {
        if ($user_role == "2") {
            return $this->update(
                "UPDATE `material` SET `status`= 2"
                . " ,`date_edit`=?"
                . " ,`user_k`=?  WHERE id=? AND `status` = '1'",
                [
                    $this->current_date,
                    $this->user_id,
                    $id
                ]
            );
        } else if ($user_role == "4") {
            return $this->update(
                "UPDATE `material` SET `status`= 3"
                . " ,`date_edit`=?"
                . " ,`user_d`=?  WHERE id=? AND `status` = '2'",
                [
                    $this->current_date,
                    $this->user_id,
                    $id
                ]
            );
        }
        return false;
    }
    public function decline_material($id, $comment, $user_role)
    {
        if ($user_role == "2") {
            return $this->update(
                "UPDATE `material` SET `status`= 4"
                . " ,`date_edit`=?"
                . " ,`comment`=? "
                . " ,`user_k`=?  WHERE id=?",
                [
                    $this->current_date,
                    $comment,
                    $this->user_id,
                    $id
                ]
            );
        } else if ($user_role == "4") {
            return $this->update(
                "UPDATE `material` SET `status`= 5"
                . " ,`date_edit`=?"
                . " ,`comment`=? "
                . " ,`user_d`=?  WHERE id=?",
                [
                    $this->current_date,
                    $comment,
                    $this->user_id,
                    $id
                ]
            );
        }
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
    public function get_materials_by_author($id)
    {
        $result = $this->select("SELECT m.`id`"
            . " ,m.`name`"
            . " ,t.`name` AS type_name"
            . " ,m.`language_id`"
            . " ,m.`date_publish` AS `date_publish`"
            . " ,m.`pub_place_id`"
            . " ,m.`count` FROM `material` m"
            . " LEFT JOIN `type` t ON t.`id`=m.`type_id`"
            . " LEFT JOIN `material_author` ma ON ma.`material_id`=m.`id`"
            . " WHERE ma.`author_id`=? ORDER BY m.`date_add` DESC", [$id]);
        return $result;
    }

    public function get_materials_by_specialty($id)
    {
        $result = $this->select("SELECT m.`id`"
            . " ,m.`name`"
            . " ,t.`name` AS type_name"
            . " ,m.`language_id`"
            . " ,m.`date_publish` AS `date_publish`"
            . " ,m.`pub_place_id`"
            . " ,m.`count` FROM `material` m"
            . " LEFT JOIN `type` t ON t.`id`=m.`type_id`"
            . " LEFT JOIN `material_specialty` ms ON ms.`material_id`=m.`id`"
            . " WHERE ms.`specialty_id`=? ORDER BY m.`date_add` DESC", [$id]);
        return $result;
    }

    public function get_materials_by_subject($id)
    {
        $result = $this->select("SELECT m.`id`"
            . " ,m.`name`"
            . " ,t.`name` AS type_name"
            . " ,m.`language_id`"
            . " ,m.`date_publish` AS `date_publish`"
            . " ,m.`pub_place_id`"
            . " ,m.`count` FROM `material` m"
            . " LEFT JOIN `type` t ON t.`id`=m.`type_id`"
            . " LEFT JOIN `material_subject` ms ON ms.`material_id`=m.`id`"
            . " WHERE ms.`subject_id`=? ORDER BY m.`date_add` DESC", [$id]);
        return $result;
    }
    public function get_types(){
		$result = $this->select("SELECT `id`"
                                        ." ,`name`"
                                        ." FROM `type` ORDER BY `date_add` DESC"
        );
		return $result;
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
