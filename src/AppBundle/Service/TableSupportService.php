<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/27/2016
 * Time: 12:30 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Table;
use AppBundle\Entity\TableHeight;
use AppBundle\Entity\TableLegProfile;
use AppBundle\Repository\TableDAO;
use AppBundle\Repository\TableHeightDAO;
use AppBundle\Repository\TableLegProfileDAO;

class TableSupportService
{
    private $heightDAO;
    private $legDAO;
    private $tableDAO;

    public function __construct(TableLegProfileDAO $tl, TableHeightDAO $th, TableDAO $td)
    {
        $this->heightDAO = $th;
        $this->legDAO = $tl;
        $this->tableDAO = $td;
    }

    public function findProfile($profileID){
        return $this->legDAO->find($profileID);
    }
    public function calculateSupportPrice($height, $profileID, $tableItem){
        /** @var TableLegProfile $profile */
        /** @var TableHeight $heightItem */
        /** @var TableLegProfile $profile */
        /** @var Table $tableItem */
        $profile = ($profileID > 0) ? $this->legDAO->find($profileID) : null;
        $heightItem = $this->heightDAO->findAll()[0];
        $procentualVariance=$this->determineTotalVariance($height, $heightItem);
        $tableLegBaseCost = $tableItem->getLegAttribute()->getBasePrice();
        $preHeightCost = is_null($profile) ? $tableLegBaseCost : $profile->getVariance() + $tableLegBaseCost;

        $totalSupportCost = $preHeightCost + ($procentualVariance/100 * $preHeightCost);
        return $totalSupportCost;

    }

    private function determineTotalVariance($height, $heightItem){
        /** @var TableHeight $heightItem */
        $initialStep = 10;
        $varianceCounter=1;
        $lowerBound = $heightItem->getHeightLowerBound()+$initialStep;
        $upperBound = $heightItem->getHeightUpperBound();
        for ($i=$lowerBound; $i<=$upperBound;$i=$i+$heightItem->getStep()) {
            if ($height <= $i) {
                break;
            }
            $varianceCounter++;
        }
        return ($heightItem->getCostPerStep()*$varianceCounter);
    }

    private function applyStateVariance($table, $totalPrice){
        /** @var Table $table */
        $totalPrice = $totalPrice + ($table->getByStateVariance()/100 * $totalPrice);
        return $totalPrice;
    }
}