<?php

namespace AppBundle\Controller;

use Lunetics\LocaleBundle\Event\FilterLocaleSwitchEvent;
use Lunetics\LocaleBundle\LocaleBundleEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * @Route("/{_locale}/", name="_homepage", options={"expose"=true})
     */
    public function indexAction()
    {

        $oCart = $this->get('cart_service')->getCart();
        return $this->render('client/homepage.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'oCart'=>$oCart
        ]);
    }

    /** @Route("/") */
    public function root(){
        $langIso2=$this->get('request')->getLocale();
        $allLocales=$this->getParameter('locales');
        $langIso2=strlen($langIso2)>2 ? substr($langIso2,0,2) : $langIso2;
        //ToDo fix this
        $langIso2='de';
        if (in_array($langIso2, $allLocales)){
            return $this->redirect($langIso2, 301);
        }
    }
}
