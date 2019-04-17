<?php

namespace BenTools\DeviceDetectorBundle\Services;

use Closure;
use DeviceDetector\Parser\Client\Browser;
use function BenTools\Violin\string as s;

class BrowserManager
{
    /**
     * @var Browser
     */
    private $parser;

    private $browserFamilies = [];

    private $browsers = [];

    /**
     * DeviceOSManager constructor.
     * @param Browser $parser
     */
    public function __construct(Browser $parser)
    {
        $this->parser = $parser;
        $this->init();
    }

    /**
     * @param string $browserId
     * @return null|string
     */
    public function getFamilyId(string $browserId)
    {
        return $this->browsers[$browserId]['family'] ?? $browserId;
    }

    /**
     * @param string $familyId
     * @return string
     */
    public function getFamilyLabel(string $familyId): string
    {
        return $this->browserFamilies[$familyId]['label'] ?? $familyId;
    }

    /**
     * @param string $browserId
     * @return string
     */
    public function getBrowserLabel(string $browserId): string
    {
        return $this->browsers[$browserId]['label'] ?? '';
    }

    private function init()
    {
        $this->browserFamilies = (Closure::bind(function (Browser $parser) {
            $browserFamilies = $parser::$browserFamilies;
            $output = [];
            foreach ($browserFamilies as $label => $browsers) {
                $id = (string) s($label)->slugify('-');
                $output[$id] = [
                    'id'       => $id,
                    'label'    => $label,
                    'browsers' => $browsers,
                ];
            }
            return $output;
        }, null, $this->parser))($this->parser);

        $this->browsers = (Closure::bind(function (Browser $parser, array $browsersFamilies) {
            $availableBrowsers = $parser::$availableBrowsers;
            $mobileOnlyBrowsers = $parser::$mobileOnlyBrowsers;
            foreach ($availableBrowsers as $id => $label) {
                $availableBrowsers[$id] = [
                    'id'          => $id,
                    'label'       => $label,
                    'mobile_only' => in_array($id, $mobileOnlyBrowsers),
                    'family'      => null,
                ];
                foreach ($browsersFamilies as $family) {
                    if (in_array($id, $family['browsers'])) {
                        $availableBrowsers[$id]['family'] = $family['id'];
                    }
                }
            }
            return $availableBrowsers;
        }, null, $this->parser))($this->parser, $this->browserFamilies);
    }

    /**
     * @return array
     */
    public function getBrowserFamilies(): array
    {
        return $this->browserFamilies;
    }

    /**
     * @return array
     */
    public function getBrowsers(): array
    {
        return $this->browsers;
    }
}
