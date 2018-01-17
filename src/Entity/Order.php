<?php
namespace Entity;
use Doctrine\Common\Collections\ArrayCollection;
/** @Entity */
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
	private $price_df;
	/**
     * @Column(type="float")
     */
	private $price;
	/**
     * @Column(type="integer")
     */
	private $order_num;

    /**
     * @Column(type="boolean")
     */
    private $eat_in;

    /**
     * @Column(type="boolean")
     */
    private $take_out;

    /**
     * One order has Many order items.
     * @OneToMany(targetEntity="OrderItem", mappedBy="order")
     */
    private $orderItems;

    /**
     * Many order item have one user.
     * @ManyToOne(targetEntity="User", inversedBy="orders")
     */
    private $user;

    public function __construct() {
        $this->orderItems = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPriceDf()
    {
        return $this->price_df;
    }

    public function setPriceDf($price_df)
    {
        $this->price_df = $price_df;

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
        return $this->order_num;
    }

    public function setOrderNum($order_num)
    {
        $this->order_num = $order_num;

        return $this;
    }
}