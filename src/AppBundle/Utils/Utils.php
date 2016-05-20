<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 5/14/2016
 * Time: 11:07 AM
 */

namespace AppBundle\Utils;


class Utils
{
    const TABLE_IMAGE_PATH = 'app/img/table_img/';
    const PRODUCT_IMAGE_PATH = 'app/img/product_img/';
    const MATERIAL_IMAGE_PATH = 'app/img/material_img/';
    const DEFAULT_IMAGE='app/img/no.png';

    const ALLOWED_IMG_EXT = array('jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG');
    const INVALID_FILE_EXTENSION = "Invalid file extension";

    public static function generateItemCodeString($length = 10, $class) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $classArray = explode("\\",$class);
        $class=end($classArray);
        $randomString = "";
        switch ($class){
            case "Table":
                $randomString="TAB";
                break;
            case "TableMaterial":
                $randomString="MAT";
                break;
            case "Product":
                $randomString="PRO";
                break;
        }
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    public static function generateImageString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}