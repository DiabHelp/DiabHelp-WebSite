<?php

namespace DH\APIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentArticle
 *
 * @ORM\Table(name="comment_article", indexes={@ORM\Index(name="IDX_F1496C76F675F31B", columns={"author_id"}), @ORM\Index(name="IDX_F1496C767294869C", columns={"article_id"})})
 * @ORM\Entity
 */
class CommentArticle
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
     * @var \DH\APIBundle\Entity\Article
     *
     * @ORM\ManyToOne(targetEntity="DH\APIBundle\Entity\Article")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     * })
     */
    private $article;

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
     * @return CommentArticle
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
     * @return CommentArticle
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
     * Set article
     *
     * @param \DH\APIBundle\Entity\Article $article
     *
     * @return CommentArticle
     */
    public function setArticle(\DH\APIBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \DH\APIBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set author
     *
     * @param \DH\APIBundle\Entity\User $author
     *
     * @return CommentArticle
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
