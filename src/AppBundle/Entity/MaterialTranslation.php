<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/12/2016
 * Time: 3:21 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Class MaterialTranslation
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 */
class MaterialTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Column (type="string", length=255, name="NAME")
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

}