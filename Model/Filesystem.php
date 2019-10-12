<?php

namespace JohnRogar\MageSymlink\Model;

use Magento\Framework\Filesystem\DirectoryList;

/**
 * Class Filesystem
 * @package JohnRogar\MageSymlink\Model
 */
class Filesystem extends \Magento\Framework\Filesystem
{

    /**
     * Filesystem constructor.
     * @param DirectoryList $directoryList
     * @param ReadFactory $readFactory
     * @param WriteFactory $writeFactory
     */
    public function __construct(
        DirectoryList $directoryList,
        ReadFactory $readFactory,
        WriteFactory $writeFactory
    ) {
        $this->directoryList = $directoryList;
        $this->readFactory = $readFactory;
        $this->writeFactory = $writeFactory;
    }
}
