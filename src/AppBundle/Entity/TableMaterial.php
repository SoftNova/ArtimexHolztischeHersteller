<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/5/2016
 * Time: 1:38 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Class TableMaterial
 * @package AppBundle\Entity
 * 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TableMaterialDAO")
 * @ORM\Table(name="table_material")
 */
class TableMaterial
{
    use ORMBehaviors\Translatable\Translatable;

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id")
     */
    private $id;

    /**
     * @var
     * Value, either PricePerSquareMeter or percentage of primary material
     * @ORM\Column(type="decimal", name="percentage")
     */
    private $percentage;

    /**
     * Check whether this object has the possibility of extension.
     * @ORM\Column(type="boolean", name="is_tempered", nullable=false)
     */
    private $isTempered;
    
    // TO DO - ADD SAMPLE PICTURE FOR MATERIALS
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
    public function getPercentage()
    {
        return $this->percentage;
    }


    /**
     * @param mixed $percentage
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
    }

    /**
     * @return mixed
     */
    public function getIsTempered()
    {
        return $this->isTempered;
    }

    /**
     * @param mixed $isTempered
     */
    public function setIsTempered($isTempered)
    {
        $this->isTempered = $isTempered;
    }

    public function __toString()
    {
        if($name = $this->translate()->getName()){
            return $name;
       }
        return '';
    }


}