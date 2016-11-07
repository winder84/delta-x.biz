<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category", inversedBy="products", cascade={"persist"})
     * @ORM\JoinColumn(name="categoryId", referencedColumnName="id", onDelete="SET NULL")
     **/
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ProductLink", inversedBy="products", cascade={"persist"})
     * @ORM\JoinColumn(name="productLinkId", referencedColumnName="id", onDelete="SET NULL")
     **/
    private $productLink;

    /**
     * @Assert\NotBlank()
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProductHasMedia", mappedBy="product",cascade={"persist","remove"})
     * @ORM\JoinTable(name="product_galleries")
     */
    private $productMedia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productMedia = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Product
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
     * Set alias
     *
     * @param string $alias
     *
     * @return Product
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
     * Set text
     *
     * @param string $text
     *
     * @return Product
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
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set productLink
     *
     * @param \AppBundle\Entity\ProductLink $productLink
     *
     * @return Product
     */
    public function setProductLink(\AppBundle\Entity\ProductLink $productLink = null)
    {
        $this->productLink = $productLink;

        return $this;
    }

    /**
     * Get productLink
     *
     * @return \AppBundle\Entity\ProductLink
     */
    public function getProductLink()
    {
        return $this->productLink;
    }
    /**
     * Add productMedia
     *
     * @param \AppBundle\Entity\ProductHasMedia $productMedia
     * @return Product
     */
    public function addProductMedia(\AppBundle\Entity\ProductHasMedia $productMedia)
    {
        $this->productMedia[] = $productMedia;
        return $this;
    }
    /**
     * Remove productMedia
     *
     * @param \AppBundle\Entity\ProductHasMedia $productMedia
     */
    public function removeProductMedia(\AppBundle\Entity\ProductHasMedia $productMedia)
    {
        $this->productMedia->removeElement($productMedia);
    }
    /**
     * Get productMedia
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductMedia()
    {
        return $this->productMedia;
    }
    /**
     * Set productMedia
     *
     * @param array
     * @return Product
     */
    public function setProductMedia($media)
    {
        $this->productMedia = new ArrayCollection();
        foreach ($media as $m) {
            $m->setProduct($this);
            $this->addProductMedia($m);
        }
        return $this;
    }
}
