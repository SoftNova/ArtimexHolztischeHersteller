<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/23/2016
 * Time: 2:00 PM
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class TimberTemperingDAO extends EntityRepository
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