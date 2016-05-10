<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 3/31/2016
 * Time: 6:55 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Class Product
 * @package AppBundle\Model
 * 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductDAO")
 * @ORM\Table(name="product")
 */
class Product
{
    use ORMBehaviors\Translatable\Translatable;

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @ORM\Column(type="decimal", name="price", nullable=false, precision=9, scale=2)
     */
    protected $price;

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

    public function __toString()
    {
        if($name = $this->translate()->getName()){
            return $name;
        }
        return '';
    }

    public function toAdmin(){
        return $this->translate('admin')->getName();
    }

}