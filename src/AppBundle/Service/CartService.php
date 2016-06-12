<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 6/12/2016
 * Time: 6:16 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Cart;
use AppBundle\Entity\CartItem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private $configuredTableService;
    private $cartItemFactory;
    private $request;
    public function __construct(ConfiguredTableService $cft, CartVoFactory $cartVoFactory, RequestStack $requestStack)
    {
        $this->configuredTableService=$cft;
        $this->cartItemFactory=$cartVoFactory;
        $this->request=$requestStack->getCurrentRequest();
    }
    
    public function calculatePrice(){
        return $this->configuredTableService->calculatePrice();
    }

    public function addItemToCartAjax($finalPrice){
        $cartVo = $this->cartItemFactory->create();
        $tableItem = $this->configuredTableService->getTableObject();
        $tableConfigs = $this->configuredTableService->getConfiguredTablePriceVO();
        $specsArray = array($cartVo->getDimensionsString(),
            $cartVo->getDrawersString(),
            $cartVo->getExtString(),
            $cartVo->getMaterialString(),
            $cartVo->getProfileString(),
            $cartVo->getQualityString(),
            $cartVo->getTemperingString());

        $cartItem = new CartItem();
        /** @noinspection PhpUndefinedMethodInspection */
        $cartItem->setItemName($tableItem->getName());
        $cartItem->setItemCode($tableItem->getCode());
        $cartItem->setItemImg($tableItem->getPrimaryImage($tableConfigs->getMaterial()));
        $cartItem->setItemPrice($finalPrice);
        $cartItem->setItemSpecs($specsArray);
        $cartItem->setItemQuantity(1);

        $cart = $this->getCart();
        if (is_null($cart)){
            $cart=new Cart();
        }
        $cart->addItem($cartItem);

        return $cart;

    }

    public function getCart()
    {
        return $oCart = $this->request->getSession()->get('cart');
    }

}