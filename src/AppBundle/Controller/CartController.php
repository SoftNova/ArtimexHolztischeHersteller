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


class CartController extends Controller
{
    /** @Route("/{_locale}/cart", name="_cart") */
    public function indexAction(){
        // replace this example code with whatever you need
        return $this->render('client/cart.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }
}