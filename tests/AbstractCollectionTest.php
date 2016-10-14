<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection\Test;

use PHPUnit_Framework_TestCase;
use stdClass;
use Tebru\Collection\ArrayList;
use Tebru\Collection\Bag;
use Tebru\Collection\CollectionInterface;
use Tebru\Collection\HashSet;

/**
 * Class AbstractCollectionTest
 *
 * @author Nate Brunette <n@tebru.net>
 *
 * @covers \Tebru\Collection\AbstractCollection
 */
class AbstractCollectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testAddAll(CollectionInterface $collection)
    {
        $collection->addAll(new ArrayList([0, 1, 2]));

        self::assertCount(3, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testContainsAll(CollectionInterface $collection)
    {
        $collection->addAll(new ArrayList([0, 1, 2]));

        self::assertTrue($collection->containsAll(new ArrayList([0, 1, 2])));
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testContainsAllFalse(CollectionInterface $collection)
    {
        $collection->addAll(new ArrayList([0, 1, 2]));

        self::assertFalse($collection->containsAll(new ArrayList([0, 1, 2, 3])));
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testIsEmpty(CollectionInterface $collection)
    {
        self::assertTrue($collection->isEmpty());
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testIsEmptyFalse(CollectionInterface $collection)
    {
        $collection->add(1);
        self::assertFalse($collection->isEmpty());
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRemoveAll(CollectionInterface $collection)
    {
        $collection->addAll(new ArrayList([0, 1, 2]));
        $collection->removeAll(new ArrayList([1]));

        self::assertSame([0, 2], $collection->toArray());
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRemoveEveryElement(CollectionInterface $collection)
    {
        $collection->addAll(new ArrayList([0, 1, 2]));
        $collection->removeAll(new ArrayList([0, 1, 2]));

        self::assertCount(0, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRemoveEveryElementExcess(CollectionInterface $collection)
    {
        $collection->addAll(new ArrayList([0, 1, 2]));
        $collection->removeAll(new ArrayList([0, 1, 2, 3]));

        self::assertCount(0, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRetainAll(CollectionInterface $collection)
    {
        $collection->addAll(new ArrayList([0, 1, 2]));
        $collection->retainAll(new ArrayList([0]));

        self::assertCount(1, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRetainEveryElement(CollectionInterface $collection)
    {
        $collection->addAll(new ArrayList([0, 1, 2]));
        $collection->retainAll(new ArrayList([0, 1, 2]));

        self::assertCount(3, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRetainEveryElementExcess(CollectionInterface $collection)
    {
        $collection->addAll(new ArrayList([0, 1, 2]));
        $collection->retainAll(new ArrayList([0, 1, 2, 3]));

        self::assertCount(3, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testExists(CollectionInterface $collection)
    {
        $object1 = new stdClass();
        $object1->foo = 1;

        $object2 = new stdClass();
        $object2->foo = 2;

        $object3 = new stdClass();
        $object3->foo = 3;

        $collection->addAll(new ArrayList([$object1, $object2, $object3]));

        self::assertTrue($collection->exists(function (stdClass $class) {
            return 2 === $class->foo;
        }));

        self::assertFalse($collection->exists(function (stdClass $class) {
            return 4 === $class->foo;
        }));
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
