<?php
namespace Entity;
use Doctrine\Common\Collections\ArrayCollection;
/** @Entity */
class User
{
	/**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string", nullable=true)
     */
    private $lastname;

    /**
     * @Column(type="string", nullable=true)
     */
    private $firstname;

    /**
     * @Column(type="string", nullable=true)
     */
    private $mail;

    /**
     * @Column(type="string", nullable=true)
     */
    private $password;

    /**
     * @Column(type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @Column(type="string", nullable=true)
     */
    private $formattedAddr;

    /**
     * @Column(type="float", nullable=true)
     */
    private $lat;

    /**
     * @Column(type="float", nullable=true)
     */
    private $lng;

    /**
     * @Column(type="string", nullable=true)
     */
    private $distance;

    /**
     * @Column(type="string", nullable=true)
     */
    private $tel;

    /**
     * @Column(type="boolean", nullable=true)
     */
    private $isAdmin;

    /**
     * @Column(type="boolean", nullable=true)
     */
    private $isClient;

    /**
     * @Column(type="boolean", nullable=true)
     */
    private $isDelivery;


    /**
     * One user has Many cart items.
     * @OneToMany(targetEntity="CartItem", mappedBy="user", fetch="EAGER")
     */
    private $cartItems;

    /**
     * One user has Many orders.
     * @OneToMany(targetEntity="Order", mappedBy="user",fetch="EAGER")
     */
    private $orders;

    /**
     * @Column(type="string", nullable=true)
     */
    private $gender;

    public function __construct($lastname, $firstname, $thegender, $mail, $password, $birthdate, $formattedAddr, $lat, $lng, $distance, $tel, $isAdmin, $isClient, $isDelivery)
    {
        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->mail = $mail;
        $this->password = $password;
        $this->birthdate = $birthdate;
        $this->formattedAddr = $formattedAddr;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->distance = $distance;
        $this->tel = $tel;
        $this->isAdmin = $isAdmin;
        $this->isClient = $isClient;
        $this->isDelivery = $isDelivery;
        $this->gender = $thegender;
        $this->cartItems = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getLastname()
    {
        return $this->lastname;
    }
    
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getBirthdate()
    {
        return $this->birthdate;
    }

    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
        return $this;
    }
    
    public function getFormattedAddr()
    {
        return $this->formattedAddr;
    }

    public function setFormattedAddr($formattedAddr)
    {
        $this->formattedAddr = $formattedAddr;

        return $this;
    }

    public function getLat()
    {
        return $this->lat;
    }

    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng()
    {
        return $this->lng;
    }

    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    public function getDistance()
    {
        return $this->distance;
    }

    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    public function getTel()
    {
        return $this->tel;
    }

    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function getIsClient()
    {
        return $this->isClient;
    }

    public function setIsClient($isClient)
    {
        $this->isClient = $isClient;

        return $this;
    }

    public function getIsDelivery()
    {
        return $this->isDelivery;
    }

    public function setIsDelivery($isDelivery)
    {
        $this->isDelivery = $isDelivery;

        return $this;
    }

        public function getCartItems()
    {
        return $this->cartItems;
    }

    public function setCartItems($cartItems)
    {
        $this->cartItems = $cartItems;

        return $this;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }


    public function getOrders()
    {
        return $this->orders;
    }



}