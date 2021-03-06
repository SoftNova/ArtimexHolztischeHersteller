<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/3/2016
 * Time: 1:32 PM
 */

namespace AppBundle\Entity;
use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translation;
use Doctrine\ORM\Mapping as ORM;
/**
 * Class TableCategoryTranslation
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 */
class TableCategoryTranslation
{
    use Translation;

    /**
     * @var
     * @ORM\Column(type="string", name="name", nullable=true, length=255)
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