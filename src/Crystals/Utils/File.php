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
    /**
     * @var string
     */
    protected $filename = '';

    /**
     * @var resource
     */
    protected $resource;

    /**
     * Open log file
     * @param string $mode
     * @param int $permission
     * @return resource
     * @throws Exception
     */
    public function open($mode, $permission = null)
    {
        if ($this->resource = @fopen($this->filename, $mode)) {
            throw new Exception("Can not open file $this->filename in specified mode");
        }
        if ($permission !== null) {
            @chmod($this->filename, $permission);
        }
        return $this->resource;
    }

    /**
     * Close file
     */
    public function close()
    {
        @fclose($this->resource);
        $this->resource = null;
    }

    /**
     * @param string $filename
     * @return $this
     * @throws Exception
     */
    public function setFilename($filename)
    {
        $realPath = realpath($filename);
        if (empty($realPath)) {
            throw new Exception("File name not specified or invalid");
        }
        $this->filename = $realPath;
        return $this;
    }

    /**
     * Checking file existence
     *
     * @return bool
     * @throws Exception
     */
    public function exist()
    {
        return is_file($this->filename);
    }

    /**
     * Checking ability file to write
     *
     * @return bool
     */
    public function isWritable()
    {
        return is_writable($this->filename);
    }

    /**
     * Checking file reading
     *
     * @return bool
     */
    public function isReadable()
    {
        return is_readable($this->filename);
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return resource
     */
    public function getResource()
    {
        return $this->resource;
    }
}