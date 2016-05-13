<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/26/2016
 * Time: 12:39 PM
 */


namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Class TableProduct
 * @package AppBundle\Entity
 * 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TableDAO")
 * @ORM\Table(name="table_item")
 */
class Table
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
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\TableDrawerAttribute", mappedBy="table", cascade={"all"}, fetch="LAZY")
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
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\TableLegAttribute", mappedBy="table", cascade={"all"})
     * @ORM\JoinColumn(name="leg_attribute_id", referencedColumnName="id", nullable=false)
     */
    protected $legAttribute;
    /**
     * @var
     * @ORM\Column(type="boolean", name="has_distance_to_sides", nullable=false)
     */
    protected $hasDistanceToSides;   

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
     * @param mixed $showInCatalog
     */
    public function setShowInCatalog($showInCatalog)
    {
        $this->showInCatalog = $showInCatalog;
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

    public function getMessage(){
        return $this->translate()->getMessage();
    }
    
    public function __toString()
    {
        if($name = $this->translate()->getName()){
            return $name;
        }
        return '';
    }

    /*
     * General utility function (for admin display mostly)
     */
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