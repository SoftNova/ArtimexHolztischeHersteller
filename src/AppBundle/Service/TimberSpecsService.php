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
use AppBundle\ValueObject\ConfiguredTablePriceVO;

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

    public function applyQualityVariance($totalPrice, ConfiguredTablePriceVO $tableConfigs){
        if (is_null($tableConfigs->getQuality())){
            return $totalPrice;
        }else {
            /** @var TableTimberQuality $qualityType */
            $qualityType = $this->timberQualityDAO->find($tableConfigs->getQuality());
            $totalPrice = $totalPrice + ($qualityType->getCostIncrease() / 100 * $totalPrice);
            return $totalPrice;
        }
    }
    public function applyTemperingVariance($totalPrice, ConfiguredTablePriceVO $tableConfigs){
        if (is_null($tableConfigs->getTempering())){
            return $totalPrice;
        }else{
            /** @var TableMaterialTempering $temperingType */
            $temperingType = $this->timberTemperingDAO->find($tableConfigs->getTempering());
            $totalPrice = $totalPrice + ($temperingType->getCostIncrease()/100 * $totalPrice);
            return $totalPrice;
        }
    }
    public function getTimberQualityById ($qId){
        return $this->timberQualityDAO->find($qId);
    }
    
    public function getTimberTemperingByid($tId){
        return $this->timberTemperingDAO->find($tId);
    }
}