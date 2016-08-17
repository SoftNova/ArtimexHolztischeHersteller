<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 8/17/2016
 * Time: 3:50 PM
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class PaymentMethodDAO extends EntityRepository
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