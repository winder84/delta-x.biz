<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Model\MediaInterface;

/**
 * MainSlider
 *
 * @ORM\Table(name="main_slider")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MainSliderRepository")
 */
class MainSlider
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
     * @ORM\Column(name="mainSliderText", type="text", nullable=true)
     */
    private $mainSliderText;

    /**
     * @var string
     *
     * @ORM\Column(name="mainSliderUrl", type="string", nullable=true)
     */
    private $mainSliderUrl;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"}, fetch="LAZY")
     */
    protected $media;

    /**
     * @param MediaInterface $media
     */
    public function setMedia(MediaInterface $media)
    {
        $this->media = $media;
    }

    /**
     * @return MediaInterface
     */
    public function getMedia()
    {
        return $this->media;
    }

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
     * Set mainSliderText
     *
     * @param string $mainSliderText
     *
     * @return MainSlider
     */
    public function setMainSliderText($mainSliderText)
    {
        $this->mainSliderText = $mainSliderText;

        return $this;
    }

    /**
     * Get mainSliderText
     *
     * @return string
     */
    public function getMainSliderText()
    {
        return $this->mainSliderText;
    }

    /**
     * Set mainSliderUrl
     *
     * @param string $mainSliderUrl
     *
     * @return MainSlider
     */
    public function setMainSliderUrl($mainSliderUrl)
    {
        $this->mainSliderUrl = $mainSliderUrl;

        return $this;
    }

    /**
     * Get mainSliderUrl
     *
     * @return string
     */
    public function getMainSliderUrl()
    {
        return $this->mainSliderUrl;
    }
}
