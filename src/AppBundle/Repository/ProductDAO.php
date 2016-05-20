<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 3/31/2016
 * Time: 6:57 PM
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ProductDAO extends EntityRepository
{
    public function findAllByLang($lang){
        $qb = $this->createQueryBuilder('p');
        $qb->join('p.translations', 'pt')
            ->where('pt.locale= :lang')
            ->andWhere('pt.visibility= :visibility')
            ->addSelect('pt')
            ->setParameter('visibility', 1)
            ->setParameter('lang', $lang)
        ;
        return $qb->getQuery()->getResult();
    }

}