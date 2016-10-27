<?php

namespace DH\APIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentModule
 *
 * @ORM\Table(name="comment_module", indexes={@ORM\Index(name="IDX_C6377E3AF675F31B", columns={"author_id"}), @ORM\Index(name="IDX_C6377E3AAFC2B591", columns={"module_id"})})
 * @ORM\Entity
 */
class CommentModule
{
    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=false)
     */
    private $text;

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
     * Set text
     *
     * @param string $text
     *
     * @return CommentModule
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return CommentModule
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
     * @return CommentModule
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
     * @return CommentModule
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
