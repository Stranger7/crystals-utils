<?php
/**
 * (c) Sergey Novikov (novikov.stranger@gmail.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Crystals\Utils;

/**
 * Class Php
 * @package Crystals\Utils
 */
class Php
{
    /**
     * This function has been copied from the framework "CodeIgniter v.3"
     *
     * Determines if the current version of PHP is greater then the supplied value
     *
     * @param	string
     * @return	bool	TRUE if the current version is $version or higher
     */
    public static function requiredVersion($version)
    {
        static $isPhp;
        $version = (string) $version;

        if (!isset($isPhp[$version])) {
            $isPhp[$version] = version_compare(PHP_VERSION, $version, '>=');
        }

        return $isPhp[$version];
    }
}
