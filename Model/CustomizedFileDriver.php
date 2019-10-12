<?php

namespace JohnRogar\MageSymlink\Model;

use Magento\Framework\Filesystem\Driver\File;

/**
 * Class CustomizedFileDriver
 * @package JohnRogar\MageSymlink\Model
 */
class CustomizedFileDriver extends File
{

    /**
     * @param string $basePath
     * @param string $path
     * @param string|null $scheme
     * @return string
     */
    public function getAbsolutePath($basePath, $path, $scheme = null)
    {
        if (strlen($path) > 0 && $path[0] === '/' && file_exists($path)) {
            return $path;
        }

        if (0 === strpos($path, $basePath)) {
            return $this->getScheme($scheme) . $path;
        }

        return $this->getScheme($scheme) . $basePath . ltrim($this->fixSeparator($path), '/');
    }
}
