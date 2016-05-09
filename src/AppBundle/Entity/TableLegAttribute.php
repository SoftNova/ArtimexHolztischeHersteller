<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/26/2016
 * Time: 3:35 PM
 */

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TableLegAttribute
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="table_leg_attribute")
 */
class TableLegAttribute
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @ORM\Column(name="base_price", type="decimal", nullable=false, precision=9, scale=2)
     */
    protected $basePrice;

    /**
     * @var
     * @ORM\Column(type="decimal", name="variance", nullable=false, precision=9, scale=2)
     */
    protected $variance=1;

    /**
     * @var
     * @ORM\Column(type="string", name="profiles", nullable=true)
     *
     */
    protected $profiles;

    /**
     * @var
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Table", inversedBy="table_leg_attribute")
     * @ORM\JoinColumn(name="table_id", referencedColumnName="id")
     */
    protected $table;

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
    public function getBasePrice()
    {
        return $this->basePrice;
    }

    /**
     * @param mixed $basePrice
     */
    public function setBasePrice($basePrice)
    {
        $this->basePrice = $basePrice;
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

    /**
     * @return mixed
     */
    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * @param mixed $profiles
     */
    public function setProfiles($profiles)
    {
        $this->profiles = $profiles;
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param mixed $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

}