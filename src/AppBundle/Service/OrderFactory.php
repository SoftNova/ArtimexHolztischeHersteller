<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/15/2016
 * Time: 3:57 PM
 */

namespace AppBundle\Service;


use AppBundle\ValueObject\OrderVO;
use Symfony\Component\HttpFoundation\RequestStack;

class OrderFactory
{
    protected $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function create()
    {
        return OrderVO::createFromRequest($this->request);
    }
}