<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 6/12/2016
 * Time: 6:25 PM
 */

namespace AppBundle\Service;


use AppBundle\ValueObject\CartVO;
use Symfony\Component\HttpFoundation\RequestStack;

class CartVoFactory
{
    protected $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function create()
    {
        return CartVO::createFromRequest($this->request);
    }
}