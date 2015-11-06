<?php
/**
 * (c) Sergey Novikov (novikov.stranger@gmail.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Crystals\Utils;

/**
 * Class Arr
 * @package Crystals\Utils
 */
class Arr
{
    /**
     * Cast variable to array.
     * Any empty value is converted to an empty array
     *
     * @param mixed $var
     * @return array
     */
    public static function cast($var)
    {
        if (!is_array($var)) {
            $var = (empty($var) ? [] : (array) $var);
        }

        return $var;
    }

    /**
     * Convert indexed or mixed array to associative array:
     * ['a', 'b' => 'c', 'd']
     * convert to:
     * ['a' => [], 'b' => 'c', 'd' => []]
     *
     * @param array $array
     * @param mixed $default
     * @return array
     */
    public static function convertToAssoc(array $array, $default = [])
    {
        $index = 0;
        $result = [];
        foreach ($array as $key => $value) {
            if ($key === $index) {
                $result[$value] = $default;
                $index++;
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
