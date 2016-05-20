<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    /**
     * @Route("/{_locale}/tables", name="_products")
     */
    public function indexAction(Request $request)
    {
        $tableService=$this->get('table_service');
        $lang=$this->get('request')->getLocale();

        $aTables = $tableService->getAllByLang($lang);
        return $this->render('client/products.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'aItems'=>$aTables
        ]);
    }

    /**
     * @Route("/{_locale}/articles", name="_allArticles")
     */
    public function getAllProducts(){
        $articleService = $this->get('article_service');
        $lang=$this->get('request')->getLocale();
        $aArticles=$articleService->getAllByLang($lang);
        return $this->render('client/products.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'aItems' => $aArticles,
        ]);
    }

    /**
     * @Route("/{_locale}/{name}", name="_specificProduct")
     */
    public function getSpecificProduct(){

        return $this->render('client/subContent/product.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }




}
