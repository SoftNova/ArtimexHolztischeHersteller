<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/9/2016
 * Time: 3:33 PM
 */

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class CartItem
 * @package AppBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="cart")
 */
class Cart
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @ORM\Column(type="decimal", name="total_price", nullable=false, precision=9, scale=2)
     */
    protected $totalPrice;

    /**
     * @var
     * @ORM\Column(type="string", name="cart_currency", nullable=false)
     */
    protected $cartCurrency;

    /**
     * @var
     * @ORM\Column(type="integer", name="total_quantity", nullable=false, precision=9, scale=2)
     */
    protected $totalQuantity;

    /**
     * @var Order
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Order", inversedBy="cart")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CartItem", mappedBy="cart", cascade={"all"})
     */
    protected $cartItems;

    public function __construct()
    {
        $this->cartItems=new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCartCurrency()
    {
        return $this->cartCurrency;
    }

    /**
     * @param mixed $cartCurrency
     */
    public function setCartCurrency($cartCurrency)
    {
        $this->cartCurrency = $cartCurrency;
    }

    
    /**
     * @return ArrayCollection(CartItem)
     */
    public function getCartItems()
    {
        return $this->cartItems;
    }

    /**
     * @param ArrayCollection $cartItems
     */
    public function setCartItems($cartItems)
    {
        $this->cartItems = $cartItems;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }


    /**
     * @return mixed
     */
    public function getTotalPrice()
    {
        return $this->totalPrice. ',00';
    }

    /**
     * @param mixed $totalPrice
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    public function addItem(CartItem $item){
        foreach ($this->cartItems as $cartItem){
            if ($cartItem->equals($item)){
                $cartItem->setItemQuantity($cartItem->getItemQuantity()+1);
                $this->updateCart();
                return;
            }
        }
        $this->cartItems->add($item);
        $this->updateCart();
    }
    public function removeItem(CartItem $cartItem)
    {
        $this->cartItems->removeElement($cartItem);
        $this->updateCart();
    }
    public function updateCart(){
        $cartTotalQuantity=0;
        $cartTotalPrice=0;

        /** @var CartItem $item */
        foreach ($this->cartItems->getValues() as $item){
            $rawStringIntegerPriceArray=array_reverse(explode(',',($item->getItemPrice())));
            $numeralPrice = (int)preg_replace('#[^0-9]+#', '', end($rawStringIntegerPriceArray));
            $cartTotalPrice = ($numeralPrice*$item->getItemQuantity())+ $cartTotalPrice;
            $cartTotalQuantity = $item->getItemQuantity() + $cartTotalQuantity;
        }
        $this->totalPrice=$cartTotalPrice;
        $this->totalQuantity=$cartTotalQuantity;
    }
    /**
     * @return mixed
     */
    public function getTotalQuantity()
    {
        return $this->totalQuantity;
    }

    /**
     * @param mixed $totalQuantity
     */
    public function setTotalQuantity($totalQuantity)
    {
        $this->totalQuantity = $totalQuantity;
    }

    

}