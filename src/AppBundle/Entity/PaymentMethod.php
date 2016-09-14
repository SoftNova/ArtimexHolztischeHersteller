<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 8/16/2016
 * Time: 8:08 PM
 */


namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translatable;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Class PaymentMethod
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaymentMethodDAO")
 * @ORM\Table(name="payment_method")
 */
class PaymentMethod
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
     *
     * @ORM\Column(type="string", name="by_state_variance", nullable=true)
     */
    protected $modifier;

    /**
     * @return mixed
     */
    protected $translations;

    protected $nonPersistPaymentMethodName;

    /**
     * @return mixed
     */
    public function getNonPersistPaymentMethodName()
    {
        return $this->nonPersistPaymentMethodName;
    }

    /**
     * @param mixed $nonPersistPaymentMethodName
     */
    public function setNonPersistPaymentMethodName($nonPersistPaymentMethodName)
    {
        $this->nonPersistPaymentMethodName = $nonPersistPaymentMethodName;
    }




    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getModifier()
    {
        return $this->modifier;
    }

    /**
     * @param mixed $modifier
     */
    public function setModifier($modifier)
    {
        $this->modifier = $modifier;
    }

    /**
     * @return mixed
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @param mixed $translations
     */
    public function setTranslations($translations)
    {
        $this->translations = $translations;
    }

    public function __toString()
    {
        return ($translation = $this->getCurrentTranslation()) ?
            $translation->getName() : 'NO TRANSLATION';
    }

    public function getTranslatedName($lang){
        if($this->getTranslations()->containsKey($lang)){
            return $this->getTranslations()->get($lang)->getName();
        };
        return null;
    }
}