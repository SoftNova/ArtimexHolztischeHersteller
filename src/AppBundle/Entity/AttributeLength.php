<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/4/2016
 * Time: 2:10 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AttributeLength
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AttributeLengthDAO")
 * @ORM\Table()
 */
class AttributeLength
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $lowerBound;
    /**
     * @ORM\Column(type="integer")
     */
    private $upperBound;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $staticValue;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLowerBound()
    {
        return $this->lowerBound;
    }

    /**
     * @param mixed $lowerBound
     */
    public function setLowerBound($lowerBound)
    {
        $this->lowerBound = $lowerBound;
    }

    /**
     * @return mixed
     */
    public function getUpperBound()
    {
        return $this->upperBound;
    }

    /**
     * @param mixed $upperBound
     */
    public function setUpperBound($upperBound)
    {
        $this->upperBound = $upperBound;
    }

    /**
     * @return mixed
     */
    public function getStaticValue()
    {
        return $this->staticValue;
    }

    /**
     * @param mixed $staticValue
     */
    public function setStaticValue($staticValue)
    {
        $this->staticValue = $staticValue;
    }


}