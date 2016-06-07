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
    public function findAllByLang($lang, $categoryId){
        $qb = $this->_em->createQueryBuilder();
        $qb->select('t')
            ->from($this->_entityName, 't')
            ->join('t.categories','tc')
            ->join('t.translations', 'tt' )
            ->where('tt.locale= :lang')
            ->andWhere('tc.id= :categoryId')
            ->andWhere('tt.visibility= :visibility')
            ->andWhere('t.showInCatalog= :sic')
            ->addSelect('tt')
            ->setParameter('categoryId', $categoryId)
            ->setParameter('lang', $lang)
            ->setParameter('visibility', 1)
            ->setParameter('sic', 1)
        ;
        return $qb->getQuery()->getResult();
    }

    public function findByCode($code, $lang){
        $qb = $this->createQueryBuilder('t');
        $qb->join('t.translations', 'tt' )
            ->where('tt.locale= :lang')
            ->andWhere('t.code= :code')
            ->addSelect('tt')
            ->setParameter('code', $code)
            ->setParameter('lang', $lang);
        return $qb->getQuery()->getOneOrNullResult();
    }
    public function findPrimaryImageByMaterial($materialID,$code){
        $qb = $this->createQueryBuilder('t');
        $qb->join('t.images', 'ti')
            ->where('t.code= :code')
            ->andWhere('ti.materialItem= :materialID')
            ->andWhere('ti.role= :primary')
            ->addSelect('ti')
            ->setParameter('materialID',$materialID)
            ->setParameter('primary', 1)
            ->setParameter('code',$code);
        return $qb->getQuery()->getOneOrNullResult();
    }

}