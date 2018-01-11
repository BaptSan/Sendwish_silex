<?php

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
    /**
     * Many Orders have Many Products.
     * @ManyToMany(targetEntity="Product", mappedBy="orders")
     */
    private $products;

    /**
     * Many Orders have One User.
     * @ManyToOne(targetEntity="User", inversedBy="orders")
     */
    private $users;
    
    public function __construct() {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }
}