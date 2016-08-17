<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/9/2016
 * Time: 3:33 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CartItem
 * @package AppBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="cart_item")
 */
class CartItem
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @ORM\Column(type="string", nullable=false, name="item_name")
     */
    protected $itemName;

    /**
     * @var
     * @ORM\Column(type="string", nullable=false, name="item_code")
     */
    protected $itemCode;

    /**
     * @var
     * @ORM\Column(type="string", name="item_price", nullable=false, length=255)
     */
    protected $itemPrice;

    /**
     * @var
     * @ORM\Column(type="string", nullable=false, name="item_config")
     */
    protected $itemConfig;

    /**
     * @var
     * @ORM\Column(type="integer", nullable=false, name="item_quantity")
     */
    protected $itemQuantity;


    /**
     * @var Cart
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cart", inversedBy="cartItems")
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id")
     */
    protected $cart;

    /** non persistent */
    protected $uniqueItemCode;
    protected $itemImg;
    protected $itemSpecs;

    /**
     * @return mixed
     */
    public function getItemConfig()
    {
        return $this->itemConfig;
    }

    /**
     * @param mixed $itemConfig
     */
    public function setItemConfig($itemConfig)
    {
        $this->itemConfig = $itemConfig;
    }

    /**
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param Cart $cart
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
    }



    /**
     * @return mixed
     */
    public function getItemName()
    {
        return $this->itemName;
    }


    /**
     * @param mixed $itemName
     */
    public function setItemName($itemName)
    {
        $this->itemName = $itemName;
    }

    /**
     * @return mixed
     */
    public function getUniqueItemCode()
    {
        return $this->uniqueItemCode;
    }

    /**
     * @param mixed $uniqueItemCode
     */
    public function setUniqueItemCode($uniqueItemCode)
    {
        $this->uniqueItemCode = $uniqueItemCode;
    }


    /**
     * @return mixed
     */
    public function getItemCode()
    {
        return $this->itemCode;
    }

    /**
     * @param mixed $itemCode
     */
    public function setItemCode($itemCode)
    {
        $this->itemCode = $itemCode;
    }

    /**
     * @return mixed
     */
    public function getItemImg()
    {
        return $this->itemImg;
    }

    /**
     * @param mixed $itemImg
     */
    public function setItemImg($itemImg)
    {
        $this->itemImg = $itemImg;
    }

    /**
     * @return mixed
     */
    public function getItemPrice()
    {
        return $this->itemPrice;
    }

    /**
     * @param mixed $itemPrice
     */
    public function setItemPrice($itemPrice)
    {
        $this->itemPrice = $itemPrice;
    }

    /**
     * @return mixed
     */
    public function getItemSpecs()
    {
        return $this->itemSpecs;
    }

    /**
     * @param mixed $itemSpecs
     */
    public function setItemSpecs($itemSpecs)
    {
        $this->itemSpecs = $itemSpecs;
    }

    /**
     * @return mixed
     */
    public function getItemQuantity()
    {
        return $this->itemQuantity;
    }

    /**
     * @param mixed $itemQuantity
     */
    public function setItemQuantity($itemQuantity)
    {
        $this->itemQuantity = $itemQuantity;
    }

    public function equals(CartItem $other){
        if (strcmp($this->itemName,$other->getItemName())!=0){
            return false;
        }

        if (strcmp($this->itemCode,$other->getItemCode())!=0){
            return false;
        }

        if (strcmp($this->itemImg,$other->getItemImg())!=0){
            return false;
        }

        if (strcmp($this->itemPrice,$other->getItemPrice())!=0){
            return false;
        }

        if (count($this->itemSpecs)!=count($other->getItemSpecs())){
            return false;
        }else{
            for ($i = 0 ; $i < count($this->itemSpecs); $i++ ){
                if (strcmp($this->itemSpecs[$i],$other->getItemSpecs()[$i])!=0){
                    return false;
                }
            }
        }
        return true;
    }

    public function getTotalPrice(){
        $itemTotalCost=0;
        $rawStringIntegerPriceArray=array_reverse(explode(',',($this->getItemPrice())));
        $numeralPrice = (int)preg_replace('#[^0-9]+#', '', end($rawStringIntegerPriceArray));
        $itemTotalCost = ($numeralPrice*$this->getItemQuantity())+ $itemTotalCost;
        return $itemTotalCost.',00';
    }

}