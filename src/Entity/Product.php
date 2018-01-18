<?php
namespace Entity;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @Column(type="string")
     */
    private $image_path;

    /**
     * One product has Many cart items.
     * @OneToMany(targetEntity="CartItem", mappedBy="product")
     */
    private $cartItems;


    public function __construct($id, $name, $description, $price, $cals, $ingredients, $image_path, $cartItems)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->cals = $cals;
        $this->ingredients = $ingredients;
        $this->image_path = $image_path;
        $this->cartItems = new ArrayCollection();
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