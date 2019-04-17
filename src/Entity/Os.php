<?php

namespace BenTools\DeviceDetectorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Os
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=3)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var OsFamily
     *
     * @ORM\ManyToOne(targetEntity="BenTools\DeviceDetectorBundle\Entity\OsFamily", cascade={"all"})
     */
    private $family;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $label;

    /**
     * Os constructor.
     * @param string   $id
     * @param string   $label
     * @param OsFamily $family
     */
    public function __construct(string $id, string $label, OsFamily $family)
    {
        $this->id = $id;
        $this->label = $label;
        $this->family = $family;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return OsFamily
     */
    public function getFamily(): ?OsFamily
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
}
