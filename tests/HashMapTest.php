<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection\Test;

use PHPUnit_Framework_TestCase;
use Tebru\Collection\HashMap;

/**
 * Class HashMapTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class HashMapTest extends PHPUnit_Framework_TestCase
{
    public function testConstructWithArguments()
    {
        $map = new HashMap(['key' => 'value']);

        self::assertSame('value', $map->get('key'));
    }
}
