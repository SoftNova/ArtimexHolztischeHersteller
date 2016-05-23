<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/20/2016
 * Time: 10:07 AM
 */

namespace AppBundle\Service;


use AppBundle\Repository\ProductDAO;

class ProductService
{

    private $productDAO;
    public function __construct(ProductDAO $repo)
    {
        $this->productDAO = $repo;
    }

    public function getAll(){
        return $this->productDAO->findAll();
    }
    
    public function getAllByLang($lang){
        return $this->productDAO->findAllByLang($lang);
    }
    public function findByCode($code, $lang){
        return $this->productDAO->findByCode($code, $lang);
    }

}