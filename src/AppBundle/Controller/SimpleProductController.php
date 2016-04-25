<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SimpleProductController extends Controller
{
    /**
     * @Route("/simple_product", name="simple_product")
     */
    public function indexAction(Request $request)
    {

        // replace this example code with whatever you need
        return $this->render('client/simple_product.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }
}
