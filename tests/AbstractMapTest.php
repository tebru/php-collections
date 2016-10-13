<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection\Test;

use PHPUnit_Framework_TestCase;
use stdClass;
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

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testExists(MapInterface $map)
    {
        $object1 = new stdClass();
        $object1->foo = 1;

        $object2 = new stdClass();
        $object2->foo = 2;

        $object3 = new stdClass();
        $object3->foo = 3;

        $map->put($object1, true);
        $map->put($object2, true);
        $map->put($object3, true);

        self::assertTrue($map->exists(function (MapEntry $mapEntry) {
            return 2 === $mapEntry->key->foo;
        }));

        self::assertFalse($map->exists(function (MapEntry $mapEntry) {
            return 4 === $mapEntry->key->foo;
        }));
    }

    public function getMaps()
    {
        return [
            [new HashMap()],
        ];
    }
}
