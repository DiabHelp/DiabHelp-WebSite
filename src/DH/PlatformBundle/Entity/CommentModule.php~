<?php

namespace DH\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentModule
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DH\PlatformBundle\Entity\CommentModuleRepository")
 */
class CommentModule
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
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="DH\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="DH\PlatformBundle\Entity\Module", inversedBy="CommentModule")
     * @ORM\JoinColumn(nullable=false)
     */
    private $module;

    public function __construct()
    {
        $this->date = new \Datetime();
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
     * Set author
     *
     * @param \DH\UserBundle\Entity\User $author
     *
     * @return CommentModule
     */
    public function setAuthor(\DH\UserBundle\Entity\User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \DH\UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set module
     *
     * @param \DH\PlatformBundle\Entity\Module $module
     *
     * @return CommentModule
     */
    public function setModule(\DH\PlatformBundle\Entity\Module $module)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return \DH\PlatformBundle\Entity\Module
     */
    public function getModule()
    {
        return $this->module;
    }
}
