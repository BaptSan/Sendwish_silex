<?php
use Doctrine\Common\Collections\ArrayCollection;
namespace Entity;
/** @Entity */
class CartItem
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
	private $userId;

	/**
     * @Column(type="integer")
     */
	private $productId;

	/**
     * @Column(type="integer")
     */
	private $quantity;

	/**
     * Many cart item have one user.
     * @ManyToOne(targetEntity="User", inversedBy="cartItems")
     */
	private $user;

	/**
     * Many cart item have one product.
     * @ManyToOne(targetEntity="Product", inversedBy="cartItems", fetch="EAGER")
     */
	private $product;

	public function __construct($userId, $productId, $quantity, $user, $product)
	{
		$this->userId = $userId;
		$this->productId = $productId;
		$this->quantity = $quantity;
		$this->user = $user;
		$this->product = $product;
	}


    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }
}