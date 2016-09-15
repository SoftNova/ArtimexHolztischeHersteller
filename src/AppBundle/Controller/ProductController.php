<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TablePrimaryMaterial;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
/**
 * Controller used for application wide sellable items
 */
class ProductController extends Controller
{

    /**
     * @Route("/{_locale}/products", name="_products")
     */
    public function indexAction()
    {

        
        /** @var TablePrimaryMaterial $primaryMaterialItem */
        return $this->render('client/products.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
            'aCategories' => $this->get('category_service')->findAllByLang(),
            'oCart' => $this->get('cart_service')->getCart()
        ]);
    }

    /**
     * @Route("/{_locale}/{id}/{name}", name="_allCategoryItems")
     */
    public function getAllCategoryItems()
    {
        $configuredTableService = $this->get('configured_table_service');
        $categoryId = $this->get('request')->get('id');
        $primaryMaterial = $configuredTableService->getPrimaryMaterial();
        $aTables = $configuredTableService->getAllTablesByLang($categoryId);


        return $this->render('client/categoryItems.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
            'aCategories' => $this->get('category_service')->findAllByLang(),
            'aTables' => $aTables,
            'aArticles' => null,
            'primaryMaterial' => $primaryMaterial,
            'oCart' => $this->get('cart_service')->getCart()
        ]);
    }

    /**
     * @Route("/{_locale}/articles", name="_allArticles")
     */
    public function getAllProducts()
    {
        $articleService = $this->get('article_service');
        $aArticles = $articleService->getAllByLang();

        return $this->render('client/categoryItems.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
            'aCategories' => $this->get('category_service')->findAllByLang(),
            'aArticles' => $aArticles,
            'aTables' => null,
            'oCart' => $this->get('cart_service')->getCart()
        ]);
    }

    /**
     * @Route("/{_locale}/tables/{name}/{code}", name="_specificTable")
     */
    public function getSpecificTable()
    {

        $configuredTableService = $this->get('configured_table_service');
        $code = $this->get('request')->get('code');
        $primaryMaterial = $configuredTableService->getPrimaryMaterial();
        $table = $configuredTableService->findTableByCode($code);
        $height = $configuredTableService->getUniqueHeight();
        $width = $configuredTableService->getUniqueWidth();
        $length = $configuredTableService->getUniqueLength();
        $aTimberQuality = $configuredTableService->getAllTimberQualityByLang();
        $aTimberTempering = $configuredTableService->getAllTimberTemperingByLang();
        $aMaterials = $configuredTableService->getAllTableSpecificMaterials($table);


        return $this->render('client/subContent/table.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
            'aCategories' => $this->get('category_service')->findAllByLang(),
            'oItem' => $table,
            'width' => $width,
            'length' => $length,
            'height' => $height,
            'aMaterials' => $aMaterials,
            'aTimberQuality' => $aTimberQuality,
            'aTimberTempering' => $aTimberTempering,
            'primaryMaterial' => $primaryMaterial,
            'oCart' => $this->get('cart_service')->getCart()
        ]);
    }

    /**
     * @Route("/{_locale}/{name}-{code}", name="_specificArticle")
     */
    public function getSpecificArticle()
    {
        $service = $this->get('article_service');
        $code = $this->get('request')->get('code');

        $article = $service->findByCode($code);
        return $this->render('client/subContent/article.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
            'aCategories' => $this->get('category_service')->findAllByLang(),
            'oItem' => $article,
            'oCart' => $this->get('cart_service')->getCart()
        ]);
    }

    /**
     * @Route("/{_locale}/article_price_ajax/", name="_calculateArticlePrice_ajax", options={"expose"=true})
     */
    public function calculateArticlePriceAjax()
    {
        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            return $finalPrice = $this->get('article_service')->calculateArticlePrice();
        }
        return new JsonResponse('Invalid request!, 400');
    }

    /**
     * @Route("/{_locale}/ajax/", name="_calculatePrice_ajax", options={"expose"=true})
     */
    public function calculatePriceAjax()
    {
        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            return $finalPrice = $this->get('configured_table_service')->calculateTablePrice();
        }
        return new JsonResponse('Invalid request!, 400');
    }



    /** @Route("/{_locale}/ajaxI", name="_getPrimaryImageByMaterial", options={"expose"=true}) */
    public function getPrImageByMat()
    {
        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            return $this->get('configured_table_service')->getPrimaryImageByMaterial();
        }
        return new JsonResponse('Invalid request!, 400');
    }
}
