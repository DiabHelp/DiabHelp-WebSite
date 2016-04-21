<?php

namespace DH\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Module
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DH\PlatformBundle\Entity\ModuleRepository")
 */
class Module
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="organisme", type="string", length=255)
     */
    private $organisme;

    /**
     * @ORM\OneToMany(targetEntity="DH\PlatformBundle\Entity\CommentModule", mappedBy="module", cascade={"persist", "remove"})
     */
    private $comments;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="text", options={"default" = "basic.jpg"})
     */
    private $logo;

    /**
     * @var float
     *
     * @ORM\Column(name="note", type="float", options={"default" = 0})
     */
    private $note = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_vote", type="integer", options={"default" = 0})
     */
    private $nbVote = 0;

    /**
     * @ORM\OneToMany(targetEntity="DH\PlatformBundle\Entity\Vote", mappedBy="module", cascade={"persist", "remove"})
     */
    private $votes;

    /**
     * @var integer
     *
     * @ORM\Column(name="display", type="integer", options={"default" = 1})
     */
    private $display = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="isNew", type="integer", options={"default" = 1})
     */
    private $isNew = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=42, options={"default" = "0.0.1"})
     */
    private $version;

    /**
     * @var string
     *
     * @ORM\Column(name="urlStore", type="text", options={"default" = "ya pas pour le moment"})
     */
    private $urlStore = "";

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getUrlSiteWeb()
    {
        return $this->urlSiteWeb;
    }

    /**
     * @param string $urlSiteWeb
     */
    public function setUrlSiteWeb($urlSiteWeb)
    {
        $this->urlSiteWeb = $urlSiteWeb;
    }

    /**
     * @return string
     */
    public function getUrlStore()
    {
        return $this->urlStore;
    }

    /**
     * @param string $urlStore
     */
    public function setUrlStore($urlStore)
    {
        $this->urlStore = $urlStore;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="urlSiteWeb", type="text", options={"default" = "ya pas pour le moment"})
     */
    private $urlSiteWeb = "";

    /**
     * @return int
     */
    public function getIsNew()
    {
        return $this->isNew;
    }

    /**
     * @param int $isNew
     */
    public function setIsNew($isNew)
    {
        $this->isNew = $isNew;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="text", options={"default" = "0mb"})
     */
    private $size = "";

    public function __construct()
    {
        $this->version = "0.0.1";
        $this->urlStore = "";
        $this->urlSiteWeb = "";
        $this->logo = "";
        $this->isNew = 1;
        $this->size = "Omb";
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
     * Set name
     *
     * @param string $name
     *
     * @return Module
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Module
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return Module
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set note
     *
     * @param integer $note
     *
     * @return Module
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set nbVote
     *
     * @param integer $nbVote
     *
     * @return Module
     */
    public function setNbVote($nbVote)
    {
        $this->nbVote = $nbVote;

        return $this;
    }

    /**
     * Get nbVote
     *
     * @return integer
     */
    public function getNbVote()
    {
        return $this->nbVote;
    }

    /**
     * Set display
     *
     * @param integer $display
     *
     * @return Module
     */
    public function setDisplay($display)
    {
        $this->display = $display;

        return $this;
    }

    /**
     * Get display
     *
     * @return integer
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * Set version
     *
     * @param string $version
     *
     * @return Module
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Module
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set organisme
     *
     * @param string $organisme
     *
     * @return Module
     */
    public function setOrganisme($organisme)
    {
        $this->organisme = $organisme;

        return $this;
    }

    /**
     * Get organisme
     *
     * @return string
     */
    public function getOrganisme()
    {
        return $this->organisme;
    }

    /**
     * Add comment
     *
     * @param \DH\PlatformBundle\Entity\CommentModule $comment
     *
     * @return Module
     */
    public function addComment(\DH\PlatformBundle\Entity\CommentModule $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \DH\PlatformBundle\Entity\CommentModule $comment
     */
    public function removeComment(\DH\PlatformBundle\Entity\CommentModule $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    public function __toString()
    {
        return strval($this->id);
    }

}
