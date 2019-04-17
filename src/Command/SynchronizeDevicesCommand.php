<?php

namespace BenTools\DeviceDetectorBundle\Command;

use BenTools\DeviceDetectorBundle\Entity\Browser;
use BenTools\DeviceDetectorBundle\Entity\BrowserFamily;
use BenTools\DeviceDetectorBundle\Entity\DeviceBrand;
use BenTools\DeviceDetectorBundle\Entity\DeviceType;
use BenTools\DeviceDetectorBundle\Entity\Os;
use BenTools\DeviceDetectorBundle\Entity\OsFamily;
use BenTools\DeviceDetectorBundle\Services\BrowserManager;
use BenTools\DeviceDetectorBundle\Services\DeviceBrandsManager;
use BenTools\DeviceDetectorBundle\Services\DeviceOSManager;
use BenTools\DeviceDetectorBundle\Services\DeviceTypesManager;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SynchronizeDevicesCommand extends Command
{

    protected static $defaultName = 'device-detector:synchronize-devices';

    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * @var DeviceTypesManager
     */
    private $deviceTypesManager;

    /**
     * @var DeviceOSManager
     */
    private $deviceOSManager;

    /**
     * @var DeviceBrandsManager
     */
    private $deviceBrandsManager;

    /**
     * @var BrowserManager
     */
    private $browserManager;

    /**
     * @inheritDoc
     */
    public function __construct(
        ManagerRegistry $managerRegistry,
        DeviceTypesManager $deviceTypesManager,
        DeviceOSManager $deviceOSManager,
        DeviceBrandsManager $deviceBrandsManager,
        BrowserManager $browserManager
    ) {
        parent::__construct();
        $this->managerRegistry = $managerRegistry;
        $this->deviceTypesManager = $deviceTypesManager;
        $this->deviceOSManager = $deviceOSManager;
        $this->deviceBrandsManager = $deviceBrandsManager;
        $this->browserManager = $browserManager;
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->synchronizeDeviceTypes();
        $this->synchronizeOSFamilies();
        $this->synchronizeOperatingSystems();
        $this->synchronizeDeviceBrands();
        $this->synchronizeBrowserFamilies();
        $this->synchronizeBrowsers();
    }

    private function synchronizeDeviceTypes(): void
    {
        $class = DeviceType::class;
        $em = $this->managerRegistry->getManagerForClass($class);
        $objects = $this->deviceTypesManager->getDeviceTypes();
        foreach ($objects as $id => $value) {
            $entity = $em->find($class, $id);
            if (null === $entity) {
                $entity = new $class($id, ucwords($value));
                $em->persist($entity);
            }
        }

        $em->flush();
    }

    private function synchronizeOSFamilies(): void
    {
        $class = OsFamily::class;
        $em = $this->managerRegistry->getManagerForClass($class);
        $objects = $this->deviceOSManager->getOsFamilies();

        foreach ($objects as $id => $value) {
            $entity = $em->find($class, $id);
            if (null === $entity) {
                $entity = new $class($id, $value['label']);
                $em->persist($entity);
            }
        }

        $em->flush();
    }

    private function synchronizeOperatingSystems(): void
    {
        $class = Os::class;
        $em = $this->managerRegistry->getManagerForClass($class);
        $objects = $this->deviceOSManager->getOperatingSystems();

        foreach ($objects as $id => $value) {
            $entity = $em->find($class, $id);
            if (null === $entity) {
                $family = $em->find(OsFamily::class, $value['family']);
                $entity = new $class($id, $value['label'], $family);
                $em->persist($entity);
            }
        }

        $em->flush();
    }

    private function synchronizeDeviceBrands(): void
    {
        $class = DeviceBrand::class;
        $em = $this->managerRegistry->getManagerForClass($class);
        $objects = $this->deviceBrandsManager->getBrands();

        foreach ($objects as $id => $value) {
            $entity = $em->find($class, $id);
            if (null === $entity) {
                $entity = new $class($id, $value);
                $em->persist($entity);
            }
        }

        $em->flush();
    }

    private function synchronizeBrowserFamilies(): void
    {
        $class = BrowserFamily::class;
        $em = $this->managerRegistry->getManagerForClass($class);
        $objects = $this->browserManager->getBrowserFamilies();

        foreach ($objects as $id => $value) {
            $entity = $em->find($class, $id);
            if (null === $entity) {
                $entity = new $class($id, $value['label']);
                $em->persist($entity);
            }
        }

        $em->flush();
    }



    private function synchronizeBrowsers(): void
    {
        $class = Browser::class;
        $em = $this->managerRegistry->getManagerForClass($class);
        $objects = $this->browserManager->getBrowsers();

        foreach ($objects as $id => $value) {
            $entity = $em->find($class, $id);
            if (null === $entity) {
                if (null !== $value['family']) {
                    $family = $em->find(BrowserFamily::class, $this->browserManager->getFamilyId($value['family']));
                }
                $entity = new $class($id, $value['label'], $family ?? null, $value['mobile_only']);
                $em->persist($entity);
            }
        }

        $em->flush();
    }
}
