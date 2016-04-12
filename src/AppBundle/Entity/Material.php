<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/12/2016
 * Time: 3:14 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Class Material
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="MATERIALS")
 */
class Material
{
    use ORMBehaviors\Translatable\Translatable;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="ID")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2, name="COST_PER_SQUARE_METER")
     */
    private $costPerSquareMeter;

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
    public function getCostPerSquareMeter()
    {
        return $this->costPerSquareMeter;
    }

    /**
     * @param mixed $costPerSquareMeter
     */
    public function setCostPerSquareMeter($costPerSquareMeter)
    {
        $this->costPerSquareMeter = $costPerSquareMeter;
    }


}