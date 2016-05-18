<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/6/2016
 * Time: 3:39 PM
 */

namespace AppBundle\Entity;
use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translation;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductTranslation
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 */

class ProductTranslation
{
    use Translation;

    /**
     * @var
     * @ORM\Column(type="string", name="name", nullable=false, length=255)
     */
    protected $name;

    /**
     * @var
     * @ORM\Column(type="string", name="description", length=255, nullable=true)
     */
    protected $description;

    /**
     * @var
     *
     * @ORM\Column(type="string", name="by_state_variance", nullable=true)
     */
    protected $byStateVariance;

    /**
     * @var
     * @ORM\Column(type="boolean", name="visibility")
     */
    protected $visibility;

    /**
     * @return mixed
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param mixed $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    

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

    /**
     * @return mixed
     */
    public function getByStateVariance()
    {
        return $this->byStateVariance;
    }

    /**
     * @param mixed $byStateVariance
     */
    public function setByStateVariance($byStateVariance)
    {
        $this->byStateVariance = $byStateVariance;
    }



}