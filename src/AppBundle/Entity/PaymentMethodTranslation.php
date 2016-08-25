<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 8/16/2016
 * Time: 8:12 PM
 */

namespace AppBundle\Entity;
use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translation;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PaymentMethodTranslation
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 */

class PaymentMethodTranslation
{
    use Translation;

    /**
     * @var
     * @ORM\Column(type="string", name="name", nullable=true, length=255)
     */
    protected $name;

    /**
     * @var
     * @ORM\Column(type="string", name="description", length=255, nullable=true)
     */
    protected $description;

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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


}