<?php

declare(strict_types=1);

namespace JohnRogar\MageSymlink\Model;

use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Filesystem\Directory\PathValidatorInterface;
use Magento\Framework\Phrase;
use Magento\Framework\Filesystem\DriverInterface;
use Dotenv\Dotenv;

/**
 * Class CustomPathValidator
 * @package JohnRogar\MageSymlink\Model
 */
class CustomPathValidator implements PathValidatorInterface
{

    /**
     * @var DriverInterface
     */
    private $driver;

    private $dotEnv;

    private $paths;

    /**
     * @param DriverInterface $driver
     */
    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;

        $this->dotEnv = new Dotenv(BP);
        $this->dotEnv->load();

        $this->paths = explode(',', getenv('MAGESYMLINK_ALLOWED_PATHS'));
    }

    /**
     * @inheritDoc
     * @SuppressWarnings(BooleanArgumentFlag)
     * @SuppressWarnings(ElseExpression)
     */
    public function validate(
        string $directoryPath,
        string $path,
        ?string $scheme = null,
        bool $absolutePath = false
    ): void {
        $realDirectoryPath = $this->driver->getRealPathSafety($directoryPath);
        if ($realDirectoryPath[-1] !== DIRECTORY_SEPARATOR) {
            $realDirectoryPath .= DIRECTORY_SEPARATOR;
        }
        if (!$absolutePath) {
            $actualPath = $this->driver->getRealPathSafety(
                $this->driver->getAbsolutePath(
                    $realDirectoryPath,
                    $path,
                    $scheme
                )
            );
        } else {
            $actualPath = $this->driver->getRealPathSafety($path);
        }

        if (mb_strpos($actualPath, $realDirectoryPath) !== 0
            && $path .DIRECTORY_SEPARATOR !== $realDirectoryPath
        ) {
            if (!$this->validatePath($path)) {
                throw new ValidatorException(
                    new Phrase(
                        'Path "%1" cannot be used with directory "%2"',
                        [$path, $directoryPath]
                    )
                );
            }
        }
    }

    /**
     * @param $path
     * @return bool
     */
    private function validatePath($path)
    {
        foreach ($this->paths as $configPath) {
            if ($this->startsWith($path, $configPath)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $haystack
     * @param $needle
     * @return bool
     */
    private function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
}
