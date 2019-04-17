<?php

namespace BenTools\DeviceDetectorBundle\Services;

use Closure;
use DeviceDetector\Parser\Device\Mobile;

class DeviceTypesManager
{
    /**
     * @var array
     */
    private $deviceTypes;

    /**
     * @var Mobile
     */
    private $parser;

    /**
     * DeviceTypeProvider constructor.
     */
    public function __construct(Mobile $parser)
    {
        $this->parser = $parser;
        $this->init();
    }

    private function init()
    {
        $this->deviceTypes = (Closure::bind(function (Mobile $parser) {
            return array_flip($parser::$deviceTypes);
        }, null, $this->parser))($this->parser);
    }

    /**
     * @return array
     */
    public function getDeviceTypes(): array
    {
        return $this->deviceTypes;
    }

    /**
     * @param int $id
     * @return null|string
     */
    public function getDeviceType(int $id): ?string
    {
        return $this->deviceTypes[$id] ?? null;
    }

    /**
     * @param int $id
     * @return string
     */
    public function getLabel(int $id): string
    {
        if (!isset($this->deviceTypes[$id])) {
            throw new \InvalidArgumentException(sprintf('Device type %s not found', $id));
        }
        return ucwords($this->deviceTypes[$id]);
    }
}
