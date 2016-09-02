<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 9/2/2016
 * Time: 3:10 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CartItemConfig
 * @package AppBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="cart_item_config")
 */
class CartItemConfig
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @ORM\Column(type="string", nullable=false, name="item_config")
     */
    protected $specification;

    public function __construct($spec)
    {
        $this->specification=$spec;
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
    public function getSpecification()
    {
        return $this->specification;
    }

    /**
     * @param mixed $specification
     */
    public function setSpecification($specification)
    {
        $this->specification = $specification;
    }




}