<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/9/2016
 * Time: 3:33 PM
 */

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class Cart
{

    protected $cartItems;

    protected $totalPrice;

    protected $totalQuantity;

    protected $shippingIn;

    public function __construct()
    {
        $this->cartItems=new ArrayCollection();
    }

    /**
     * @return ArrayCollection(CartItem)
     */
    public function getCartItems()
    {
        return $this->cartItems;
    }

    /**
     * @param ArrayCollection $cartItems
     */
    public function setCartItems($cartItems)
    {
        $this->cartItems = $cartItems;
    }

    /**
     * @return mixed
     */
    public function getTotalPrice()
    {
        return $this->totalPrice. ',00';
    }

    /**
     * @param mixed $totalPrice
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @return mixed
     */
    public function getShippingIn()
    {
        return $this->shippingIn;
    }

    /**
     * @param mixed $shippingIn
     */
    public function setShippingIn($shippingIn)
    {
        $this->shippingIn = $shippingIn;
    }

    public function addItem(CartItem $item){
        foreach ($this->cartItems as $cartItem){
            if ($cartItem->equals($item)){
                $cartItem->setItemQuantity($cartItem->getItemQuantity()+1);
                $this->updateCart();
                return;
            }
        }
        $this->cartItems->add($item);
        $this->updateCart();
    }
    public function removeItem(CartItem $cartItem)
    {
        $this->cartItems->removeElement($cartItem);
        $this->updateCart();
    }
    public function updateCart(){
        $cartTotalQuantity=0;
        $cartTotalPrice=0;

        /** @var CartItem $item */
        foreach ($this->cartItems->getValues() as $item){
            $rawStringIntegerPriceArray=array_reverse(explode(',',($item->getItemPrice())));
            $numeralPrice = (int)preg_replace('#[^0-9]+#', '', end($rawStringIntegerPriceArray));
            $cartTotalPrice = ($numeralPrice*$item->getItemQuantity())+ $cartTotalPrice;
            $cartTotalQuantity = $item->getItemQuantity() + $cartTotalQuantity;
        }
        $this->totalPrice=$cartTotalPrice;
        $this->totalQuantity=$cartTotalQuantity;
    }
    /**
     * @return mixed
     */
    public function getTotalQuantity()
    {
        return $this->totalQuantity;
    }

    /**
     * @param mixed $totalQuantity
     */
    public function setTotalQuantity($totalQuantity)
    {
        $this->totalQuantity = $totalQuantity;
    }

    

}