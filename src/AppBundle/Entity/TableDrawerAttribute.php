<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/26/2016
 * Time: 2:57 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TableDrawerAttribute
 * @package AppBundle\Entity
 * 
 * @ORM\Entity()
 * @ORM\Table(name="table_drawer_attribute")
 */
class TableDrawerAttribute
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id")
     */
    private $id;

    /**
     * @var
     * @ORM\Column(type="decimal", name="base_price", nullable="false")
     */
    private $basePrice;

    /**
     * @var
     * @ORM\Column(type="integer", name="max_number_of_drawers", nullable="false")
     */
    private $maxNumberOfDrawers;

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
    public function getMaxNumberOfDrawers()
    {
        return $this->maxNumberOfDrawers;
    }

    /**
     * @param mixed $maxNumberOfDrawers
     */
    public function setMaxNumberOfDrawers($maxNumberOfDrawers)
    {
        $this->maxNumberOfDrawers = $maxNumberOfDrawers;
    }
    
    
}