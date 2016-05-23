<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/23/2016
 * Time: 1:30 PM
 */

namespace AppBundle\Service;


use AppBundle\Repository\TableMaterialDAO;
use AppBundle\Repository\TablePrimaryMaterialDAO;

class MaterialService
{
    private $materialDAO;
    private $primalMaterialDAO;

    public function __construct(TableMaterialDAO $matDAO, TablePrimaryMaterialDAO $prDAO){
        $this->materialDAO=$matDAO;
        $this->primalMaterialDAO=$prDAO;
    }

    public function getMaterialsForLang($lang){
        return $this->materialDAO->findAllByLang($lang);
    }

    public function getPrimaryMaterial(){
        return ($this->primalMaterialDAO->findAll() ? $this->primalMaterialDAO->findAll()[0]
            : null);
    }
}