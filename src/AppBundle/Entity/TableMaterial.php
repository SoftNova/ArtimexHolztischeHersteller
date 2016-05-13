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
    protected $id;

    /**
     * @var
     * Value, either PricePerSquareMeter or percentage of primary material
     * @ORM\Column(type="decimal", name="percentage", precision=9, scale=2)
     */
    protected $percentage;

    /**
     * Check whether this object has the possibility of extension.
     * @ORM\Column(type="boolean", name="is_tempered", nullable=false)
     */
    protected $isTempered;

    /**
     * @var
     * @ORM\Column(type="decimal", name="scaling_point", precision=9, scale=2, nullable=true)
     */
    protected $scalingPoint;

    /**
     * @var
     * @ORM\Column(type="decimal", name="scaling_percentage", precision=9, scale=2, nullable=true)
     */
    protected $scalingPercentage;
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

    /**
     * @return mixed
     */
    public function getScalingPoint()
    {
        return $this->scalingPoint;
    }

    /**
     * @param mixed $scalingPoint
     */
    public function setScalingPoint($scalingPoint)
    {
        $this->scalingPoint = $scalingPoint;
    }

    /**
     * @return mixed
     */
    public function getScalingPercentage()
    {
        return $this->scalingPercentage;
    }

    /**
     * @param mixed $scalingPercentage
     */
    public function setScalingPercentage($scalingPercentage)
    {
        $this->scalingPercentage = $scalingPercentage;
    }


    public function __toString()
    {
        if($name = $this->translate()->getName()){
            return $name;
       }
        return '';
    }

    public function getStringIsTempered(){
        return (intval($this->isTempered)===0 ? "No" : "Yes");
    }
    public function toAdmin(){
        return $this->translate('admin')->getName();
    }
    public function getLocales($locales){
        $output=array();
        foreach ($locales as $locale) {
            if (strcmp($locale,"admin")!==0) {
                if (!is_null($this->translate($locale)->getName())) {
                    $output[] = $this->translate($locale)->getLocale();
                }
            }
        }
        return (count($output)>0 ? implode("-",array_unique($output)) : "_Not available");
    }
}