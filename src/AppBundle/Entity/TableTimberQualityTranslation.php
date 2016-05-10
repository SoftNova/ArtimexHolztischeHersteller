<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/9/2016
 * Time: 4:29 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehavior;

/**
 * Class TableTimberQualityTranslation
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 */
class TableTimberQualityTranslation
{
    use ORMBehavior\Translatable\Translation;
    /**
     * @var
     * @ORM\Column(type="string", name="name", nullable=false, length=255)
     */
    protected $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */

}