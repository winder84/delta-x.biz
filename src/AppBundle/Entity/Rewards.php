<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Rewards
 *
 * @ORM\Table(name="rewards")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RewardsRepository")
 */
class Rewards
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
     * @Assert\NotBlank()
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\RewardsHasMedia", mappedBy="rewards",cascade={"persist","remove"})
     * @ORM\JoinTable(name="rewards_galleries")
     */
    private $rewardsMedia;


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
     * @return Rewards
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
     * Add rewardsMedia
     *
     * @param \AppBundle\Entity\RewardsHasMedia $rewardsMedia
     *
     * @return Rewards
     */
    public function addRewardsMedia(\AppBundle\Entity\RewardsHasMedia $rewardsMedia)
    {
        $this->rewardsMedia[] = $rewardsMedia;

        return $this;
    }

    /**
     * Remove rewardsMedia
     *
     * @param \AppBundle\Entity\RewardsHasMedia $rewardsMedia
     */
    public function removeRewardsMedia(\AppBundle\Entity\RewardsHasMedia $rewardsMedia)
    {
        $this->rewardsMedia->removeElement($rewardsMedia);
    }

    /**
     * Get rewardsMedia
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRewardsMedia()
    {
        return $this->rewardsMedia;
    }

    /**
     * Set rewardsMedia
     *
     * @param array
     * @return Rewards
     */
    public function setRewardsMedia($media)
    {
        $this->rewardsMedia = new ArrayCollection();
        foreach ($media as $m) {
            $m->setRewards($this);
            $this->addRewardsMedia($m);
        }
        return $this;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rewardsMedia = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
