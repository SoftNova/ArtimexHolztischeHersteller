<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/9/2016
 * Time: 3:40 PM
 */

namespace AppBundle\Entity;

use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translation;
use Knp\DoctrineBehaviors\Model as ORMBehavior;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TableMaterialTemperingTranslation
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 *
 */

class TableMaterialTemperingTranslation
{
    use Translation;
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

}