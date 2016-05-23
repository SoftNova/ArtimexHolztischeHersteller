<?php
/**
 * Created by PhpStorm.
 * User: Boogdan
 * Date: 23.05.2016
 * Time: 21:41
 */

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PaymentInfoController extends Controller
{
    /**
     * @Route("/{_locale}/payment_info", name="_paymentinfo")
     */
    public function indexAction(Request $request)
    {

        // replace this example code with whatever you need
        return $this->render('client/payment_information.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }
}