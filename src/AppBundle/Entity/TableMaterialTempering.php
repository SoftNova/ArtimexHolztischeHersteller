<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/9/2016
 * Time: 3:38 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehavior;
/**
 * Class TableMaterialTempering
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="table_material_tempering")
 */
class TableMaterialTempering
{

    use ORMBehavior\Translatable\Translatable;

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
     *
     * @ORM\Column(type="decimal", name="cost_increase", nullable=false, precision=9, scale=2)
     */
    protected $costIncrease;

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
    public function getLocales($locales){
        $output=array();
        foreach ($locales as $locale) {
            if (strcmp($locale,"admin")!==0){
                $output[$locale] = $this->translate($locale)->getLocale();
            }
        }
        return (implode("-",array_unique($output)));
    }

}