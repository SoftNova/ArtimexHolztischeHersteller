<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/23/2016
 * Time: 11:01 AM
 */

namespace AppBundle\Service;


use AppBundle\Entity\TableLength;
use AppBundle\Repository\TableHeightDAO;
use AppBundle\Repository\TableLengthDAO;
use AppBundle\Repository\TableWidthDAO;

class SurfaceService
{
    private $heightDAO;
    private $lengthDAO;
    private $widthDAO;

    public function __construct(TableLengthDAO $ldao, TableWidthDAO $wdao, TableHeightDAO $hdao)
    {
        $this->heightDAO=$hdao;
        $this->lengthDAO=$ldao;
        $this->widthDAO=$wdao;
    }


    public function getLength(){
        return (!is_null($this->lengthDAO->findAll()) ? $this->lengthDAO->findAll()[0] : null);

    }

    public function getWidth(){
        return (!is_null($this->widthDAO->findAll()) ? $this->widthDAO->findAll()[0] : null);
    }

    public function getHeight()
    {
        return (!is_null($this->heightDAO->findAll()) ? $this->heightDAO->findAll()[0] : null);
    }
}