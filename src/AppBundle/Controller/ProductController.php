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
            'aTables'=>$aTables,
            'aArticles'=>null
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
            'aArticles' => $aArticles,
            'aTables'=>null
        ]);
    }

    /**
     * @Route("/{_locale}/{name}/{code}", name="_specificTable")
     */
    public function getSpecificTable(){

        $service=$this->get('table_service');
        $surfaceService=$this->get('surface_service');
        $materialService= $this->get('material_service');
        $code = $this->get('request')->get('code');
        $timberService = $this->get('timber_service');
        $lang=$this->get('request')->getLocale();

        $aMaterials = $materialService->getMaterialsForLang($lang);
        $table = $service->findByCode($code, $lang);
        $height = $surfaceService->getHeight();
        $width = $surfaceService->getWidth();
        $length = $surfaceService->getLength();
        $aTimberQuality = $timberService->getAllTimberQualityByLang($lang);
        $aTimberTempering = $timberService->getAllTimberTemperingByLang($lang);


        return $this->render('client/subContent/table.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'oItem'=>$table,
            'width' => $width,
            'length'=>$length,
            'height'=>$height,
            'aMaterials'=>$aMaterials,
            'aTimberQuality'=>$aTimberQuality,
            'aTimberTempering'=>$aTimberTempering
        ]);
    }
    /**
     * @Route("/{_locale}/{name}-{code}", name="_specificArticle")
     */
    public function getSpecificArticle(){
        $service=$this->get('article_service');
        $code = $this->get('request')->get('code');
        $lang=$this->get('request')->getLocale();

        $article = $service->findByCode($code, $lang);
        return $this->render('client/subContent/article.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'oItem' => $article
        ]);
    }




}
