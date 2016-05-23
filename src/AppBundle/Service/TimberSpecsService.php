<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/23/2016
 * Time: 1:58 PM
 */

namespace AppBundle\Service;


use AppBundle\Repository\TableTimberQualityDAO;
use AppBundle\Repository\TimberTemperingDAO;

class TimberSpecsService
{
    private $timberQualityDAO;
    private $timberTemperingDAO;

    public function __construct(TableTimberQualityDAO $qDAO, TimberTemperingDAO $tDAO)
    {
        $this->timberQualityDAO=$qDAO;
        $this->timberTemperingDAO=$tDAO;
    }

    public function getAllTimberQualityByLang($lang){
        return $this->timberQualityDAO->findAllByLang($lang);
    }

    public function getAllTimberTemperingByLang($lang){
        return $this->timberTemperingDAO->findAllByLang($lang);
    }
}