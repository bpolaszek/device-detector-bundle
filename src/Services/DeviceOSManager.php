<?php

namespace BenTools\DeviceDetectorBundle\Services;

use Closure;
use DeviceDetector\Parser\OperatingSystem;
use function BenTools\Violin\string as s;

class DeviceOSManager
{
    /**
     * @var OperatingSystem
     */
    private $parser;

    private $osFamilies = [];

    private $operatingSystems = [];

    /**
     * DeviceOSManager constructor.
     * @param OperatingSystem $parser
     */
    public function __construct(OperatingSystem $parser)
    {
        $this->parser = $parser;
        $this->init();
    }

    /**
     * @param string $osId
     * @return null|string
     */
    public function getFamilyId(string $osId)
    {
        return $this->operatingSystems[$osId]['family'] ?? null;
    }

    /**
     * @param string $familyId
     * @return string
     */
    public function getFamilyLabel(string $familyId): string
    {
        return $this->osFamilies[$familyId]['label'] ?? $familyId;
    }

    /**
     * @param string $osId
     * @return string
     */
    public function getLabel(string $osId): string
    {
        return $this->operatingSystems[$osId]['label'] ?? $osId;
    }

    private function init()
    {
        $this->osFamilies = (Closure::bind(function (OperatingSystem $parser) {
            $osFamilies = $parser::$osFamilies;
            $output = [];
            foreach ($osFamilies as $label => $oses) {
                $id = (string) s($label)->slugify('-');
                $output[$id] = [
                    'id' => $id,
                    'label' => $label,
                    'oses'  => $oses,
                ];
            }
            return $output;
        }, null, $this->parser))($this->parser);

        $this->operatingSystems = (Closure::bind(function (OperatingSystem $parser, array $osFamilies) {
            $operatingSystems = $parser::$operatingSystems;
            foreach ($operatingSystems as $id => $label) {
                $operatingSystems[$id] = [
                    'label' => $label,
                ];
                foreach ($osFamilies as $family) {
                    if (in_array($id, $family['oses'])) {
                        $operatingSystems[$id]['family'] = $family['id'];
                    }
                }
            }
            return $operatingSystems;
        }, null, $this->parser))($this->parser, $this->osFamilies);
    }

    /**
     * @return array
     */
    public function getOsFamilies(): array
    {
        return $this->osFamilies;
    }

    /**
     * @return array
     */
    public function getOperatingSystems(): array
    {
        return $this->operatingSystems;
    }
}
