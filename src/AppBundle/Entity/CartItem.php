<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/9/2016
 * Time: 3:33 PM
 */

namespace AppBundle\Entity;


class CartItem
{
    protected $uniqueItemCode;

    protected $itemName;

    protected $itemCode;

    protected $itemImg;

    protected $itemPrice;

    protected $itemSpecs;

    protected $itemQuantity;

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