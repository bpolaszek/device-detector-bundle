<?php

namespace BenTools\DeviceDetectorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class DeviceModel
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="\BenTools\ULIDGenerator")
     * @ORM\Column(type="string", length=26)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var DeviceType|null
     *
     * @ORM\ManyToOne(targetEntity="BenTools\DeviceDetectorBundle\Entity\DeviceType")
     * @ORM\JoinColumn(nullable=true)
     */
    private $deviceType;

    /**
     * @var DeviceBrand|null
     *
     * @ORM\ManyToOne(targetEntity="BenTools\DeviceDetectorBundle\Entity\DeviceBrand")
     * @ORM\JoinColumn(nullable=true)
     */
    private $deviceBrand;

    /**
     * @var OsFamily|null
     *
     * @ORM\ManyToOne(targetEntity="BenTools\DeviceDetectorBundle\Entity\OsFamily")
     * @ORM\JoinColumn(nullable=true)
     */
    private $osFamily;

    /**
     * DeviceModel constructor.
     * @param string $id
     * @param string $name
     * @param null|DeviceType $deviceType
     * @param null|DeviceBrand $deviceBrand
     */
    public function __construct(string $id, string $name, ?DeviceType $deviceType, ?DeviceBrand $deviceBrand, ?OsFamily $osFamily)
    {
        $this->id = $id;
        $this->name = $name;
        $this->deviceType = $deviceType;
        $this->deviceBrand = $deviceBrand;
        $this->osFamily = $osFamily;
    }

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return DeviceType
     */
    public function getDeviceType(): ?DeviceType
    {
        return $this->deviceType;
    }

    /**
     * @param DeviceType $deviceType
     */
    public function setDeviceType(DeviceType $deviceType): void
    {
        $this->deviceType = $deviceType;
    }

    /**
     * @return DeviceBrand
     */
    public function getDeviceBrand(): ?DeviceBrand
    {
        return $this->deviceBrand;
    }

    /**
     * @param DeviceBrand $deviceBrand
     */
    public function setDeviceBrand(DeviceBrand $deviceBrand): void
    {
        $this->deviceBrand = $deviceBrand;
    }

    /**
     * @return null|OsFamily
     */
    public function getOsFamily(): ?OsFamily
    {
        return $this->osFamily;
    }

    /**
     * @param null|OsFamily $osFamily
     */
    public function setOsFamily(?OsFamily $osFamily): void
    {
        $this->osFamily = $osFamily;
    }
}
