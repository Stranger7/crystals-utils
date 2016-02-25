<?php
/**
 * (c) Sergey Novikov (novikov.stranger@gmail.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Crystals\Utils;

/**
 * Class Script
 * @package Crystals\Utils
 */
class Script
{
    const PHP_EXT = '.php';

    /**
     * @var string
     */
    private $directory;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $extension = self::PHP_EXT;

    /**
     * @var string
     */
    private $filename;

    /**
     * @param string $directory
     * @return Script
     */
    public function setDirectory($directory)
    {
        $this->clearFilename();
        $this->directory = $directory;
        return $this;
    }

    /**
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * @param string $name
     * @return Script
     */
    public function setName($name)
    {
        $this->clearFilename();
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $extension
     * @return Script
     */
    public function setExtension($extension)
    {
        $this->clearFilename();
        $this->extension = $extension;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Make filename
     *
     * @return string
     * @throws Exception
     */
    public function getFilename()
    {
        if (empty($this->filename)) {
            $this->makeFilename();
        }
        return $this->filename;
    }

    /**
     * @param bool|false $required
     * @param bool|true $once
     * @return bool|mixed
     * @throws Exception
     */
    public function load($required = false, $once = true)
    {
        $this->makeFilename();
        $readable = (new File())->setFilename($this->name)->isReadable();
        if ($required) {
            if (!$readable) {
                throw new Exception("Script {$this->filename} not found or not readable");
            }
            return ($once) ? require_once $this->filename : require $this->filename;
        } else {
            if (!$readable) {
                return false;
            }
            return ($once) ? include_once $this->filename : include $this->filename;
        }
    }

    protected function clearFilename()
    {
        $this->filename = '';
    }

    protected function makeFilename()
    {
        if (empty($this->name)) {
            throw new Exception('Name of file not specified');
        }
        $dir = !empty($this->directory) ? rtrim($this->directory, '\\/') . DIRECTORY_SEPARATOR : '';
        $ext = !empty($this->extension) ? '.' . ltrim($this->extension, '.') : '';
        $this->filename = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $dir . $this->name . $ext);
    }

    /**
     * This function has been copied from the framework "CodeIgniter v.3"
     *
     * Determines if the current version of PHP is greater then the supplied value
     *
     * @param	string
     * @return	bool	TRUE if the current version is $version or higher
     */
    public static function versionLeast($version)
    {
        static $isPhp;
        $version = (string) $version;

        if (!isset($isPhp[$version])) {
            $isPhp[$version] = version_compare(PHP_VERSION, $version, '>=');
        }

        return $isPhp[$version];
    }

    /**
     * Is CLI?
     * Test to see if a request was made from the command line.
     * @return 	bool
     */
    public static function isCli()
    {
        return php_sapi_name() == 'cli';
    }
}
