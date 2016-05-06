<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/6/2016
 * Time: 2:44 PM
 */

namespace AppBundle\Entity;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Doctrine\ORM\Mapping as ORM;
/**
 * Class TableMaterialTranslation
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 */
class TableMaterialTranslation
{
    use ORMBehaviors\Translatable\Translation;

    
    /**
     * @var
     * @ORM\Column(type="string", name="name", nullable=false)
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