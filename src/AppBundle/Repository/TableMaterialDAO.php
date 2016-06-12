<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/5/2016
 * Time: 1:39 PM
 */

namespace AppBundle\Repository;
use AppBundle\Entity\Table;
use AppBundle\Entity\TableImage;
use AppBundle\Entity\TableMaterial;
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

    /**
     * @param $lang
     * @param $tableId
     * @return TableMaterial
     */
    public function findTableSpecificMaterials($lang, $tableId){
        $qb = $this->_em->createQueryBuilder();
        $qb->select('m')
            ->from (TableImage::class, 'ti')
            ->join($this->_entityName, 'm')
            ->join ('m.translations','mt')
            ->where('mt.locale=:lang')
            ->andWhere('ti.materialItem = m.id')
            ->andWhere('ti.tableItem = :tId')
            ->addSelect('mt')
            ->setParameter('lang',$lang)
            ->setParameter('tId', $tableId);

        return $qb->getQuery()->getResult();
    }
}