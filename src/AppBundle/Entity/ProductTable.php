<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/4/2016
 * Time: 1:47 PM
 */

namespace AppBundle\Entity;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Class ProductTable
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductTableDAO")
 * @ORM\Table(name="TABLES")
 */
class ProductTable
{
    use ORMBehaviors\Translatable\Translatable;
    /**
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="ID")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", name="IS_VISIBLE")
     */
    private $isVisible;
    /**
     * @ORM\Column(type="datetime", nullable=true, name="FROM_DATE")
     */
    private $fromDate;
    /**
     * @ORM\Column(type="datetime", nullable=true, name="TO_DATE")
     */
    private $toDate;

    /**
     * @var ProductTableDrawer
     * @ORM\OneToOne (targetEntity="AppBundle\Entity\ProductTableDrawer")
     * @ORM\JoinColumn(name="DRAWER_TYPE_ID", referencedColumnName="id")
     *
     */

    private $drawerType;

    /**
     * @var ProductTableLegType
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ProductTableLegType")
     * @ORM\JoinColumn(name="LEG_TYPE_ID", referencedColumnName="id")
     */

    private $legType;

    /**
     * @var Promotion
     * @ORM\ManyToMany (targetEntity="AppBundle\Entity\Promotion", inversedBy="tables")
     * @ORM\JoinTable (name="TABLE_PROMOTIONS")
     */
    private $promotions;

    /**
     * @var Media
     *
     * @ORM\OneToMany (targetEntity="Application\Sonata\MediaBundle\Entity\Media", mappedBy="table")
     * @ORM\JoinColumn (name="IMAGES", referencedColumnName="id")
     *
     */
    private $images;

    /**
     * ProductTable constructor.
     */

    public function __construct()
    {
        $this->promotions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
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
    public function getDrawerType()
    {
        return $this->drawerType;
    }

    /**
     * @param mixed $drawerType
     */
    public function setDrawerType($drawerType)
    {
        $this->drawerType = $drawerType;
    }

    /**
     * @return mixed
     */
    public function getLegType()
    {
        return $this->legType;
    }

    /**
     * @param mixed $legType
     */
    public function setLegType($legType)
    {
        $this->legType = $legType;
    }

    /**
     * @return mixed
     */
    public function getPromotions()
    {
        return $this->promotions;
    }

    /**
     * @param mixed $promotions
     */
    public function setPromotions($promotions)
    {
        $this->promotions = $promotions;
    }


}