<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/6/2016
 * Time: 3:31 PM
 */

namespace AppBundle\Entity;

use Knp\DoctrineBehaviors\Model as ORMBehavior;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TableTranslation
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 */
class TableTranslation
{
    use ORMBehavior\Translatable\Translation;


    /**
     * @var
     * @ORM\Column(type="string", name="name", nullable=false, length=255)
     */
    protected $name;

    /**
     * @var
     * @ORM\Column(type="string", name="description", nullable=false, length=255)
     */
    protected $description;

    /**
     * @var
     * 
     * @ORM\Column(type="decimal", name="by_state_variance", nullable=false, precision=9, scale=2)
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

    
}