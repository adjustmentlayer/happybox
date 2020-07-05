<?php

namespace App\Models;

use PDO;

class Photo extends \Core\Model
{

    public $path = '/img/';
    /**
     * Get all the boxes as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        $sql ="SELECT * FROM photos";

        $db = static::getDB();
        $stmt = $db->query($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        return $stmt->fetchAll();
    }

    
}