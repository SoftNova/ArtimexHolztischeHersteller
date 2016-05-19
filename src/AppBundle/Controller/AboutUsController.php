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
use Symfony\Component\HttpFoundation\Request;

class AboutUsController extends Controller
{
    /**
     * @Route("/{_locale}/aboutus", name="aboutus")
     */
    public function indexAction(Request $request)
    {

        // replace this example code with whatever you need
        return $this->render('client/aboutus.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }
}