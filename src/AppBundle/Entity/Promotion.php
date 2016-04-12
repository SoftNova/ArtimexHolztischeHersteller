<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/12/2016
 * Time: 12:28 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Promotion
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="PROMOTIONS")
 */
class Promotion
{

    /**
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="ID")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="FROM_DATE")
     */
    private $fromDate;
    /**
     * @ORM\Column(type="datetime", nullable=true, name="TO_DATE")
     */
    private $toDate;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ProductTable", mappedBy="promotions")
     */
    private $tables;

    /**
     * @ORM\Column(type="integer", name="VARIANCE", nullable=false)
     */
    private $variance;

    public function __construct()
    {
        $this->tables = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * @param mixed $fromDate
     */
    public function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;
    }

    /**
     * @return mixed
     */
    public function getToDate()
    {
        return $this->toDate;
    }

    /**
     * @param mixed $toDate
     */
    public function setToDate($toDate)
    {
        $this->toDate = $toDate;
    }

    /**
     * @return mixed
     */
    public function getTables()
    {
        return $this->tables;
    }

    /**
     * @param mixed $tables
     */
    public function setTables($tables)
    {
        $this->tables = $tables;
    }

    /**
     * @return mixed
     */
    public function getVariance()
    {
        return $this->variance;
    }

    /**
     * @param mixed $variance
     */
    public function setVariance($variance)
    {
        $this->variance = $variance;
    }
    

}