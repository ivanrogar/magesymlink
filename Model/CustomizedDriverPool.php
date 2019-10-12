<?php

namespace JohnRogar\MageSymlink\Model;

use Magento\Framework\Filesystem\DriverPool;

/**
 * Class File
 * @package JohnRogar\MageSymlink\Model
 */
class CustomizedDriverPool extends DriverPool
{

    /**#@- */
    protected $types = [
        self::FILE => CustomizedFileDriver::class,
        self::HTTP => \Magento\Framework\Filesystem\Driver\Http::class,
        self::HTTPS => \Magento\Framework\Filesystem\Driver\Https::class,
        self::ZLIB => \Magento\Framework\Filesystem\Driver\Zlib::class,
    ];
}
