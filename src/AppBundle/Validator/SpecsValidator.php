<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/10/2016
 * Time: 11:37 AM
 */

namespace AppBundle\Validator;


class SpecsValidator
{
    public static function validateSpecs($quality, $tempering){
        $message=null;

        if (is_null($quality)){
            $message='Corrupted data';
        }
        if (is_null($tempering)){
            $message='Corrupted data';
        }

        return is_null($message) ? null : $message;
    }
}