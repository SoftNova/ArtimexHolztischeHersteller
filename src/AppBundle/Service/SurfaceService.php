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
use AppBundle\ValueObject\ConfiguredTablePriceVO;

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

    /** @return TablePrimaryMaterial */
    public function getPrimaryMaterial(){
        return ($this->primalMaterialDAO->findAll() ? $this->primalMaterialDAO->findAll()[0]
            : null);
    }
    public function getMaterialById($material){
        return $this->materialDAO->find($material);
    }

    public function calculateSurface(ConfiguredTablePriceVO $tableConfigs){
        /**
         * @var TablePrimaryMaterial $primaryMaterial
         * @var TableMaterial $material
         */

        $material = $this->materialDAO->find($tableConfigs->getMaterial());
        $primaryMaterial = $this->primalMaterialDAO->findAll() ? $this->primalMaterialDAO->findAll()[0]
            : null;
        $primaryMaterialPrice = $primaryMaterial->getPricePerSquareMeter();
        $materialPrice = ($primaryMaterialPrice + (($material->getPercentage()/100) * $primaryMaterialPrice));
        $surface = ($tableConfigs->getLength() * $tableConfigs->getWidth()) / 10000;
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
    
    public function calculateDrawerSurface(ConfiguredTablePriceVO $tableConfigs, $table){
        /** @var Table $table */
        if (is_null($tableConfigs->getDrawers())){
            return 0;
        }

        $surface = ($tableConfigs->getDrawerLength() * $tableConfigs->getWidth()) / 10000;
        $totalDrawerCost = ($surface * $table->getDrawerAttribute()->getBasePrice()) * $tableConfigs->getDrawers();

        return $totalDrawerCost;
    }

    public function calculateExtensionSurface(ConfiguredTablePriceVO $tableConfigs){
        /**
         * @var TablePrimaryMaterial $primaryMaterial
         * @var TableMaterial $material
         */

        if (is_null($tableConfigs->getExtensions())){
            return 0;
        }
        $material = $this->materialDAO->find($tableConfigs->getMaterial());
        $primaryMaterial = $this->primalMaterialDAO->findAll() ? $this->primalMaterialDAO->findAll()[0]
            : null;
        $primaryMaterialPrice = $primaryMaterial->getPricePerSquareMeter();
        $materialPrice = ($primaryMaterialPrice + (($material->getPercentage()/100) * $primaryMaterialPrice));
        $surface = ($tableConfigs->getExtLength() * $tableConfigs->getWidth()) / 10000;
        $totalSurfaceCost=$surface*$materialPrice * $tableConfigs->getExtensions();


        return $totalSurfaceCost;
    }

    public function findTableSpecificMaterials($lang, $tableId)
    {
        return $this->materialDAO->findTableSpecificMaterials($lang, $tableId);
    }
}
