<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/23/2016
 * Time: 11:01 AM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Table;
use AppBundle\Entity\TableLength;
use AppBundle\Entity\TableMaterial;
use AppBundle\Entity\TablePrimaryMaterial;
use AppBundle\Repository\TableHeightDAO;
use AppBundle\Repository\TableLengthDAO;
use AppBundle\Repository\TableMaterialDAO;
use AppBundle\Repository\TablePrimaryMaterialDAO;
use AppBundle\Repository\TableWidthDAO;

class SurfaceService
{
    private $heightDAO;
    private $lengthDAO;
    private $widthDAO;
    private $materialDAO;
    private $primalMaterialDAO;

    public function __construct(TableLengthDAO $ldao, TableWidthDAO $wdao, TableHeightDAO $hdao, TableMaterialDAO $mDAO, TablePrimaryMaterialDAO $pmDAO)
    {
        $this->heightDAO=$hdao;
        $this->lengthDAO=$ldao;
        $this->widthDAO=$wdao;
        $this->materialDAO=$mDAO;
        $this->primalMaterialDAO=$pmDAO;
    }


    public function getLength(){
        return (!is_null($this->lengthDAO->findAll()) ? $this->lengthDAO->findAll()[0] : null);

    }

    public function getWidth(){
        return (!is_null($this->widthDAO->findAll()) ? $this->widthDAO->findAll()[0] : null);
    }

    public function getHeight()
    {
        return (!is_null($this->heightDAO->findAll()) ? $this->heightDAO->findAll()[0] : null);
    }

    public function getMaterialsForLang($lang){
        return $this->materialDAO->findAllByLang($lang);
    }

    /** @var TablePrimaryMaterial */
    public function getPrimaryMaterial(){
        return ($this->primalMaterialDAO->findAll() ? $this->primalMaterialDAO->findAll()[0]
            : null);
    }
    public function getMaterialById($material){
        return $this->materialDAO->find($material);
    }

    public function calculateSurface($length, $width, $materialID){
        /**
         * @var TablePrimaryMaterial $primaryMaterial
         * @var TableMaterial $material
         */

        $material = $this->materialDAO->find($materialID);
        $primaryMaterial = $this->primalMaterialDAO->findAll() ? $this->primalMaterialDAO->findAll()[0]
            : null;
        $primaryMaterialPrice = $primaryMaterial->getPricePerSquareMeter();
        $materialPrice = ($primaryMaterialPrice + (($material->getPercentage()/100) * $primaryMaterialPrice));
        $surface = ($length * $width) / 10000;
        $totalSurfaceCost=0;
        if ($surface >= 3){
            return false;
        }

        if ($surface >= $material->getScalingPoint()){
            $totalSurfaceCost = ($surface * $materialPrice) + ($material->getScalingPercentage()/100 * ($surface * $materialPrice));
        }
        else{
            $totalSurfaceCost = $surface * $materialPrice;
        }

        return $totalSurfaceCost;
    }
    
    public function calculateDrawerSurface($drawerLength, $tableWidth, $table, $nrOfDrawersSelected){
        /** @var Table $table */
        $surface = ($drawerLength * $tableWidth) / 10000;
        $totalDrawerCost = ($surface * $table->getDrawerAttribute()->getBasePrice()) * $nrOfDrawersSelected;

        return $totalDrawerCost;
    }

    public function calculateExtensionSurface($length, $width, $materialID, $nrOfExtensions){
        /**
         * @var TablePrimaryMaterial $primaryMaterial
         * @var TableMaterial $material
         */

        $material = $this->materialDAO->find($materialID);
        $primaryMaterial = $this->primalMaterialDAO->findAll() ? $this->primalMaterialDAO->findAll()[0]
            : null;
        $primaryMaterialPrice = $primaryMaterial->getPricePerSquareMeter();
        $materialPrice = ($primaryMaterialPrice + (($material->getPercentage()/100) * $primaryMaterialPrice));
        $surface = ($length * $width) / 10000;
        $totalSurfaceCost=$surface*$materialPrice * $nrOfExtensions;


        return $totalSurfaceCost;
    }
}
