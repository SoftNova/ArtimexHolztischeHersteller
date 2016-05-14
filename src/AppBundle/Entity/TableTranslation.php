<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/6/2016
 * Time: 3:31 PM
 */

namespace AppBundle\Entity;

use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translation;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TableTranslation
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 */
class TableTranslation
{
    use Translation;

    /**
     * @var
     * @ORM\Column(type="string", name="name", nullable=false, length=255)
     */
    protected $name;

    /**
     * @var
     * @ORM\Column(type="string", name="description", nullable=true, length=255)
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
     * @ORM\Column(type="string", name="message", nullable=true)
     */
    protected $message;

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
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    
}