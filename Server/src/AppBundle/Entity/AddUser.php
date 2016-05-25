<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AddUser
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AddUserRepository")
 */
class AddUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="UID", type="string", length=8)
     */
    private $uID;
    
    /**
     * @var string
     *
     * @ORM\Column(name="pin", type="string", length=5)
     */
    private $pin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="admin", type="boolean")
     */
    private $admin;

    /**
     * @var float
     *
     * @ORM\Column(name="money", type="float")
     */
    private $money;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set uID
     *
     * @param string $uID
     *
     * @return AddMoney
     */
    public function setUID($uID)
    {
        $this->uID = $uID;

        return $this;
    }

    /**
     * Get uID
     *
     * @return string
     */
    public function getUID()
    {
        return $this->uID;
    }

    /**
     * Set money
     *
     * @param float $money
     *
     * @return AddMoney
     */
    public function setMoney($money)
    {
        $this->money = $money;

        return $this;
    }

    /**
     * Get money
     *
     * @return float
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * Set pin
     *
     * @param string $pin
     *
     * @return AddUser
     */
    public function setPin($pin)
    {
        $this->pin = $pin;
    
        return $this;
    }

    /**
     * Get pin
     *
     * @return string
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * Set admin
     *
     * @param boolean $admin
     *
     * @return AddUser
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    
        return $this;
    }

    /**
     * Get admin
     *
     * @return boolean
     */
    public function getAdmin()
    {
        return $this->admin;
    }
}
