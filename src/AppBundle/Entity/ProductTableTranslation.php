<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/12/2016
 * Time: 12:20 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Class ProductTableTranslation
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table (name="TABLE_i18n")
 */
class ProductTableTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Column (type="string", length=255, name="NAME")
     */
    protected $name;

    /**
     * @ORM\Column (type="string", length=255, name="DESCRIPTION")
     */
    protected $desc;

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

    /**
     * @return mixed
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @param mixed $desc
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;
    }

    
}