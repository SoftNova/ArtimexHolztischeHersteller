<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 6/12/2016
 * Time: 5:13 PM
 */

namespace AppBundle\Service;


use AppBundle\ValueObject\ConfiguredTablePriceVO;
use Symfony\Component\HttpFoundation\RequestStack;

class ConfiguredPriceHandlerFactory
{
    protected $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function create()
    {
        return ConfiguredTablePriceVO::createFromRequest($this->request);
    }
}