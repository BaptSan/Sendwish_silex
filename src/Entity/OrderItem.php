<?php
namespace Entity;
use Doctrine\Common\Collections\ArrayCollection;
/** @Entity */
class OrderItem
{
	/**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="integer")
     */
    private $order_id;

    /**
     * @Column(type="string")
     */
    private $name;

	/**
     * @Column(type="float")
     */

	private $price_df;
	/**
     * @Column(type="float")
     */
	private $price;

	/**
     * Many order item have one order.
     * @ManyToOne(targetEntity="Order", inversedBy="orderItems")
     */
	private $order;

	public function __construct($id, $order_id, $name, $price_df, $price, $order)
	{
		$this->id = $id;
		$this->order_id = $order_id;
		$this->name = $name;
		$this->price_df = $price_df;
		$this->price = $price;
		$this->order = $order;
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

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }
}