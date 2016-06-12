<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/10/2016
 * Time: 11:14 AM
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class TableLengthDAO extends EntityRepository
{
    public function getUniqueLengthObject(){
        return (end($this->findAll()));
    }
}