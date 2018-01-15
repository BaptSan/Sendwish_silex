<?php
namespace Entity;
use Doctrine\Common\Collections\ArrayCollection;
/** @Entity */
class User
{
	/**
     * @Id
     * @Column(type="integer", nullable=true)
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
    private $formatted_addr;

    /**
     * @Column(type="float", nullable=true)
     */
    private $lat;

    /**
     * @Column(type="float", nullable=true)
     */
    private $lng;

    /**
     * @Column(type="float", nullable=true)
     */
    private $distance;

    /**
     * @Column(type="string", nullable=true)
     */
    private $tel;

    /**
     * @Column(type="boolean", nullable=true)
     */
    private $is_admin;

    /**
     * @Column(type="boolean", nullable=true)
     */
    private $is_client;

    /**
     * @Column(type="string", nullable=true)
     */
    private $is_delivery;

    /**
     * One User has Many Orders.
     * @OneToMany(targetEntity="Order", mappedBy="users")
     */
    private $orders;

    public function __construct() {
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
        return $this->formatted_addr;
    }

    public function setFormattedAddr($formatted_addr)
    {
        $this->formatted_addr = $formatted_addr;

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
        return $this->is_admin;
    }

    public function setIsAdmin($is_admin)
    {
        $this->is_admin = $is_admin;

        return $this;
    }

    public function getIsClient()
    {
        return $this->is_client;
    }

    public function setIsClient($is_client)
    {
        $this->is_client = $is_client;

        return $this;
    }

    public function getIsDelivery()
    {
        return $this->is_delivery;
    }

    public function setIsDelivery($is_delivery)
    {
        $this->is_delivery = $is_delivery;

        return $this;
    }

}