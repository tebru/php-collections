<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection\Test;

use PHPUnit_Framework_TestCase;
use Tebru\Collection\ArrayList;
use Tebru\Collection\Bag;
use Tebru\Collection\CollectionInterface;
use Tebru\Collection\HashSet;

/**
 * Class CollectionImplementationTest
 *
 * @author Nate Brunette <n@tebru.net>
 *
 * @covers \Tebru\Collection\ArrayList
 * @covers \Tebru\Collection\Bag
 * @covers \Tebru\Collection\HashSet
 */
class CollectionImplementationTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testAdd(CollectionInterface $collection)
    {
        self::assertTrue($collection->add(1));
        self::assertSame(1, $collection->toArray()[0]);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRemove(CollectionInterface $collection)
    {
        $collection->add(1);

        self::assertTrue($collection->remove(1));
        self::assertCount(0, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRemoveFuzzy(CollectionInterface $collection)
    {
        $collection->add(1);

        self::assertTrue($collection->remove(true, false));
        self::assertCount(0, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRemoveNotFound(CollectionInterface $collection)
    {
        $collection->add(1);

        self::assertFalse($collection->remove(true));
        self::assertCount(1, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testClear(CollectionInterface $collection)
    {
        $collection->addAll(new ArrayList([1, 2, 3]));
        $collection->clear();

        self::assertCount(0, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testCount(CollectionInterface $collection)
    {
        $collection->addAll(new ArrayList([1, 2, 3]));

        self::assertSame(3, $collection->count());
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testContains(CollectionInterface $collection)
    {
        $collection->add(1);

        self::assertTrue($collection->contains(1));
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testContainsFuzzy(CollectionInterface $collection)
    {
        $collection->add(1);

        self::assertTrue($collection->contains(true, false));
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testNotContains(CollectionInterface $collection)
    {
        $collection->add(1);

        self::assertFalse($collection->contains(true));
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testToArray(CollectionInterface $collection)
    {
        $collection->add(1);

        self::assertSame([1], $collection->toArray());
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testGetIterator(CollectionInterface $collection)
    {
        $collection->addAll(new ArrayList([0, 1, 2]));

        $count = 0;
        foreach ($collection as $element) {
            $count++;
        }

        self::assertSame(3, $count);
    }

    public function getCollections()
    {
        return [
            [new ArrayList()],
            [new Bag()],
            [new HashSet()],
        ];
    }
}
