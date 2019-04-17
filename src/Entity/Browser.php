<?php

namespace BenTools\DeviceDetectorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Browser
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var BrowserFamily
     *
     * @ORM\ManyToOne(targetEntity="BenTools\DeviceDetectorBundle\Entity\BrowserFamily", cascade={"all"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $family;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $label;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $mobileOnly;

    /**
     * Browser constructor.
     * @param string             $id
     * @param string             $label
     * @param null|BrowserFamily $family
     * @param bool               $mobileOnly
     */
    public function __construct(string $id, string $label, ?BrowserFamily $family, bool $mobileOnly)
    {
        $this->id = $id;
        $this->label = $label;
        $this->family = $family;
        $this->mobileOnly = $mobileOnly;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return BrowserFamily
     */
    public function getFamily(): ?BrowserFamily
    {
        return $this->family;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return bool
     */
    public function isMobileOnly(): bool
    {
        return $this->mobileOnly;
    }
}
