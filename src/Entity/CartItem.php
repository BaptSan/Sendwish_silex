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
	private $user_id;

	/**
     * @Column(type="integer")
     */
	private $product_id;

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
     * @ManyToOne(targetEntity="Product", inversedBy="cartItems")
     */
	private $product;


    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    public function setProductId($product_id)
    {
        $this->product_id = $product_id;

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