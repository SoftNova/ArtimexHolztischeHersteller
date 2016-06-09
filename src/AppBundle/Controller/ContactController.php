<?php
/**
 * Created by PhpStorm.
 * User: Boogdan
 * Date: 23.05.2016
 * Time: 22:34
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/{_locale}/contact", name="_contact")
     */
    public function indexAction(Request $request)
    {

        $oCart = $this->get('request')->getSession()->get('cart');
        // replace this example code with whatever you need
        return $this->render('client/contact.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'oCart'=>$oCart
        ]);
    }
}