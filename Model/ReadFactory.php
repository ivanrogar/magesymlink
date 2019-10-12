<?php

namespace JohnRogar\MageSymlink\Model;

use Magento\Framework\Filesystem\Directory\ReadInterface;
use Magento\Framework\Filesystem\Directory\Read;
use Magento\Framework\Filesystem\DriverPool;

/**
 * Class ReadFactory
 * @package JohnRogar\MageSymlink\Model
 */
class ReadFactory
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
     * Create a readable directory
     *
     * @param string $path
     * @param string $driverCode
     * @return ReadInterface
     */
    public function create($path, $driverCode = DriverPool::FILE)
    {
        $driver = $this->driverPool->getDriver($driverCode);
        $factory = new \Magento\Framework\Filesystem\File\ReadFactory(
            $this->driverPool
        );

        return new Read(
            $factory,
            $driver,
            $path,
            new CustomPathValidator($driver)
        );
    }
}
