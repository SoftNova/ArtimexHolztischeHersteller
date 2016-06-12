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

        $cartItem = new CartItem();
        $cartItem->setUniqueItemCode(Utils::generateUniqueCartCode());
        /** @noinspection PhpUndefinedMethodInspection */
        $cartItem->setItemName($tableItem->getName());
        $cartItem->setItemCode($tableItem->getCode());
        $cartItem->setItemImg($tableItem->getPrimaryImage($tableConfigs->getMaterial()));
        $cartItem->setItemPrice($finalPrice);
        $cartItem->setItemSpecs($specsArray);
        $cartItem->setItemQuantity(1);

        $cart = $this->getCart();
        if (is_null($cart)) {
            $cart = new Cart();
        }
        $cart->addItem($cartItem);

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

}