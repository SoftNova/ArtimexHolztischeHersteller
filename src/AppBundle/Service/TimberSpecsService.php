<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/23/2016
 * Time: 1:58 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\TableMaterialTempering;
use AppBundle\Entity\TableTimberQuality;
use AppBundle\Repository\TableTimberQualityDAO;
use AppBundle\Repository\TimberTemperingDAO;

class TimberSpecsService
{
    private $timberQualityDAO;
    private $timberTemperingDAO;

    public function __construct(TableTimberQualityDAO $qDAO, TimberTemperingDAO $tDAO)
    {
        $this->timberQualityDAO=$qDAO;
        $this->timberTemperingDAO=$tDAO;
    }

    public function getAllTimberQualityByLang($lang){
        return $this->timberQualityDAO->findAllByLang($lang);
    }

    public function getAllTimberTemperingByLang($lang){
        return $this->timberTemperingDAO->findAllByLang($lang);
    }

    public function applyQualityVariance($totalPrice, $qualityID){
        /** @var TableTimberQuality $qualityType */
        $qualityType = $this->timberQualityDAO->find($qualityID);
        $totalPrice = $totalPrice + ($qualityType->getCostIncrease()/100 * $totalPrice);
        return $totalPrice;
    }
    public function applyTemperingVariance($totalPrice, $temperingID){
        if (is_null($temperingID)){
            return $totalPrice;
        }else{
            /** @var TableMaterialTempering $temperingType */
            $temperingType = $this->timberTemperingDAO->find($temperingID);
            $totalPrice = $totalPrice + ($temperingType->getCostIncrease()/100 * $totalPrice);
            return $totalPrice;
        }
    }
}