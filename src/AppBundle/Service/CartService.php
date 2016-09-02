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
use AppBundle\Entity\CartItemConfig;
use AppBundle\Utils\Utils;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private $configuredTableService;
    private $cartItemFactory;
    private $request;

    public function __construct(ConfiguredTableService $cft, CartVoFactory $cartVoFactory, RequestStack $requestStack)
    {
        $this->configuredTableService = $cft;
        $this->cartItemFactory = $cartVoFactory;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function calculatePrice()
    {
        return $this->configuredTableService->calculatePrice();
    }

    public function addItemToCartAjax($finalPrice)
    {
        $cartVo = $this->cartItemFactory->create();
        $tableItem = $this->configuredTableService->getTableObject();
        $tableConfigs = $this->configuredTableService->getConfiguredTablePriceVO();

        $specsArray = array();
        if ($cartVo->getDimensionsString() !== "") $specsArray[] = $cartVo->getDimensionsString();
        if ($cartVo->getDrawersString() !== "") $specsArray[] = $cartVo->getDrawersString();
        if ($cartVo->getExtString() !== "") $specsArray[] = $cartVo->getExtString();
        if ($cartVo->getMaterialString() !== "") $specsArray[] = $cartVo->getMaterialString();
        if ($cartVo->getProfileString() !== "") $specsArray[] = $cartVo->getProfileString();
        if ($cartVo->getQualityString() !== "") $specsArray[] = $cartVo->getQualityString();
        if ($cartVo->getTemperingString() !== "") $specsArray[] = $cartVo->getTemperingString();
        if ($cartVo->getDistToSides() !=="") $specsArray[] = $cartVo->getDistToSides();

        $cartItem = new CartItem();
        $cartItem->setUniqueItemCode(Utils::generateUniqueCartCode());
        /** @noinspection PhpUndefinedMethodInspection */
        $cartItem->setItemName($tableItem->getName());
        $cartItem->setItemCode($tableItem->getCode());
        $cartItem->setItemImg($tableItem->getPrimaryImage($tableConfigs->getMaterial()));
        $cartItem->setItemPrice($finalPrice);
        $cartItem->setItemSpecs($specsArray);
        $cartItem->setItemQuantity(1);
        foreach ($specsArray as $spec){
            $configSpec = new CartItemConfig($spec);
            if ($spec!==null)
            $cartItem->addConfig($configSpec);
        }

        $cart = $this->getCart();
        if (is_null($cart)) {
            $cart = new Cart();
        }
        $cartItem->setCart($cart);
        $cart->addItem($cartItem);
        if ($cart->getCartCurrency()===null) {
            $lang = $this->request->getLocale();
            if ($lang=='de' || $lang='fr'){
                $cart->setCartCurrency('€');
            }
            else if ($lang=='en'){
                $cart->setCartCurrency('£');
            }
            else if ($lang=='ro'){
                $cart->setCartCurrency('RON');
            }
        }
        return $cart;

    }

    /** @return Cart */
    public function getCart()
    {
        $oCart = $this->request->getSession()->get('cart');
        if ($oCart !== null
         && !empty($oCart->getCartItems()->getValues())){
            return $oCart;
        }
        return null;

    }

    public function clearCart(){
        $this->request->getSession()->remove('cart');
    }

    public function removeItemFromCartAjax()
    {
        $cart = $this->getCart();
        if (is_null($cart))
            return null;
        $code = $this->request->get('itemCode');
        foreach ($cart->getCartItems() as $cartItem) {
            if ($cartItem->getUniqueItemCode() == $code) {
                $cart->removeItem($cartItem);
            }
        }
        return $cart;
    }

      

    public function modifyCartItemQuantity()
    {

        $cart = $this->getCart();
        if (is_null($cart))
            return null;
        $code = $this->request->get('itemCode');
        $newQuantity=$this->request->get('itemNewQuantity');
        if (intval($newQuantity)<1){
            return false;
        }
        foreach ($cart->getCartItems() as $cartItem) {
            if ($cartItem->getUniqueItemCode() == $code) {
                $cartItem->setItemQuantity(intval($newQuantity));
            }
        }
        $cart->updateCart();
        return $cart;
    }
    

}