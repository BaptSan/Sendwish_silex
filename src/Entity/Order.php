<?php
namespace Entity;
use Doctrine\Common\Collections\ArrayCollection;
/** 
* @Entity 
* @Table(name="`Order`")
*/
class Order
{
	/**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
	private $id;
	/**
     * @Column(type="float")
     */
	private $priceDf;
	/**
     * @Column(type="float")
     */
	private $price;
	/**
     * @Column(type="string")
     */
	private $orderNum;

    /**
     * @Column(type="boolean")
     */
    private $eatIn;

    /**
     * @Column(type="boolean")
     */
    private $takeOut;

    /**
     * @Column(type="datetime")
     */
    private $orderDate;

    /**
     * One order has Many order items.
     * @OneToMany(targetEntity="OrderItem", mappedBy="order", cascade={"persist","remove"})
     */
    private $orderItems;

    /**
     * Many order item have one user.
     * @ManyToOne(targetEntity="User", inversedBy="orders", cascade={"persist"})
     */
    private $user;

    public function __construct($priceDf, $price, $orderNum, $eatIn, $takeOut, $orderDate, $user)
    {
        $this->priceDf = $priceDf;
        $this->price = $price;
        $this->orderNum = $orderNum;
        $this->eatIn = $eatIn;
        $this->takeOut = $takeOut;
        $this->orderItems = new ArrayCollection();
        $this->user = $user;
        $this->orderDate = $orderDate;
    }
    public function addOrderItem($orderItem){
        $this->orderItems->add($orderItem);
    }
    public function getId()
    {
        return $this->id;
    }

    public function getPriceDf()
    {
        return $this->priceDf;
    }

    public function setPriceDf($priceDf)
    {
        $this->priceDf = $priceDf;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getOrderNum()
    {
        return $this->orderNum;
    }

    public function setOrderNum($orderNum)
    {
        $this->orderNum = $orderNum;

        return $this;
    }

        public function getEatIn()
    {
        return $this->eatIn;
    }

    public function setEatIn($eatIn)
    {
        $this->eatIn = $eatIn;

        return $this;
    }


    public function getTakeOut()
    {
        return $this->takeOut;
    }

    public function setTakeOut($takeOut)
    {
        $this->takeOut = $takeOut;

        return $this;
    }



        public function getOrderDate()
    {
        return $this->orderDate;
    }

    public function setOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;

        return $this;
    }

}