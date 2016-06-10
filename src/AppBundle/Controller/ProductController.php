<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Entity\CartItem;
use AppBundle\Entity\Table;
use AppBundle\Entity\TableImage;
use AppBundle\Entity\TableMaterial;
use AppBundle\Entity\TablePrimaryMaterial;
use AppBundle\Utils\Utils;
use AppBundle\Validator\SpecsValidator;
use AppBundle\Validator\SupportValidator;
use AppBundle\Validator\SurfaceValidator;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;

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
            'aCategories' => $this->getCategories(),
            'oCart' => $this->getCart()
        ]);
    }

    /**
     * @Route("/{_locale}/{id}/{name}", name="_allCategoryItems")
     */
    public function getAllCategoryItems()
    {
        $tableService = $this->get('table_service');
        $lang = $this->get('request')->getLocale();
        $categoryId = $this->get('request')->get('id');
        $surfaceService = $this->get('surface_service');
        $primaryMaterialItem = $surfaceService->getPrimaryMaterial();
        $primaryMaterial = !is_null($primaryMaterialItem) ? $primaryMaterialItem->getPrimaryMaterial()->getId() : null;
        $aTables = $tableService->getAllByLang($lang, $categoryId);


        return $this->render('client/categoryItems.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
            'aCategories' => $this->getCategories(),
            'aTables' => $aTables,
            'aArticles' => null,
            'primaryMaterial' => $primaryMaterial,
            'oCart' => $this->getCart()
        ]);
    }

    /**
     * @Route("/{_locale}/articles", name="_allArticles")
     */
    public function getAllProducts()
    {
        $articleService = $this->get('article_service');
        $lang = $this->get('request')->getLocale();
        $aArticles = $articleService->getAllByLang($lang);
        return $this->render('client/categoryItems.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
            'aCategories' => $this->getCategories(),
            'aArticles' => $aArticles,
            'aTables' => null,
            'oCart' => $this->getCart()
        ]);
    }

    /**
     * @Route("/{_locale}/tables/{name}/{code}", name="_specificTable")
     */
    public function getSpecificTable()
    {

        $service = $this->get('table_service');
        $surfaceService = $this->get('surface_service');
        $code = $this->get('request')->get('code');
        $timberService = $this->get('timber_service');
        $lang = $this->get('request')->getLocale();
        $allUntranslatedMaterials = $surfaceService->getMaterialsForLang($lang);


        $primaryMaterial = !is_null($surfaceService->getPrimaryMaterial()) ? $surfaceService->getPrimaryMaterial()->getPrimaryMaterial()->getId() : null;
        $table = $service->findByCode($code, $lang);

        $height = $surfaceService->getHeight();
        $width = $surfaceService->getWidth();
        $length = $surfaceService->getLength();
        $aTimberQuality = $timberService->getAllTimberQualityByLang($lang);
        $aTimberTempering = $timberService->getAllTimberTemperingByLang($lang);

        $tableSpecificTranslatedMaterials = $this->getMaterials($table, $allUntranslatedMaterials);
        $altPath = Utils::DEFAULT_IMAGE;
        /** @var TableMaterial $material */
        foreach ($tableSpecificTranslatedMaterials as $material) {
            $image = $this->get('liip_imagine.controller')
                ->filterAction(new Request(), (is_null($material->getImage()->getWebPath()) ? $altPath : $material->getImage()->getWebPath()), 'materialPopup')->getTargetUrl();
            $material->getImage()->setCachePath($image);
        }

        return $this->render('client/subContent/table.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
            'aCategories' => $this->getCategories(),
            'oItem' => $table,
            'width' => $width,
            'length' => $length,
            'height' => $height,
            'aMaterials' => $tableSpecificTranslatedMaterials,
            'aTimberQuality' => $aTimberQuality,
            'aTimberTempering' => $aTimberTempering,
            'primaryMaterial' => $primaryMaterial,
            'oCart' => $this->getCart()
        ]);
    }

    /**
     * @Route("/{_locale}/{name}-{code}", name="_specificArticle")
     */
    public function getSpecificArticle()
    {
        $service = $this->get('article_service');
        $code = $this->get('request')->get('code');
        $lang = $this->get('request')->getLocale();

        $article = $service->findByCode($code, $lang);
        return $this->render('client/subContent/article.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
            'aCategories' => $this->getCategories(),
            'oItem' => $article,
            'oCart' => $this->getCart()
        ]);
    }

    /**
     * @Route("/{_locale}/ajax/", name="_calculatePrice_ajax", options={"expose"=true})
     */
    public function calculatePriceAjax()
    {
        $request = $this->get('request');
        $lang = $this->get('request')->getLocale();
        $tableService = $this->get('table_service');

        if ($request->isXmlHttpRequest()) {
            $length = $request->get('length');
            $width = $request->get('width');
            $height = $request->get('height');
            $profile = $request->get('profile');
            $extensions = $request->get('extensions');
            $extLength = $request->get('extLength');
            $drawers = $request->get('drawers');
            $drawerLength = $request->get('drawerLength');
            $material = $request->get('material');
            $quality = $request->get('quality');
            $tempering = $request->get('tempering');
            $code = $request->get('code');
            $tableItem = $tableService->findByCode($code, $lang);

            $errors = array();
            $errors = array_merge($errors, $this->validateSurface($material, $length, $drawerLength, $extLength, $width)->toArray());
            $errors = array_merge($errors, $this->validateSupport($height, $profile, $tableItem->getProfiles())->toArray());
            $errors = array_merge($errors, $this->validateSpecs($quality, $tempering)->toArray());

            if (!empty($errors)) {
                return new \Symfony\Component\HttpFoundation\Response(json_encode(array('error' => end($errors))));
            }

            $finalPrice = $this->computePrice($height,$profile,$tableItem,$extensions,$extLength,$width,$material,$drawers,$drawerLength,$length,$quality,$tempering);
            if ($finalPrice == false) {
                $custom = $this->get('translator')->trans('app.custom.order');
                return new \Symfony\Component\HttpFoundation\Response(json_encode(array('failure' => $custom)));
            }


            return new \Symfony\Component\HttpFoundation\Response(json_encode(array('success' => $finalPrice)));
        }
        return new \Symfony\Component\HttpFoundation\Response('Invalid request!, 400');
    }

    /**
     * @Route("/{_locale}/addTableToCart/", name="_add_table_to_cart", options={"expose"=true})
     */
    public function addTableToCart()
    {
        $request = $this->get('request');
        $lang = $this->get('request')->getLocale();
        $tableService = $this->get('table_service');

        if ($request->isXmlHttpRequest()) {
            $length = $request->get('length');
            $width = $request->get('width');
            $height = $request->get('height');
            $profile = $request->get('profile');
            $extensions = $request->get('extensions');
            $extLength = $request->get('extLength');
            $drawers = $request->get('drawers');
            $drawerLength = $request->get('drawerLength');
            $material = $request->get('material');
            $quality = $request->get('quality');
            $tempering = $request->get('tempering');
            $code = $request->get('code');
            $tableItem = $tableService->findByCode($code, $lang);

            $dimensionsString = $request->get('dimensionsString');
            $profileString = $request->get('profileString');
            $drawersString = $request->get('drawersString');
            $extString = $request->get('extString');
            $materialString = $request->get('materialString');
            $qualityString = $request->get('qualityString');
            $temperingString = $request->get('temperingString');

            $specsArray = array($dimensionsString, $profileString, $drawersString, $extString, $materialString, $qualityString, $temperingString);
            $finalPrice = $this->computePrice($height, $profile, $tableItem, $extensions, $extLength, $width, $material, $drawers, $drawerLength, $length, $quality, $tempering);

            /** @var Table $tableItem*/
            $cartItem = new CartItem();
            $cartItem->setItemName($tableItem->getName());
            $cartItem->setItemCode($tableItem->getCode());
            $cartItem->setItemImg($tableItem->getPrimaryImage($material));
            $cartItem->setItemPrice($finalPrice);
            $cartItem->setItemSpecs($specsArray);
            $cartItem->setItemQuantity(1);
            
            $cart = $this->getCart();
            if (is_null($cart)){
                $cart=new Cart();
            }
            $cart->addItem($cartItem);
            
            return new \Symfony\Component\HttpFoundation\Response(json_encode(array('success' => array('price'=>$cart->getTotalPrice(), 'quantity'=>$cart->getTotalQuantity()))));
        }
    }

    private function computePrice($height, $profile, $tableItem, $extensions, $extLength, $width, $material, $drawers, $drawerLength, $length, $quality, $tempering )
    {
        $tableSupportService = $this->get('table_support_service');
        $timberSpecsService = $this->get('timber_service');
        $surfaceService = $this->get('surface_service');

        $supportPrice = $tableSupportService->calculateSupportPrice($height, $profile, $tableItem);
        $extensionPrice = (!is_null($extensions)) ? $surfaceService->calculateExtensionSurface($extLength, $width, $material, $extensions) : 0;
        $drawerPrice = (!is_null($drawers)) ? $surfaceService->calculateDrawerSurface($drawerLength, $width, $tableItem, $drawers) : 0;

        $surfacePrice = $surfaceService->calculateSurface($length, $width, $material);
        if ($surfacePrice == false) {
            return false;
        }
        $tablePrice = $surfacePrice + $supportPrice + $extensionPrice + $drawerPrice;
        $tablePrice = $timberSpecsService->applyQualityVariance($tablePrice, $quality);
        $tablePrice = !is_null($tempering) ? $timberSpecsService->applyTemperingVariance($tablePrice, $tempering) : $tablePrice;

        /* final by state variance price */
        $tablePrice = round($tablePrice + ($tableItem->getByStateVariance() / 100 * $tablePrice));

        $currency = $this->get('translator')->trans('app.currency');
        $stringPrice = $currency . strval($tablePrice) . ",00";

        return $stringPrice;
    }

    /** @Route("/{_locale}/ajaxI", name="_getPrimaryImageByMaterial", options={"expose"=true}) */
    public function getPrImageByMat()
    {
        $request = $this->get('request');
        $tableService = $this->get('table_service');
        if ($request->isXmlHttpRequest()) {
            $code = $request->get('itemCode');
            $material = $request->get('material');
            $tableItem = $tableService->findPrimaryImageByMaterial($material, $code);
            $altPath = Utils::DEFAULT_IMAGE;
            $image = $this->get('liip_imagine.controller')
                ->filterAction(new Request(), (is_null($tableItem) ? $altPath : $tableItem->getFirstImage()->getWebPath()), 'productDisplay')->getTargetUrl();
            return new \Symfony\Component\HttpFoundation\Response(json_encode(($image)));
        }
    }

    private function getCategories()
    {
        $lang = $this->get('request')->getLocale();
        $categoryService = $this->get('category_service');
        $aCategories = $categoryService->findAllByLang($lang);
        return $aCategories;
    }

    private function getMaterials($tableItem, $translatedMaterials)
    {
        $tableUntranslatedMaterials = new ArrayCollection();
        foreach ($tableItem->getImages() as $image) {
            /** @var TableImage $image */
            if ($image->getRole() && !$tableUntranslatedMaterials->contains($image->getMaterialItem())) {
                $tableUntranslatedMaterials->add($image->getMaterialItem());
            }
        }
        $result = new ArrayCollection();
        foreach ($translatedMaterials as $translatedMaterial) {
            if ($tableUntranslatedMaterials->contains($translatedMaterial)) {
                $result->add($translatedMaterial);
            }
        }
        return $result;
    }

    private function getCart()
    {
        return $oCart = $this->get('request')->getSession()->get('cart');
    }

    private function validateSurface($material, $tableLength, $drawerLength, $extLength, $tableWidth)
    {
        $errors = new ArrayCollection();
        $lengthObject = $this->get('surface_service')->getLength();
        $widthObject = $this->get('surface_service')->getWidth();
        $material = $this->get('surface_service')->getMaterialById($material);
        $result = SurfaceValidator::validateSurface($material, $tableLength, $drawerLength, $extLength, $tableWidth, $lengthObject, $widthObject);
        if (!is_null($result)) $errors->add($result);
        return $errors;
    }

    private function validateSupport($height, $profileId, $profileObjectsArray)
    {
        $errors = new ArrayCollection();
        $heightObject = $this->get('surface_service')->getHeight();
        $result = SupportValidator::validateSupport($height, $profileId, $heightObject, $profileObjectsArray);
        if (!is_null($result)) $errors->add($result);
        return $errors;

    }

    private function validateSpecs($qualityId, $temperingId)
    {
        $errors = new ArrayCollection();
        $quality = $this->get('timber_service')->getTimberQualityById($qualityId);
        $tempering = $this->get('timber_service')->getTimberTemperingByid($temperingId);
        $result = SpecsValidator::validateSpecs($quality, $tempering);
        if (!is_null($result)) $errors->add($result);
        return $errors;
    }


}
