<?php

namespace App\Models;

use PDO;

class Box extends \Core\Model
{

    public $path = '/img/';
    /**
     * Get all the boxes as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        $sql ="SELECT * FROM boxes";

        $db = static::getDB();
        $stmt = $db->query($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        return $stmt->fetchAll();
    }


    /**
     * Get box by id as an associative array
     *
     * @return array
     */
    public function getOne($id)
    {
        $sql = "SELECT * FROM boxes
                WHERE id = :id";
        $db = static::getDB();

        $stmt = $db->prepare($sql);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Get products by id as an associative array
     *
     * @return array
     */
    public static function getProducts($id)
    {
        $sql = "SELECT product_name, product_img FROM products p, boxes_have_products b
                WHERE b.box_id = :id
                AND p.product_id = b.product_id";
        $db = static::getDB();

        $stmt = $db->prepare($sql);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    
}