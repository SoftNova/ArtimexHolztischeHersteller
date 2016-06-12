<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/20/2016
 * Time: 10:07 AM
 */

namespace AppBundle\Service;


use AppBundle\Repository\ProductDAO;
use Symfony\Component\HttpFoundation\RequestStack;

class ArticleService
{

    private $productDAO;
    private $request;
    public function __construct(ProductDAO $repo, RequestStack $requestStack)
    {
        $this->request=$requestStack->getCurrentRequest();
        $this->productDAO = $repo;
    }

    public function getAll(){
        return $this->productDAO->findAll();
    }
    
    public function getAllByLang(){
        $lang=$this->request->getLocale();
        return $this->productDAO->findAllByLang($lang);
    }
    public function findByCode($code){
        $lang=$this->request->getLocale();
        return $this->productDAO->findByCode($code, $lang);
    }

}