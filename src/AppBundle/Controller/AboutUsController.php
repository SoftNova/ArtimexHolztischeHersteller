<?php
/**
 * Created by PhpStorm.
 * User: Boogdan
 * Date: 24.04.2016
 * Time: 16:11
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AboutUsController extends Controller
{
    /**
     * @Route("/{_locale}/aboutus", name="_aboutus")
     */
    public function indexAction()
    {

        $oCart = $this->get('request')->getSession()->get('cart');
        // replace this example code with whatever you need
        return $this->render('client/aboutus.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'oCart'=>$oCart
        ]);
    }
}