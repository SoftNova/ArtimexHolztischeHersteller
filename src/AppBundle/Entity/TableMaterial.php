<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/5/2016
 * Time: 1:38 PM
 */

namespace AppBundle\Entity;
use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translatable;
use AppBundle\Utils\Utils;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TableMaterial
 * @package AppBundle\Entity
 * 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TableMaterialDAO")
 * @ORM\Table(name="table_material")
 * @ORM\HasLifecycleCallbacks()
 */
class TableMaterial
{
    use Translatable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id")
     */
    protected $id;

    /**
     * @var
     * @ORM\Column(type="string", length=13, unique=true, nullable=false)
     */
    protected $code;
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

    /**
     * @var
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\TableMaterialImage", mappedBy="materialItem", cascade={"all"}, orphanRemoval=true)
     */
    protected $image;

    protected $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }
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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }


    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
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
        if($name = $this->getName()){
            return $name;
       }
        return '';
    }

    public function getLocales(){
        $locales = implode("-",$this->getTranslations()->getKeys());
        $locales = (strpos($locales,"admin")!==false) ? substr($locales,6):$locales;
        return (strlen($locales)===0) ? '-' : $locales;
    }
    public function adminName(){
        if($this->getTranslations()->containsKey('admin')){
            return $this->getTranslations()->get('admin');
        };
    }

    /**
     * @ORM\PostRemove()
     */
    public function postRemove(){
        $dir = Utils::MATERIAL_IMAGE_PATH . $this->getCode();
        $this->deleteDirectory($dir);
    }
    public function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }

        }

        return rmdir($dir);
    }

}