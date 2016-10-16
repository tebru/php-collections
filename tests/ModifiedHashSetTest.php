<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection\Test;

use PHPUnit_Framework_TestCase;
use stdClass;
use Tebru\Collection\ArrayList;
use Tebru\Collection\CollectionInterface;
use Tebru\Collection\Test\Mock\Entity;
use Tebru\Collection\Test\Mock\ModifiedHashSet;

/**
 * Class ModifiedHashSetTest
 *
 * Copies the tests from [@see MapTest]
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ModifiedHashSetTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testAddAll(CollectionInterface $collection)
    {
        $collection->addAll(new ArrayList([new Entity(1), new Entity(2), new Entity(3)]));

        self::assertCount(3, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testAddAllArray(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);

        self::assertCount(3, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testContainsAll(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);

        self::assertTrue($collection->containsAll(new ArrayList([new Entity(1), new Entity(2), new Entity(3)])));
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testContainsAllArray(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);

        self::assertTrue($collection->containsAllArray([new Entity(1), new Entity(2), new Entity(3)]));
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testContainsAllSub(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);

        self::assertTrue($collection->containsAll(new ArrayList([new Entity(1)])));
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testContainsAllFalse(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);

        self::assertFalse($collection->containsAll(new ArrayList([new Entity(1), new Entity(2), new Entity(3), new Entity(4)])));
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
        $collection->add(new Entity(1));
        self::assertFalse($collection->isEmpty());
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRemoveAll(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);
        $collection->removeAll(new ArrayList([new Entity(2)]));

        self::assertEquals([new Entity(1), new Entity(3)], $collection->toArray());
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRemoveAllArray(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);
        $collection->removeAllArray([new Entity(2)]);

        self::assertEquals([new Entity(1), new Entity(3)], $collection->toArray());
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRemoveEveryElement(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);
        $collection->removeAll(new ArrayList([new Entity(1), new Entity(2), new Entity(3)]));

        self::assertCount(0, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRemoveEveryElementExcess(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);
        $collection->removeAll(new ArrayList([new Entity(1), new Entity(2), new Entity(3), new Entity(4)]));

        self::assertCount(0, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRetainAll(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);
        $collection->retainAll(new ArrayList([new Entity(1)]));

        self::assertCount(1, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRetainAllArray(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);
        $collection->retainAllArray([new Entity(1)]);

        self::assertCount(1, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRetainEveryElement(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);
        $collection->retainAll(new ArrayList([new Entity(1), new Entity(2), new Entity(3)]));

        self::assertCount(3, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRetainEveryElementExcess(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);
        $collection->retainAll(new ArrayList([new Entity(1), new Entity(2), new Entity(3), new Entity(4)]));

        self::assertCount(3, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testFind(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);

        self::assertEquals(new Entity(2), $collection->find(function (Entity $class) {
            return 2 === $class->value;
        }));
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testFindFalse(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);

        self::assertNull($collection->find(function (Entity $class) {
            return 4 === $class->value;
        }));
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testExists(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);

        self::assertTrue($collection->exists(function (Entity $class) {
            return 2 === $class->value;
        }));

        self::assertFalse($collection->exists(function (Entity $class) {
            return 4 === $class->value;
        }));
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testAdd(CollectionInterface $collection)
    {
        self::assertTrue($collection->add(new Entity(1)));
        self::assertEquals(new Entity(1), $collection->toArray()[0]);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRemove(CollectionInterface $collection)
    {
        $collection->add(new Entity(1));

        self::assertTrue($collection->remove(new Entity(1)));
        self::assertCount(0, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testRemoveNotFound(CollectionInterface $collection)
    {
        $collection->add(new Entity(1));

        self::assertFalse($collection->remove(new Entity(2)));
        self::assertCount(1, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testClear(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);
        $collection->clear();

        self::assertCount(0, $collection);
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testCount(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);

        self::assertSame(3, $collection->count());
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testContains(CollectionInterface $collection)
    {
        $collection->add(new Entity(1));

        self::assertTrue($collection->contains(new Entity(1)));
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testNotContains(CollectionInterface $collection)
    {
        $collection->add(new Entity(1));

        self::assertFalse($collection->contains(new Entity(2)));
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testToArray(CollectionInterface $collection)
    {
        $collection->add(new Entity(1));

        self::assertEquals([new Entity(1)], $collection->toArray());
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testFilter(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);

        $result = $collection->filter(function (Entity $class) {
            return 0 === $class->value % 2;
        });

        self::assertEquals([new Entity(2)], $result->toArray());
    }

    /**
     * @dataProvider getCollections
     * @param CollectionInterface $collection
     */
    public function testGetIterator(CollectionInterface $collection)
    {
        $collection->addAllArray([new Entity(1), new Entity(2), new Entity(3)]);

        $count = 0;
        foreach ($collection as $element) {
            $count++;
        }

        self::assertSame(3, $count);
    }

    public function getCollections()
    {
        return [
            [new ModifiedHashSet()],
        ];
    }
}
