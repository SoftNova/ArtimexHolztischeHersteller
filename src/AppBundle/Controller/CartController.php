<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/8/2016
 * Time: 2:05 PM
 */

namespace AppBundle\Controller;


use AppBundle\ValueObject\OrderVO;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


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

    /** @Route("/{_locale}/cart/checkout", name="_cart_checkout") */
    public function cartCheckoutAction(){
        $cart = $this->get('cart_service')->getCart();
        // replace this example code with whatever you need
        return $this->render('client/checkout.html.twig', [
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
            $content = $this->forward('AppBundle:Cart:cartAjax')->getContent();
            return new JsonResponse(
                [
                    'success' => array(
                        'price'=>$cart->getTotalPrice(),
                        'quantity'=>$cart->getTotalQuantity(),
                        'content'=>$content
                    )
                ]
            );
            
        }
    }

    /** @Route ("/{_locale}/modifyCartItemQuantityAjax", name="_modify_cart_item_quantity", options={"expose"=true}) */
    public function modifyQuantity(){
        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            $cart = $this->get('cart_service')->modifyCartItemQuantity();
            if ($cart===false){
                $this->get('session')->remove('cart');
                return new JsonResponse(
                    [
                        'failure' => array(
                        )
                    ]
                );
            }
            $this->get('session')->set('cart', $cart);
            $content = $this->forward('AppBundle:Cart:cartAjax')->getContent();
            return new JsonResponse(
                [
                    'success' => array(
                        'price' => $cart->getTotalPrice(),
                        'quantity' => $cart->getTotalQuantity(),
                        'content' => $content
                    )
                ]
            );
        }
    }


    public function cartAjaxAction(){
        $cart = $this->get('cart_service')->getCart();
        return $this->render(':client:cartItems.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'oCart' => $cart
        ]);
    }

    /**
     * @Route("/{_locale}/addTableToCart/", name="_add_table_to_cart", options={"expose"=true})
     */
    public function addTableToCart()
    {
        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            $finalPrice =json_decode($this->get('configured_table_service')->calculatePrice()->getContent(),true)['success'];
            $cart=$this->get('cart_service')->addItemToCartAjax($finalPrice);
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
        return new JsonResponse('Invalid request!, 400');
    }

    /**
     * @Route("/{_locale}/cart/summary", name="_cart_checkout_submit")
     */
    public function checkoutFormAction(){
        $orderVO = new OrderVO();

        $form = $this->createFormBuilder($orderVO)
            ->add('fname', TextType::class)
            ->add('lname', TextType::class)
            ->add('phone', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Task'))
            ->getForm();

        return null;
    }
}