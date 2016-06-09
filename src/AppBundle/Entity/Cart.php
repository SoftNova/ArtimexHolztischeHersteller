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

    protected $shippingIn;

    public function __construct()
    {
        $this->cartItems=new ArrayCollection();
    }

    /**
     * @return ArrayCollection
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
        return $this->totalPrice;
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

    
}