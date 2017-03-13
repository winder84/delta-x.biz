<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=255)
     */
    private $alias;

    /**
     * @var string
     *
     * @ORM\Column(name="prev_description", type="text", nullable=true)
     */
    private $prevDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="text")
     */
    private $type;

    /**
     * @Assert\NotBlank()
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ArticleHasMedia", mappedBy="article",cascade={"persist","remove"})
     * @ORM\JoinTable(name="article_galleries")
     */
    private $articleMedia;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set prevDescription
     *
     * @param string $prevDescription
     *
     * @return Article
     */
    public function setPrevDescription($prevDescription)
    {
        $this->prevDescription = $prevDescription;

        return $this;
    }

    /**
     * Get prevDescription
     *
     * @return string
     */
    public function getPrevDescription()
    {
        return $this->prevDescription;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Article
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
     * Constructor
     */
    public function __construct()
    {
        $this->articleMedia = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add articleMedia
     *
     * @param \AppBundle\Entity\ArticleHasMedia $articleMedia
     *
     * @return Article
     */
    public function addArticleMedia(\AppBundle\Entity\ArticleHasMedia $articleMedia)
    {
        $this->articleMedia[] = $articleMedia;

        return $this;
    }

    /**
     * Remove articleMedia
     *
     * @param \AppBundle\Entity\ArticleHasMedia $articleMedia
     */
    public function removeArticleMedia(\AppBundle\Entity\ArticleHasMedia $articleMedia)
    {
        $this->articleMedia->removeElement($articleMedia);
    }

    /**
     * Get articleMedia
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticleMedia()
    {
        return $this->articleMedia;
    }

    /**
     * Set articleMedia
     *
     * @param array
     * @return Article
     */
    public function setArticleMedia($media)
    {
        $this->articleMedia = new ArrayCollection();
        foreach ($media as $m) {
            $m->setArticle($this);
            $this->addArticleMedia($m);
        }
        return $this;
    }

    /**
     * Set alias
     *
     * @param string $alias
     *
     * @return Article
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Article
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
}
