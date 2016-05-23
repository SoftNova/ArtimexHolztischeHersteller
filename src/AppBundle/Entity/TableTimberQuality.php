<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/9/2016
 * Time: 4:27 PM
 */

namespace AppBundle\Entity;
use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translatable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehavior;


/**
 * Class TableTimberQuality
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TableTimberQualityDAO")
 * @ORM\Table(name="table_timber_quality")
 */
class TableTimberQuality
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
     *
     * @ORM\Column(type="decimal", name="cost_increase", nullable=false, precision=9, scale=2)
     */
    protected $costIncrease;

    protected $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
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
    public function getCostIncrease()
    {
        return $this->costIncrease;
    }

    /**
     * @param mixed $costIncrease
     */
    public function setCostIncrease($costIncrease)
    {
        $this->costIncrease = $costIncrease;
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

}