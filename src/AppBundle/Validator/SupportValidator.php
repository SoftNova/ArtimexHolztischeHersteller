<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/10/2016
 * Time: 10:07 AM
 */

namespace AppBundle\Validator;


use AppBundle\Entity\TableHeight;
use AppBundle\ValueObject\ConfiguredTablePriceVO;
use Doctrine\Common\Collections\ArrayCollection;

class SupportValidator
{
    public static function validateSupport(ConfiguredTablePriceVO $tableConfigs, TableHeight $heightObject, $profilesArray)
    {
        $message = null;
        if ($tableConfigs->getHeight() < $heightObject->getHeightLowerBound() || $tableConfigs->getHeight() > $heightObject->getHeightUpperBound()) {
            $message = 'Corrupted data';
        }
        if (!is_null($tableConfigs->getProfile())) {
            $profileIds = new ArrayCollection(array_map(function($p){ return $p->getId();}, $profilesArray->getValues()));
            if (!$profileIds->contains(intval($tableConfigs->getProfile()))) {
                $message = 'Corrupted data';
            }
        }
        return is_null($message) ? null : $message;
    }
}