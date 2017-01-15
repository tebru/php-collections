<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection\Test;

use PHPUnit_Framework_TestCase;
use stdClass;
use Tebru\Collection\ArrayList;
use Tebru\Collection\ArraySet;
use Tebru\Collection\Bag;
use Tebru\Collection\CollectionInterface;
use Tebru\Collection\HashSet;

/**
 * Class CollectionTest
 *
 * @author Nate Brunette <n@tebru.net>
 *
 * @covers \Tebru\Collection\AbstractCollection
 * @covers \Tebru\Collection\ArrayList
 * @covers \Tebru\Collection\Bag
 * @covers \Tebru\Collection\HashSet
 * @covers \Tebru\Collection\ArraySet
 */
class CollectionTest extends PHPUnit_Framework_TestCase
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
    public function testAddAllArray(CollectionInterface $collection)
    {
        $collection->addAllArray([0, 1, 2]);

        self::assertCount(3, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testContainsAll(CollectionInterface $collection)
    {
        $collection->addAllArray([0, 1, 2]);

        self::assertTrue($collection->containsAll(new ArrayList([0, 1, 2])));
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testContainsAllArray(CollectionInterface $collection)
    {
        $collection->addAllArray([0, 1, 2]);

        self::assertTrue($collection->containsAllArray([0, 1, 2]));
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testContainsAllSub(CollectionInterface $collection)
    {
        $collection->addAllArray([0, 1, 2]);

        self::assertTrue($collection->containsAll(new ArrayList([0])));
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testContainsAllFalse(CollectionInterface $collection)
    {
        $collection->addAllArray([0, 1, 2]);

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
        $collection->addAllArray([0, 1, 2]);
        $collection->removeAll(new ArrayList([1]));

        self::assertSame([0, 2], $collection->toArray());
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRemoveAllArray(CollectionInterface $collection)
    {
        $collection->addAllArray([0, 1, 2]);
        $collection->removeAllArray([1]);

        self::assertSame([0, 2], $collection->toArray());
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRemoveEveryElement(CollectionInterface $collection)
    {
        $collection->addAllArray([0, 1, 2]);
        $collection->removeAll(new ArrayList([0, 1, 2]));

        self::assertCount(0, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRemoveEveryElementExcess(CollectionInterface $collection)
    {
        $collection->addAllArray([0, 1, 2]);
        $collection->removeAll(new ArrayList([0, 1, 2, 3]));

        self::assertCount(0, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRetainAll(CollectionInterface $collection)
    {
        $collection->addAllArray([0, 1, 2]);
        $collection->retainAll(new ArrayList([0]));

        self::assertCount(1, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRetainAllArray(CollectionInterface $collection)
    {
        $collection->addAllArray([0, 1, 2]);
        $collection->retainAllArray([0]);

        self::assertCount(1, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRetainEveryElement(CollectionInterface $collection)
    {
        $collection->addAllArray([0, 1, 2]);
        $collection->retainAll(new ArrayList([0, 1, 2]));

        self::assertCount(3, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRetainEveryElementExcess(CollectionInterface $collection)
    {
        $collection->addAllArray([0, 1, 2]);
        $collection->retainAll(new ArrayList([0, 1, 2, 3]));

        self::assertCount(3, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testFind(CollectionInterface $collection)
    {
        $object1 = new stdClass();
        $object1->foo = 1;

        $object2 = new stdClass();
        $object2->foo = 2;

        $object3 = new stdClass();
        $object3->foo = 3;

        $collection->addAllArray([$object1, $object2, $object3]);

        self::assertSame($object2, $collection->find(function (stdClass $class) {
            return 2 === $class->foo;
        }));
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testFindFalse(CollectionInterface $collection)
    {
        $object1 = new stdClass();
        $object1->foo = 1;

        $object2 = new stdClass();
        $object2->foo = 2;

        $object3 = new stdClass();
        $object3->foo = 3;

        $collection->addAllArray([$object1, $object2, $object3]);

        self::assertNull($collection->find(function (stdClass $class) {
            return 4 === $class->foo;
        }));
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

        $collection->addAllArray([$object1, $object2, $object3]);

        self::assertTrue($collection->exists(function (stdClass $class) {
            return 2 === $class->foo;
        }));

        self::assertFalse($collection->exists(function (stdClass $class) {
            return 4 === $class->foo;
        }));
    }

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
        $collection->addAllArray([1, 2, 3]);
        $collection->clear();

        self::assertCount(0, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testCount(CollectionInterface $collection)
    {
        $collection->addAllArray([1, 2, 3]);

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
    public function testFilter(CollectionInterface $collection)
    {
        $object1 = new stdClass();
        $object1->foo = 1;

        $object2 = new stdClass();
        $object2->foo = 2;

        $object3 = new stdClass();
        $object3->foo = 3;

        $collection->addAllArray([$object1, $object2, $object3]);

        $result = $collection->filter(function (stdClass $class) {
            return 0 !== $class->foo % 2;
        });

        self::assertSame([$object1, $object3], $result->toArray());
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testGetIterator(CollectionInterface $collection)
    {
        $collection->addAllArray([0, 1, 2]);

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
            [new ArraySet()],
        ];
    }
}
