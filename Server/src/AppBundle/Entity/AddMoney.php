<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AddMoney
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AddMoneyRepository")
 */
class AddMoney
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
     * @ORM\Column(name="UID", type="string", length=255)
     */
    private $uID;

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
}

