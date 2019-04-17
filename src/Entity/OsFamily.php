<?php

namespace BenTools\DeviceDetectorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class OsFamily
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $label;

    /**
     * OSFamily constructor.
     * @param string $id
     * @param string $label
     */
    public function __construct(string $id, string $label)
    {
        $this->id = $id;
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }
}
