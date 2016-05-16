<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/26/2016
 * Time: 12:39 PM
 */


namespace AppBundle\Entity;
use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translatable;
use AppBundle\Utils\Utils;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Class TableProduct
 * @package AppBundle\Entity
 * 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TableDAO")
 * @ORM\Table(name="table_item")
 * @ORM\HasLifecycleCallbacks()
 */
class Table
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
     * @ORM\Column(type="decimal", name="base_price", nullable=false, precision=9, scale=2)
     */
    protected $basePrice;

    /**
     * Check whether this object has the possibility of extension.
     * @ORM\Column(type="boolean", name="has_extension", nullable=false)
     */
    protected $hasExtension;

    /**
     * @var
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\TableDrawerAttribute", cascade={"all"}, fetch="LAZY")
     * @ORM\JoinColumn(name="drawer_attribute_id", referencedColumnName="id", nullable=true)
     */
    protected $drawerAttribute;

    /**
     * Check whether this object is visible.
     * @ORM\Column(type="boolean", name="show_in_catalog", nullable=false)
     */
    protected $showInCatalog;

    /**
     * @var
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\TableLegAttribute", cascade={"all"})
     * @ORM\JoinColumn(name="leg_attribute_id", referencedColumnName="id", nullable=false)
     */
    protected $legAttribute;
    /**
     * @var
     * @ORM\Column(type="boolean", name="has_distance_to_sides", nullable=false)
     */
    protected $hasDistanceToSides;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\TableImage",
     *     mappedBy="tableItem",
     *     cascade={"all"},
     *     orphanRemoval=true
     * )
     */
    protected $images;

    protected $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->images=new ArrayCollection();
    }
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
    public function getBasePrice()
    {
        return $this->basePrice;
    }

    /**
     * @param mixed $basePrice
     */
    public function setBasePrice($basePrice)
    {
        $this->basePrice = $basePrice;
    }

    /**
     * @return mixed
     */
    public function getHasExtension()
    {
        return $this->hasExtension;
    }

    /**
     * @param mixed $hasExtension
     */
    public function setHasExtension($hasExtension)
    {
        $this->hasExtension = $hasExtension;
    }

    /**
     * @return mixed
     */
    public function getDrawerAttribute()
    {
        return $this->drawerAttribute;
    }

    /**
     * @param mixed $drawerAttribute
     */
    public function setDrawerAttribute($drawerAttribute)
    {
        $this->drawerAttribute = $drawerAttribute;
    }

    /**
     * @return mixed
     */
    public function getLegAttribute()
    {
        return $this->legAttribute;
    }

    /**
     * @param mixed $legAttribute
     */
    public function setLegAttribute($legAttribute)
    {
        $this->legAttribute = $legAttribute;
    }

    /**
     * @return mixed
     */
    public function getHasDistanceToSides()
    {
        return $this->hasDistanceToSides;
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
     * @param mixed $showInCatalog
     */
    public function setShowInCatalog($showInCatalog)
    {
        $this->showInCatalog = $showInCatalog;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param TableImage $image
     */
    public function addImage(TableImage $image)
    {
        $this->images->add($image);
    }

    /**
     * @param TableImage $image
     */
    public function removeImage(TableImage $image)
    {
        $this->images->removeElement($image);
    }

    
    /**
     * @return mixed
     */
    public function getShowInCatalog()
    {
        return $this->showInCatalog;
    }

    /**
     * @param mixed $hasDistanceToSides
     */
    public function setHasDistanceToSides($hasDistanceToSides)
    {
        $this->hasDistanceToSides = $hasDistanceToSides;
    }

    /*
     * General utility function (for admin display mostly)
     */
    public function getLocales(){
        $locales = implode("-",$this->getTranslations()->getKeys());
        $locales = (strpos($locales,"admin")!==false) ? substr($locales,6):$locales;
        return (strlen($locales)===0) ? '-' : $locales;
    }
    public function __toString()
    {
        if($name = $this->getName()){
            return $name;
        }
        return '';
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
        $dir = Utils::TABLE_IMAGE_PATH . $this->getCode();
        if (is_dir($dir)){
            rmdir($dir);
        }
    }


}