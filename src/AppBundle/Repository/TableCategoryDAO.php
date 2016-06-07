<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/3/2016
 * Time: 1:28 PM
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class TableCategoryDAO extends EntityRepository
{
    public function findAllByLang($lang){
        $qb = $this->_em->createQueryBuilder();
        $qb->select('c')
            ->from($this->_entityName, 'c')
            ->join('c.translations', 'ct' )
            ->where('ct.locale= :lang')
            ->andWhere('c.visibility= :visibility')
            ->addSelect('ct')
            ->setParameter('lang', $lang)
            ->setParameter('visibility', 1)
        ;
        return $qb->getQuery()->getResult();
    }

}