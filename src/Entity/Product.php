<?php
namespace Entity;
use Doctrine\Common\Collections\ArrayCollection;

/** @Entity */
class Product implements \JsonSerializable
{

    public function JsonSerialize (){
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'cals' => $this->cals,
            'ingredients' => $this->ingredients,
            'imagePath' => $this->imagePath,
            'cartItems' => $this->cartItems,
            'category' => $this->category
        ];
    }
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
    private $imagePath;

    /**
     * One product has Many cart items.
     * @OneToMany(targetEntity="CartItem", mappedBy="product")
     */
    private $cartItems;


    /** 
    * @Column(type="string", columnDefinition="ENUM('drink', 'suppl','sandwich','child','menu')") 
    */
    private $category;
    public function __construct($name, $description, $price, $cals, $ingredients, $imagePath,$category)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->cals = $cals;
        $this->ingredients = $ingredients;
        $this->imagePath = $imagePath;
        $this->cartItems = new ArrayCollection();
        $this->category = $category;
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

        public function getImagePath()
    {
        return $this->imagePath;
    }

    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;

        return $this;
    }
       
    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }
}