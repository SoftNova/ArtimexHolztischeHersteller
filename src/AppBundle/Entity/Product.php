<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 3/31/2016
 * Time: 6:55 PM
 */

namespace AppBundle\Entity;
use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translatable;
use AppBundle\Utils\Utils;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 * @package AppBundle\Model
 * 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductDAO")
 * @ORM\Table(name="product")
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
    use Translatable;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @ORM\Column(type="string", length=13, unique=true, nullable=false)
     */
    protected $code;

    /**
     * @var
     * @ORM\Column(type="decimal", name="price", nullable=false, precision=9, scale=2)
     */
    protected $price;

    /**
     * @return mixed
     */
    protected $translations;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProductImage",
     *     mappedBy="productItem",
     *     cascade={"all"},
     *     orphanRemoval=true
     * )
     */
    protected $images;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->images = new ArrayCollection();
    }
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
     * @return ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }


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
     * @param ProductImage $image
     */
    public function addImage(ProductImage $image)
    {
        $this->images->add($image);
    }

    /**
     * @param ProductImage $image
     */
    public function removeImage(ProductImage $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * @ORM\PostRemove()
     */
    public function postRemove(){
        $dir = Utils::PRODUCT_IMAGE_PATH . $this->getCode();
        if (is_dir($dir)){
            rmdir($dir);
        }
    }
}