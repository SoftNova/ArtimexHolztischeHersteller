<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/4/2016
 * Time: 1:47 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductTable
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductTableDAO")
 * @ORM\Table()
 */
class ProductTable
{
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
    public function getIsVisible()
    {
        return $this->isVisible;
    }

    /**
     * @param mixed $isVisible
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;
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
    public function getStockCost()
    {
        return $this->stockCost;
    }

    /**
     * @param mixed $stockCost
     */
    public function setStockCost($stockCost)
    {
        $this->stockCost = $stockCost;
    }
    /**
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVisible;
    /**
     * @ORM\Column(type="string")
     */
    private $fromDate;
    /**
     * @ORM\Column(type="string")
     */
    private $toDate;
    /**
     * @ORM\Column(type="string")
     */
    private $stockCost;

    //promotions
    //stuff for multilang


}