<?php

namespace JohnRogar\MageSymlink\Model;

use Magento\Framework\Filesystem\DriverPool;
use Magento\Framework\Filesystem\Directory\Write;

/**
 * Class WriteFactory
 * @package JohnRogar\MageSymlink\Model
 */
class WriteFactory
{
    /**
     * Pool of filesystem drivers
     *
     * @var DriverPool
     */
    private $driverPool;

    /**
     * Constructor
     *
     * @param DriverPool $driverPool
     */
    public function __construct(DriverPool $driverPool)
    {
        $this->driverPool = $driverPool;
    }

    /**
     * Create a writable directory
     *
     * @param string $path
     * @param string $driverCode
     * @param int $createPermissions
     * @return \Magento\Framework\Filesystem\Directory\Write
     */
    public function create($path, $driverCode = DriverPool::FILE, $createPermissions = null)
    {
        $driver = $this->driverPool->getDriver($driverCode);
        $factory = new \Magento\Framework\Filesystem\File\WriteFactory(
            $this->driverPool
        );

        return new Write(
            $factory,
            $driver,
            $path,
            $createPermissions,
            new CustomPathValidator($driver)
        );
    }
}
