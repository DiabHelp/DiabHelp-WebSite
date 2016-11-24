<?php

namespace DH\APIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Module
 *
 * @ORM\Table(name="module")
 * @ORM\Entity
 */
class Module
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="organisme", type="string", length=255, nullable=false)
     */
    private $organisme;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="text", nullable=false)
     */
    private $logo;

    /**
     * @var float
     *
     * @ORM\Column(name="note", type="float", precision=10, scale=0, nullable=false)
     */
    private $note = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="display", type="integer", nullable=false)
     */
    private $display = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=42, nullable=false)
     */
    private $version = '0.0.1';

    /**
     * @var integer
     *
     * @ORM\Column(name="isNew", type="integer", nullable=false)
     */
    private $isnew = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="urlStore", type="text", nullable=false)
     */
    private $urlstore;

    /**
     * @var string
     *
     * @ORM\Column(name="urlSiteWeb", type="text", nullable=false)
     */
    private $urlsiteweb;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="text", nullable=false)
     */
    private $size;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbVote", type="integer")
     */
    private $nbVote;

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
     * @param float $note
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
     * @return float
     */
    public function getNote()
    {
        return $this->note;
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
     * Set isnew
     *
     * @param integer $isnew
     *
     * @return Module
     */
    public function setIsnew($isnew)
    {
        $this->isnew = $isnew;

        return $this;
    }

    /**
     * Get isnew
     *
     * @return integer
     */
    public function getIsnew()
    {
        return $this->isnew;
    }

    /**
     * Set urlstore
     *
     * @param string $urlstore
     *
     * @return Module
     */
    public function setUrlstore($urlstore)
    {
        $this->urlstore = $urlstore;

        return $this;
    }

    /**
     * Get urlstore
     *
     * @return string
     */
    public function getUrlstore()
    {
        return $this->urlstore;
    }

    /**
     * Set urlsiteweb
     *
     * @param string $urlsiteweb
     *
     * @return Module
     */
    public function setUrlsiteweb($urlsiteweb)
    {
        $this->urlsiteweb = $urlsiteweb;

        return $this;
    }

    /**
     * Get urlsiteweb
     *
     * @return string
     */
    public function getUrlsiteweb()
    {
        return $this->urlsiteweb;
    }

    /**
     * Set size
     *
     * @param string $size
     *
     * @return Module
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
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
     * Set nbVote
     *
     * @return \DH\APIBundle\Entity\Module
     */
    public function setNbVote($nbVote)
    {
        $this->nbVote = $nbVote;
        return $this;
    }

    /**
     * Set nbVote
     *
     * @return integer
     */
    public function getNbVote()
    {
        return $this->nbVote;
    }
}
