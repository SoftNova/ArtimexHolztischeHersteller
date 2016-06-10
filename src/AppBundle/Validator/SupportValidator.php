<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/10/2016
 * Time: 10:07 AM
 */

namespace AppBundle\Validator;


use AppBundle\Entity\TableHeight;
use Doctrine\Common\Collections\ArrayCollection;

class SupportValidator
{
    public static function validateSupport($height, $profileId, TableHeight $heightObject, $profilesArray)
    {
        $message = null;
        if ($height < $heightObject->getHeightLowerBound() || $height > $heightObject->getHeightUpperBound()) {
            $message = 'Corrupted data';
        }
        if (!is_null($profileId)) {
            $profileIds = new ArrayCollection(array_map(function($p){ return $p->getId();}, $profilesArray->getValues()));
            if (!$profileIds->contains(intval($profileId))) {
                $message = 'Corrupted data';
            }
        }
        return is_null($message) ? null : $message;
    }
}