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

    public static function generateItemCodeString($length = 10) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = 'COD';
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