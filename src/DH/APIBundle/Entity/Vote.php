<?php

namespace DH\APIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vote
 *
 * @ORM\Table(name="vote", indexes={@ORM\Index(name="IDX_5A108564AFC2B591", columns={"module_id"}), @ORM\Index(name="IDX_5A108564F675F31B", columns={"author_id"})})
 * @ORM\Entity
 */
class Vote
{
    /**
     * @var integer
     *
     * @ORM\Column(name="vote", type="integer", nullable=false)
     */
    private $vote;

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
     * @var \DH\APIBundle\Entity\Module
     *
     * @ORM\ManyToOne(targetEntity="DH\APIBundle\Entity\Module")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="module_id", referencedColumnName="id")
     * })
     */
    private $module;

    /**
     * @var \DH\APIBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="DH\APIBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     * })
     */
    private $author;



    /**
     * Set vote
     *
     * @param integer $vote
     *
     * @return Vote
     */
    public function setVote($vote)
    {
        $this->vote = $vote;

        return $this;
    }

    /**
     * Get vote
     *
     * @return integer
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Vote
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
     * Set module
     *
     * @param \DH\APIBundle\Entity\Module $module
     *
     * @return Vote
     */
    public function setModule(\DH\APIBundle\Entity\Module $module = null)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return \DH\APIBundle\Entity\Module
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set author
     *
     * @param \DH\APIBundle\Entity\User $author
     *
     * @return Vote
     */
    public function setAuthor(\DH\APIBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \DH\APIBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
