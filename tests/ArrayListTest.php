<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection\Test;

use OutOfBoundsException;
use PHPUnit_Framework_TestCase;
use Tebru\Collection\ArrayList;

/**
 * Class ArrayListTest
 *
 * @author Nate Brunette <n@tebru.net>
 *
 * @covers \Tebru\Collection\ArrayList
 */
class ArrayListTest extends PHPUnit_Framework_TestCase
{
    public function testConstructWithoutArgument()
    {
        self::assertInstanceOf(ArrayList::class, new ArrayList());
    }

    public function testConstructWithElements()
    {
        $elements = [1, false, null, new \stdClass()];
        $list = new ArrayList($elements);

        self::assertCount(4, $list);
        self::assertSame($elements[0], $list->get(0));
        self::assertSame($elements[1], $list->get(1));
        self::assertSame($elements[2], $list->get(2));
        self::assertEquals($elements[3], $list->get(3));
    }

    public function testConstructWithAssociativeArray()
    {
        $list = new ArrayList(['foo' => 'bar']);

        self::assertAttributeEquals(['bar'], 'elements', $list);
        self::assertCount(1, $list);
        self::assertSame('bar', $list->get(0));
    }

    public function testAdd()
    {
        $list = new ArrayList();

        self::assertTrue($list->add(1));
        self::assertSame(1, $list->get(0));
    }

    public function testRemove()
    {
        $list = new ArrayList([1]);

        self::assertTrue($list->remove(1));
        self::assertCount(0, $list);
    }

    public function testRemoveFuzzy()
    {
        $list = new ArrayList([1]);

        self::assertTrue($list->remove(true, false));
        self::assertCount(0, $list);
    }

    public function testRemoveNotFound()
    {
        $list = new ArrayList([1]);

        self::assertFalse($list->remove(true));
        self::assertCount(1, $list);
    }

    public function testClear()
    {
        $list = new ArrayList([1, 2, 3]);
        $list->clear();

        self::assertCount(0, $list);
    }

    public function testCount()
    {
        $list = new ArrayList([1, 2, 3]);

        self::assertSame(3, $list->count());
    }

    public function testContains()
    {
        $list = new ArrayList([1]);

        self::assertTrue($list->contains(1));
    }

    public function testContainsFuzzy()
    {
        $list = new ArrayList([1]);

        self::assertTrue($list->contains(true, false));
    }

    public function testNotContains()
    {
        $list = new ArrayList([1]);

        self::assertFalse($list->contains(true));
    }

    public function testToArray()
    {
        $list = new ArrayList([1]);

        self::assertSame([1], $list->toArray());
    }

    public function testGetIterator()
    {
        $list = new ArrayList([0, 1, 2]);

        $count = 0;
        foreach ($list as $element) {
            $count++;
        }

        self::assertSame(3, $count);
    }

    public function testInsert()
    {
        $list = new ArrayList([0, 1, 2]);

        $list->insert(1, 'a');

        self::assertCount(4, $list);
        self::assertSame(0, $list->get(0));
        self::assertSame('a', $list->get(1));
        self::assertSame(1, $list->get(2));
    }

    public function testInsertBeginning()
    {
        $list = new ArrayList([0, 1, 2]);

        $list->insert(0, 'a');

        self::assertCount(4, $list);
        self::assertSame('a', $list->get(0));
    }

    public function testInsertEnd()
    {
        $list = new ArrayList([0, 1, 2]);

        $list->insert(3, 'a');

        self::assertCount(4, $list);
        self::assertSame('a', $list->get(3));
        self::assertSame(2, $list->get(2));
    }

    public function testInsertEmpty()
    {
        $list = new ArrayList();

        $list->insert(0, 'a');

        self::assertSame('a', $list->get(0));
    }

    public function testInsertArray()
    {
        $list = new ArrayList();

        $list->insert(0, [1]);

        self::assertSame([1], $list->get(0));
    }

    public function testInsertException()
    {
        $this->expectException(OutOfBoundsException::class);

        $list = new ArrayList();
        $list->insert(1, 1);
    }

    public function testInsertAll()
    {
        $list = new ArrayList([0, 3, 4]);

        self::assertTrue($list->insertAll(1, new ArrayList([1, 2])));
        self::assertCount(5, $list);
        self::assertAttributeEquals([0, 1, 2, 3, 4], 'elements', $list);
    }

    public function testInsertAllEmpty()
    {
        $list = new ArrayList();

        self::assertTrue($list->insertAll(0, new ArrayList([0, 1, 2])));
        self::assertCount(3, $list);
    }

    public function testInsertAllFalse()
    {
        $list = new ArrayList();

        self::assertFalse($list->insertAll(0, new ArrayList()));
    }

    public function testInsertAllException()
    {
        $this->expectException(OutOfBoundsException::class);

        $list = new ArrayList();
        $list->insertAll(-1, new ArrayList());
    }

    public function testGet()
    {
        $list = new ArrayList([1]);

        self::assertSame(1, $list->get(0));
    }

    public function testGetException()
    {
        $this->expectException(OutOfBoundsException::class);

        $list = new ArrayList([1]);
        $list->get(-1);
    }

    public function testHasTrue()
    {
        $list = new ArrayList([1]);

        self::assertTrue($list->has(0));
    }

    public function testHasFalse()
    {
        $list = new ArrayList([1]);

        self::assertFalse($list->has(1));
    }

    public function testIndexOf()
    {
        $list = new ArrayList([1]);

        self::assertSame(0, $list->indexOf(1));
    }

    public function testIndexOfFuzzy()
    {
        $list = new ArrayList([1]);

        self::assertSame(0, $list->indexOf(true, false));
    }

    public function testIndexOfNotFound()
    {
        $list = new ArrayList([1]);

        self::assertSame(-1, $list->indexOf(2));
    }

    public function testLastIndexOf()
    {
        $list = new ArrayList([0, 1, 0, 2]);

        self::assertSame(2, $list->lastIndexOf(0));
    }

    public function testLastIndexOfFuzzy()
    {
        $list = new ArrayList([0, 1, 0, 2]);

        self::assertSame(2, $list->lastIndexOf(false, false));
    }

    public function testLastIndexOfNotFound()
    {
        $list = new ArrayList([0, 1, 0, 2]);

        self::assertSame(-1, $list->lastIndexOf(false));
    }

    public function testRemoveAt()
    {
        $list = new ArrayList([0, 1, 2]);
        $oldElement = $list->removeAt(1);

        self::assertSame(1, $oldElement);
        self::assertCount(2, $list);
        self::assertSame(0, $list->get(0));
        self::assertSame(2, $list->get(1));
    }

    public function testRemoveAtException()
    {
        $this->expectException(OutOfBoundsException::class);

        $list = new ArrayList([1]);
        $list->removeAt(1);
    }

    public function testSet()
    {
        $list = new ArrayList([0]);
        $list->set(0, 1);

        self::assertSame(1, $list->get(0));
        self::assertCount(1, $list);
    }

    public function testSetEmpty()
    {
        $list = new ArrayList();
        $list->set(0, 1);

        self::assertSame(1, $list->get(0));
        self::assertCount(1, $list);
    }

    public function testSetException()
    {
        $this->expectException(OutOfBoundsException::class);

        $list = new ArrayList();
        $list->set(1, 1);
    }

    public function testSubList()
    {
        $list = new ArrayList([0, 1, 2, 3, 4, 5]);
        $subList = $list->subList(1, 5);

        self::assertSame([1, 2, 3, 4], $subList->toArray());
    }

    public function testSubListComplete()
    {
        $list = new ArrayList([0, 1, 2, 3, 4, 5]);
        $subList = $list->subList(0, 6);

        self::assertSame([0, 1, 2, 3, 4, 5], $subList->toArray());
    }

    public function testSubListFromOutOfBounds()
    {
        $this->expectException(OutOfBoundsException::class);

        $list = new ArrayList([0, 1, 2]);
        $list->subList(0, 4);
    }

    public function testSubListToOutOfBounds()
    {
        $this->expectException(OutOfBoundsException::class);

        $list = new ArrayList([0, 1, 2]);
        $list->subList(-1, 1);
    }
}

