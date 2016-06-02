<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TableMaterial;
use AppBundle\Entity\TablePrimaryMaterial;
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
    public function indexAction()
    {
        $tableService=$this->get('table_service');
        $lang=$this->get('request')->getLocale();
        $surfaceService= $this->get('surface_service');

        /** @var TablePrimaryMaterial $primaryMaterialItem */
        $primaryMaterialItem = $surfaceService->getPrimaryMaterial();
        $primaryMaterial = !is_null($primaryMaterialItem) ? $primaryMaterialItem->getPrimaryMaterial()->getId() : null;

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
        $code = $this->get('request')->get('code');
        $timberService = $this->get('timber_service');
        $lang=$this->get('request')->getLocale();

        $aMaterials = $surfaceService->getMaterialsForLang($lang);
        $primaryMaterial = !is_null($surfaceService->getPrimaryMaterial()) ? $surfaceService->getPrimaryMaterial()->getPrimaryMaterial()->getId() : null;
        $table = $service->findByCode($code, $lang);
        $height = $surfaceService->getHeight();
        $width = $surfaceService->getWidth();
        $length = $surfaceService->getLength();
        $aTimberQuality = $timberService->getAllTimberQualityByLang($lang);
        $aTimberTempering = $timberService->getAllTimberTemperingByLang($lang);

        $altPath = Utils::DEFAULT_IMAGE;
        /** @var TableMaterial $material */
        foreach ($aMaterials as $material){
            $image = $this->get('liip_imagine.controller')
                ->filterAction(new Request(), (is_null($material->getImage()->getWebPath()) ? $altPath : $material->getImage()->getWebPath()), 'primaryImage')->getTargetUrl();
            $material->getImage()->setCachePath($image);
        }


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
     * @Route("/{_locale}/ajax/", name="_calculatePrice_ajax")
     */
    public function calculatePriceAjax(){
        $request = $this->get('request');
        $surfaceService = $this->get('surface_service');
        $tableSupportService = $this->get('table_support_service');
        $timberSpecsService = $this->get('timber_service');
        $lang=$this->get('request')->getLocale();
        $tableService=$this->get('table_service');

        if ($request->isXmlHttpRequest()){
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
            $code = $request->get('code');

            $tableItem = $tableService->findByCode($code, $lang);

            $surfacePrice = $surfaceService->calculateSurface($length, $width, $material);
            if ($surfacePrice == false){
                $custom = $this->get('translator')->trans('app.custom.order');
                return new \Symfony\Component\HttpFoundation\Response(json_encode(array('failure'=>$custom)));
            }
            $supportPrice = $tableSupportService->calculateSupportPrice($height, $profile, $tableItem);
            $extensionPrice = (!is_null($extensions)) ? $surfaceService->calculateExtensionSurface($extLength, $width, $material, $extensions) : 0;
            $drawerPrice = (!is_null($drawers)) ? $surfaceService->calculateDrawerSurface($drawerLength, $width, $tableItem, $drawers) : 0;

            $tablePrice = $surfacePrice + $supportPrice + $extensionPrice + $drawerPrice;
            $tablePrice = $timberSpecsService->applyQualityVariance($tablePrice, $quality);
            $tablePrice = !is_null($tempering) ? $timberSpecsService->applyTemperingVariance($tablePrice, $tempering) : $tablePrice;
            
            /* final by state variance price */
            $tablePrice = round($tablePrice + ($tableItem->getByStateVariance()/100 * $tablePrice));

            $currency = $this->get('translator')->trans('app.currency');
            $stringPrice = $currency . strval($tablePrice) . ",00";



            return new \Symfony\Component\HttpFoundation\Response(json_encode(array('success'=>$stringPrice)));
        }
        return new \Symfony\Component\HttpFoundation\Response('Invalid request!, 400');
    }

    /** @Route("/{_locale}/ajaxI", name="_getPrimaryImageByMaterial") */
    public function getPrImageByMat(){
        $request = $this->get('request');
        $tableService=$this->get('table_service');
        $lang=$this->get('request')->getLocale();
        if ($request->isXmlHttpRequest()) {
            $code = $request->get('itemCode');
            $material=$request->get('material');
            $tableItem = $tableService->findPrimaryImageByMaterial($material, $code);
            $altPath = Utils::DEFAULT_IMAGE;
            $image=$this->get('liip_imagine.controller')
                ->filterAction(new Request(), (is_null($tableItem) ? $altPath : $tableItem->getFirstImage()->getWebPath()), 'productDisplay')->getTargetUrl();
            return new \Symfony\Component\HttpFoundation\Response(json_encode(($image)));
        }
    }
    
}
