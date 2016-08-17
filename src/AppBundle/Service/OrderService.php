<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 8/17/2016
 * Time: 4:36 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Cart;
use AppBundle\Entity\Order;
use Doctrine\ORM\EntityManager;

class OrderService
{
    private $entityManager;

    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    public function save(Order $order, Cart $cart){
        $order->setRegisteredDate(new \DateTime());
        $cart=$this->applyDiscountToCart($order, $cart);
        $cart->setOrder($order);
        $order->setCart($cart);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    private function applyDiscountToCart(Order $order, Cart $cart){
        $current = $cart->getTotalPrice();
        $appliedDisc = floor($current - ($order->getClientPaymentMethod()->getModifier()/100 * $current));
        $cart->setTotalPrice($appliedDisc);
        return $cart;
    }
}