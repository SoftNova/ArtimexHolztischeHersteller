<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 8/17/2016
 * Time: 3:52 PM
 */

namespace AppBundle\Service;


use AppBundle\Repository\PaymentMethodDAO;

class PaymentMethodService
{
    private $paymentMethodDAO;

    public function __construct(PaymentMethodDAO $paymentMethodDAO)
    {
        $this->paymentMethodDAO=$paymentMethodDAO;
    }

    public function getMethodsForLang($lang){
        return $this->paymentMethodDAO->findAllByLang($lang);
    }
}