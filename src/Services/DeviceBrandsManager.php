<?php

namespace BenTools\DeviceDetectorBundle\Services;

use Closure;
use DeviceDetector\Parser\Device\Mobile;

class DeviceBrandsManager
{
    /**
     * @var array
     */
    private $brands;

    /**
     * @var Mobile
     */
    private $parser;

    /**
     * DeviceBrandsManager constructor.
     * @param Mobile $parser
     */
    public function __construct(Mobile $parser)
    {
        $this->parser = $parser;
        $this->getBrands();
    }

    /**
     * @param string $brandId
     * @return string
     */
    public function getBrandLabel(string $brandId): string
    {
        return $this->brands[$brandId] ?? $brandId;
    }

    /**
     * @return array
     */
    public function getBrands(): array
    {
        if (null === $this->brands) {
            $this->brands = (Closure::bind(function (Mobile $parser) {
                return $parser::$deviceBrands;
            }, null, $this->parser))($this->parser);
        }
        return $this->brands;
    }
}
