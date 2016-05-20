<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/26/2016
 * Time: 12:40 PM
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;


/**
 * Class TableDAO
 * @package AppBundle\Repository
 *
 *
 */
class TableDAO extends EntityRepository
{
    public function findAllByLang($lang){
        $qb = $this->_em->createQueryBuilder();
        $qb->select('t')
            ->from($this->_entityName, 't')
            ->join('t.translations', 'tt' )
            ->where('tt.locale= :lang')
            ->andWhere('tt.visibility= :visibility')
            ->addSelect('tt')
            ->setParameter('lang', $lang)
            ->setParameter('visibility', 1)
        ;
        return $qb->getQuery()->getResult();
    }
}