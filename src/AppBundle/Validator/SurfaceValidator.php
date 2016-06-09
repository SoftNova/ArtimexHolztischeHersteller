<?php
namespace AppBundle\Validator;
use AppBundle\Entity\TableLength;
use AppBundle\Entity\TableWidth;
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/9/2016
 * Time: 4:28 PM
 */
class SurfaceValidator
{
    public static function validateSurface($material, $tableLength, $drawerLength, $extLength, $tableWidth, TableLength $lengthObject, TableWidth $widthObject){
        $message=null;
        if (is_null($material)){
           $message='Corrupted data';
        }
        if ($tableLength < $lengthObject->getLengthLowerBound() || $tableLength > $lengthObject->getLengthUpperBound()) {
            $message = 'Corrupted data';
        }
        if ($tableWidth < $widthObject->getWidthLowerBound() || $tableWidth > $widthObject->getWidthUpperBound()) {
            $message = 'Corrupted data';
        }
        if (!is_null($drawerLength) && $drawerLength < $lengthObject->getDrawerLowerBound() || $drawerLength > $lengthObject->getDrawerUpperBound()){
            $message = 'Corrupted data';
        }
        if (!is_null($extLength) && $extLength < $lengthObject->getExtLowerBound() || $extLength > $lengthObject->getExtUpperBound()){
            $message = 'Corrupted data';
        }
        return is_null($message) ? null : $message;
    }
}