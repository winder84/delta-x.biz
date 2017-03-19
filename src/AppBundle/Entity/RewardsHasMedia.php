<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Table()
 * @ORM\Entity
 */
class RewardsHasMedia {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Rewards", inversedBy="rewardMedia", cascade={"persist","remove"}, fetch="LAZY")
     */
    protected $rewards;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinTable(name="rewards_gallery")
     */
    protected $media;

    public function __construct()
    {
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
     * Set gallery
     *
     * @param \Application\Sonata\MediaBundle\Entity\Gallery $gallery
     * @return RewardsHasMedia
     */
    public function setGallery(Gallery $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \Application\Sonata\MediaBundle\Entity\Gallery 
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set media
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $media
     * @return RewardsHasMedia
     */
    public function setMedia(\Application\Sonata\MediaBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media 
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set rewards
     *
     * @param \AppBundle\Entity\Rewards $rewards
     *
     * @return RewardsHasMedia
     */
    public function setRewards(\AppBundle\Entity\Rewards $rewards = null)
    {
        $this->rewards = $rewards;

        return $this;
    }

    /**
     * Get rewards
     *
     * @return \AppBundle\Entity\Rewards
     */
    public function getRewards()
    {
        return $this->rewards;
    }

    /**
     * Set rewards
     *
     * @param \AppBundle\Entity\Rewards $rewards
     *
     * @return RewardsHasMedia
     */
    public function setReward(\AppBundle\Entity\Rewards $rewards = null)
    {
        $this->rewards = $rewards;

        return $this;
    }

    /**
     * Get rewards
     *
     * @return \AppBundle\Entity\Rewards
     */
    public function getReward()
    {
        return $this->rewards;
    }
}
