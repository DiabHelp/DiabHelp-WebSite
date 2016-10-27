<?php

namespace DH\APIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Logbook
 *
 * @ORM\Table(name="logbook", indexes={@ORM\Index(name="IDX_E96B9310A76ED395", columns={"user_id"})})
 * @ORM\Entity
 */
class Logbook
{
    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=43, nullable=false)
     */
    private $token;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DH\APIBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="DH\APIBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;



    /**
     * Set token
     *
     * @param string $token
     *
     * @return Logbook
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Logbook
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

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
     * Set user
     *
     * @param \DH\APIBundle\Entity\User $user
     *
     * @return Logbook
     */
    public function setUser(\DH\APIBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \DH\APIBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
