<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/5/2016
 * Time: 1:39 PM
 */

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;


class TableMaterialDAO extends EntityRepository
{
    public function findAllByLang($lang){
        $qb = $this->_em->createQueryBuilder();
        $qb->select('m')
            ->from($this->_entityName, 'm')
            ->join('m.translations', 'mt' )
            ->where('mt.locale= :lang')
            ->addSelect('mt')
            ->setParameter('lang', $lang)
        ;
        return $qb->getQuery()->getResult();
    }
}