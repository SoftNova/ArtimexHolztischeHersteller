<?php
namespace AppBundle\Validator;
use AppBundle\Entity\TableLength;
use AppBundle\Entity\TableWidth;
use AppBundle\ValueObject\ConfiguredTablePriceVO;

/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/9/2016
 * Time: 4:28 PM
 */
class SurfaceValidator
{
    public static function validateSurface(ConfiguredTablePriceVO $tableConfigs, $material, TableLength $lengthObject, TableWidth $widthObject)
    {
        $message=null;
        if (is_null($material)){
            $message='Corrupted data';
        }
        if ($tableConfigs->getLength() < $lengthObject->getLengthLowerBound() || $tableConfigs->getLength() > $lengthObject->getLengthUpperBound()) {
            $message = 'Corrupted data';
        }
        if ($tableConfigs->getWidth() < $widthObject->getWidthLowerBound() || $tableConfigs->getWidth() > $widthObject->getWidthUpperBound()) {
            $message = 'Corrupted data';
        }
        $drawerLength = ($tableConfigs->getDrawerLength() ==='') ? null : $tableConfigs->getDrawerLength();
        if (!is_null($drawerLength) && $drawerLength < $lengthObject->getDrawerLowerBound() || $drawerLength > $lengthObject->getDrawerUpperBound()){
            $message = 'Corrupted data';
        }
        $extLength = ($tableConfigs->getExtLength()==='') ? null : $tableConfigs->getExtLength();
        if (!is_null($extLength) && $extLength < $lengthObject->getExtLowerBound() || $extLength > $lengthObject->getExtUpperBound()){
            $message = 'Corrupted data';
        }
        return is_null($message) ? null : $message;
    }
}