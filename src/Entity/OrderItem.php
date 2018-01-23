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
     * @Column(type="string")
     */
   
    private $name;

	/**
     * @Column(type="float")
     */

	private $priceDf;
	/**
     * @Column(type="float")
     */
	private $price;

	/**
     * Many order item have one order.
     * @ManyToOne(targetEntity="Order", inversedBy="orderItems")
     */
	private $order;

	public function __construct($name, $priceDf, $price, $order)
	{
		$this->name = $name;
		$this->priceDf = $priceDf;
        $this->price = $price;
		$this->order = $order;
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