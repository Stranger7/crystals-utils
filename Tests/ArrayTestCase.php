<?php

namespace Crystals\Utils\Tests;

use Crystals\Utils\Arr;

class ArrayTestCase extends \PHPUnit_Framework_TestCase
{
    public function testArray()
    {
        $array = [
            [],
            null,
            '',
            0,
            [1, 2, 3]
        ];
        foreach ($array as $item) {
            $this->assertTrue(is_array(Arr::cast($item)));
        }
    }
}
