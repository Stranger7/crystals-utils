<?php
/**
 * (c) Sergey Novikov (novikov.stranger@gmail.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Crystals\Utils;

/**
 * Class File
 * @package Crystals\Utils
 */
class File
{
    const PHP_EXT = '.php';

    /**
     * @var string
     */
    private $dir;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $ext = self::PHP_EXT;

    /**
     * @var string
     */
    private $filename;

    /**
     * @param string $dir
     * @return File
     */
    public function setDir($dir)
    {
        $this->clearFilename();
        $this->dir = $dir;
        return $this;
    }

    /**
     * @return string
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * @param string $name
     * @return File
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
     * @param string $ext
     * @return File
     */
    public function setExt($ext)
    {
        $this->clearFilename();
        $this->ext = $ext;
        return $this;
    }

    /**
     * @return string
     */
    public function getExt()
    {
        return $this->ext;
    }

    /**
     * Make filename
     *
     * @return string
     * @throws FileException
     */
    public function getFilename()
    {
        if (empty($this->filename)) {
            $this->makeFilename();
        }
        return $this->filename;
    }

    /**
     * @return bool
     * @throws FileException
     */
    public function exist()
    {
        return is_file($this->getFilename());
    }

    /**
     * @return bool
     * @throws FileException
     */
    public function readable()
    {
        return is_readable($this->getFilename());
    }

    /**
     * @param bool|false $required
     * @param bool|true $once
     * @return bool|mixed
     * @throws FileException
     */
    public function load($required = false, $once = true)
    {
        $this->makeFilename();
        $readable = $this->readable();
        if ($required) {
            if (!$readable) {
                throw new FileException("File `{$this->filename}` not found or not readable");
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
            throw new FileException('Name of file not specified');
        }
        $dir = !empty($this->dir) ? rtrim($this->dir, '\\/') . DIRECTORY_SEPARATOR : '';
        $ext = !empty($this->ext) ? '.' . ltrim($this->ext, '.') : '';
        $this->filename = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $dir . $this->name . $ext);
    }
}
