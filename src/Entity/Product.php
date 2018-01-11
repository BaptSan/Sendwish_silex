<?php

/** @Entity */
class Product
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
     * @Column(type="string")
     */
	private $description;

	/**
     * @Column(type="float")
     */
	private $price;

	/**
     * @Column(type="float")
     */
	private $cals;

	/**
     * @Column(type="string")
     */
	private $ingredients;

	 /**
     * Many Products have Many Orders.
     * @ManyToMany(targetEntity="Order", inversedBy="products")
     * @JoinTable(name="products_orders")
     */	
    private $orders;

    public function __construct() {
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

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

    public function getCals()
    {
        return $this->cals;
    }

    public function setCals($cals)
    {
        $this->cals = $cals;

        return $this;
    }

    public function getIngredients()
    {
        return $this->ingredients;
    }

    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;

        return $this;
    }
}