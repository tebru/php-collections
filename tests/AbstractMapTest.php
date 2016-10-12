<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection\Test;

use PHPUnit_Framework_TestCase;
use Tebru\Collection\HashMap;
use Tebru\Collection\MapEntry;
use Tebru\Collection\MapInterface;

/**
 * Class AbstractMapTest
 *
 * @author Nate Brunette <n@tebru.net>
 *
 * @covers \Tebru\Collection\AbstractMap
 * @covers \Tebru\Collection\MapEntry
 */
class AbstractMapTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testPutAll(MapInterface $map)
    {
        $classKey = new \stdClass();
        $hashMap = new HashMap();
        $hashMap->put($classKey, true);
        $hashMap->put('key', false);
        $map->putAll($hashMap);

        list($mapEntry1, $mapEntry2) = $map->entrySet()->toArray();

        self::assertInstanceOf(MapEntry::class, $mapEntry1);
        self::assertSame($classKey, $mapEntry1->key);
        self::assertTrue($mapEntry1->value);

        self::assertSame('key', $mapEntry2->key);
        self::assertFalse($mapEntry2->value);
    }

    public function getMaps()
    {
        return [
            [new HashMap()],
        ];
    }
}
