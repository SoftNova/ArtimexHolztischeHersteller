<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/20/2016
 * Time: 10:07 AM
 */

namespace AppBundle\Service;


use AppBundle\Repository\TableDAO;

class TableService
{
    private $tableDAO;
    public function __construct(TableDAO $repo)
    {
        $this->tableDAO = $repo;
    }

    public function getAll(){
        return $this->tableDAO->findAll();
    }
    
    public function getAllByLang($lang, $categoryId){
        return $this->tableDAO->findAllByLang($lang, $categoryId);
    }

    public function findByCode($code, $lang){
        return $this->tableDAO->findByCode($code, $lang);
    }
    public function findPrimaryImageByMaterial($materialID,$code){
        return $this->tableDAO->findPrimaryImageByMaterial($materialID,$code);
    }
    public function getAllByLangNoCategory($lang){
        return $this->tableDAO->findAllByLangNoCategory($lang);
    }
    
}