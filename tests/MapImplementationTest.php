<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection\Test;

use OutOfRangeException;
use PHPUnit_Framework_TestCase;
use Tebru\Collection\ArrayList;
use Tebru\Collection\HashMap;
use Tebru\Collection\HashSet;
use Tebru\Collection\MapEntry;
use Tebru\Collection\MapInterface;

/**
 * Class MapImplementationTest
 *
 * @author Nate Brunette <n@tebru.net>
 *
 * @covers \Tebru\Collection\HashMap
 * @covers \Tebru\Collection\MapEntry
 */
class MapImplementationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testClear(MapInterface $map)
    {
        $map->put('key', 'value');
        $map->clear();

        self::assertCount(0, $map);
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testContainsKey(MapInterface $map)
    {
        $map->put('key', 'value');

        self::assertTrue($map->containsKey('key'));
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testContainsKeyFalse(MapInterface $map)
    {
        $map->put('key', 'value');

        self::assertFalse($map->containsKey('key2'));
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testContainsKeyFuzzy(MapInterface $map)
    {
        $map->put(1, 'value');

        self::assertTrue($map->containsKey(true, false));
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testContainsValue(MapInterface $map)
    {
        $map->put('key', 'value');

        self::assertTrue($map->containsValue('value'));
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testContainsValueFalse(MapInterface $map)
    {
        $map->put('key', 'value');

        self::assertFalse($map->containsValue('value2'));
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testContainsFuzzy(MapInterface $map)
    {
        $map->put('key', 1);

        self::assertTrue($map->containsValue(true, false));
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testEntrySet(MapInterface $map)
    {
        $map->put('key', 'value');
        $map->put('key2', 'value2');

        list($mapEntry, $mapEntry2) = $map->entrySet()->toArray();

        self::assertInstanceOf(MapEntry::class, $mapEntry);
        self::assertSame('key', $mapEntry->key);
        self::assertSame('value', $mapEntry->value);

        self::assertInstanceOf(MapEntry::class, $mapEntry2);
        self::assertSame('key2', $mapEntry2->key);
        self::assertSame('value2', $mapEntry2->value);
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testEntrySetProvided(MapInterface $map)
    {
        $hashSet = new HashSet();
        $hashSet->add(1);
        $map->put('key', 'value');
        $mapEntry = $map->entrySet($hashSet)->toArray()[1];

        self::assertInstanceOf(MapEntry::class, $mapEntry);
        self::assertSame('key', $mapEntry->key);
        self::assertSame('value', $mapEntry->value);
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testGet(MapInterface $map)
    {
        $map->put('key', 'value');

        self::assertSame('value', $map->get('key'));
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testGetFuzzy(MapInterface $map)
    {
        $map->put(1, 'value');

        self::assertSame('value', $map->get(true, false));
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testGetException(MapInterface $map)
    {
        $this->expectException(OutOfRangeException::class);

        $map->put('key', 'value');
        $map->get('key2');
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testIsEmpty(MapInterface $map)
    {
        self::assertTrue($map->isEmpty());
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testIsEmptyFalse(MapInterface $map)
    {
        $map->put('key', 'value');

        self::assertFalse($map->isEmpty());
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testKeySet(MapInterface $map)
    {
        $map->put('key', 'value');

        self::assertSame(['key'], $map->keySet()->toArray());
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testKeySetProvided(MapInterface $map)
    {
        $hashSet = new HashSet();
        $hashSet->add(1);
        $map->put('key', 'value');

        self::assertSame([1, 'key'], $map->keySet($hashSet)->toArray());
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testPutObject(MapInterface $map)
    {
        $class = new \stdClass();
        $map->put($class, 'value');

        $mapEntry = $map->entrySet()->toArray()[0];

        self::assertSame($class, $mapEntry->key);
        self::assertSame('value', $mapEntry->value);
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testPutObjectFuzzy(MapInterface $map)
    {
        $class = new \stdClass();
        $class2 = new \stdClass();
        $map->put($class, 'value');
        $oldValue = $map->put($class2, 'value2', false);

        $mapEntry = $map->entrySet()->toArray()[0];

        self::assertSame('value', $oldValue);
        self::assertSame($class2, $mapEntry->key);
        self::assertSame('value2', $mapEntry->value);
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testPutOverride(MapInterface $map)
    {
        $map->put('key', 'value');
        $oldValue = $map->put('key', 'value2');

        self::assertSame('value2', $map->get('key'));
        self::assertSame('value', $oldValue);
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testRemove(MapInterface $map)
    {
        $map->put('key', 'value');
        $map->remove('key');

        self::assertCount(0, $map);
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testRemoveFuzzy(MapInterface $map)
    {
        $map->put(1, 'value');
        $map->remove(true, false);

        self::assertCount(0, $map);
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testRemoveException(MapInterface $map)
    {
        $map->put('key', 'value');
        self::assertFalse($map->remove('key2'));
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testKeys(MapInterface $map)
    {
        $map->put('key', 'value');
        $map->put('key2', 'value2');

        self::assertSame(['key', 'key2'], $map->keys()->toArray());
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testKeysProvided(MapInterface $map)
    {
        $arrayList = new ArrayList();
        $arrayList->add(1);
        $map->put('key', 'value');
        $map->put('key2', 'value2');

        self::assertSame([1, 'key', 'key2'], $map->keys($arrayList)->toArray());
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testValues(MapInterface $map)
    {
        $map->put('key', 'value');
        $map->put('key2', 'value2');

        self::assertSame(['value', 'value2'], $map->values()->toArray());
    }

    /**
     * @dataProvider getMaps
     * @param MapInterface $map
     */
    public function testValuesProvided(MapInterface $map)
    {
        $arrayList = new ArrayList();
        $arrayList->add(1);
        $map->put('key', 'value');
        $map->put('key2', 'value2');

        self::assertSame([1, 'value', 'value2'], $map->values($arrayList)->toArray());
    }

    public function getMaps()
    {
        return [
            [new HashMap()],
        ];
    }
}
