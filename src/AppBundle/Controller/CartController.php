<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/8/2016
 * Time: 2:05 PM
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class CartController extends Controller
{
    /** @Route("/{_locale}/cart", name="_cart") */
    public function indexAction(){
        $cart = $this->get('cart_service')->getCart();
        // replace this example code with whatever you need
        return $this->render('client/cart.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'oCart' => $cart
        ]);
    }

    /** @Route ("/{_locale}/removeCartItemAjax", name="_remove_item_from_cart", options={"expose"=true}) */
    public function removeItemAjax()
    {
        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            $cart = $this->get('cart_service')->removeItemFromCartAjax();
            $this->get('session')->set('cart', $cart);
            return new JsonResponse(
                [
                    'success' => array(
                        'price'=>$cart->getTotalPrice(),
                        'quantity'=>$cart->getTotalQuantity()
                    )
                ]
            );
            
        }
    }
}