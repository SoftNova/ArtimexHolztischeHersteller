<?php

namespace AppBundle\Controller;

use AppBundle\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
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
        $materialService= $this->get('material_service');
        $primaryMaterial = !is_null($materialService->getPrimaryMaterial()) ? $materialService->getPrimaryMaterial()->getPrimaryMaterial()->getId() : null;

        $aTables = $tableService->getAllByLang($lang);
        return $this->render('client/products.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'aTables'=>$aTables,
            'aArticles'=>null,
            'primaryMaterial'=>$primaryMaterial
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
        $primaryMaterial = !is_null($materialService->getPrimaryMaterial()) ? $materialService->getPrimaryMaterial()->getPrimaryMaterial()->getId() : null;
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
            'aTimberTempering'=>$aTimberTempering,
            'primaryMaterial'=>$primaryMaterial
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

    /**
     * @Route("/{_locale}/ajax", name="_calculatePrice_ajax")
     */
    public function calculatePriceAjax(){
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()){
            $data = $request->get('data');
            $length = $request->get('length');
            $width = $request->get('width');
            $height = $request->get('height');
            $profile= $request->get('profile');
            $extensions= $request->get('extensions');
            $extLength= $request->get('extLength');
            $drawers= $request->get('drawers');
            $drawerLength= $request->get('drawerLength');
            $material=$request->get('material');
            $quality= $request->get('quality');
            $tempering= $request->get('tempering');
            $itemID= $request->get('itemID');


            $surfacePrice = $length * $width;

            $fullHeightPrice = $height * 100; //to do

            $extensionsPrice = $extensions * $extLength * $width;

            $drawersPrice = $drawers * $drawerLength * $width;

            $materialPrice = /* material */ 100;

            $qualityPrice = /* quality */100;
            $temperingPrice = /*tempering*/100;

            $totalPrice = 1234.44;
            $currency = $this->get('translator')->trans('app.currency');
//            $result = $currency . $totalPrice;
            return new \Symfony\Component\HttpFoundation\Response($length);
        }
        return new Response('Invalid request!, 400');
    }
}
