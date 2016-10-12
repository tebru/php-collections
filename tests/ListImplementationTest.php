<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection\Test;

use OutOfBoundsException;
use PHPUnit_Framework_TestCase;
use Tebru\Collection\ArrayList;
use Tebru\Collection\ListInterface;

/**
 * Class ListImplementationTest
 *
 * @author Nate Brunette <n@tebru.net>
 *
 * @covers \Tebru\Collection\ArrayList
 */
class ListImplementationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testInsert(ListInterface $list)
    {
        $list->addAll(new ArrayList([0, 1, 2]));

        $list->insert(1, 'a');

        self::assertCount(4, $list);
        self::assertSame(0, $list->get(0));
        self::assertSame('a', $list->get(1));
        self::assertSame(1, $list->get(2));
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testInsertBeginning(ListInterface $list)
    {
        $list->addAll(new ArrayList([0, 1, 2]));

        $list->insert(0, 'a');

        self::assertCount(4, $list);
        self::assertSame('a', $list->get(0));
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testInsertEnd(ListInterface $list)
    {
        $list = new ArrayList([0, 1, 2]);

        $list->insert(3, 'a');

        self::assertCount(4, $list);
        self::assertSame('a', $list->get(3));
        self::assertSame(2, $list->get(2));
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testInsertEmpty(ListInterface $list)
    {
        $list->insert(0, 'a');

        self::assertSame('a', $list->get(0));
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testInsertArray(ListInterface $list)
    {
        $list->insert(0, [1]);

        self::assertSame([1], $list->get(0));
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testInsertException(ListInterface $list)
    {
        $this->expectException(OutOfBoundsException::class);

        $list->insert(1, 1);
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testInsertAll(ListInterface $list)
    {
        $list->addAll(new ArrayList([0, 3, 4]));

        self::assertTrue($list->insertAll(1, new ArrayList([1, 2])));
        self::assertCount(5, $list);
        self::assertAttributeEquals([0, 1, 2, 3, 4], 'elements', $list);
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testInsertAllEmpty(ListInterface $list)
    {
        self::assertTrue($list->insertAll(0, new ArrayList([0, 1, 2])));
        self::assertCount(3, $list);
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testInsertAllFalse(ListInterface $list)
    {
        self::assertFalse($list->insertAll(0, new ArrayList()));
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testInsertAllException(ListInterface $list)
    {
        $this->expectException(OutOfBoundsException::class);

        $list->insertAll(-1, new ArrayList());
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testGet(ListInterface $list)
    {
        $list->add(1);

        self::assertSame(1, $list->get(0));
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testGetException(ListInterface $list)
    {
        $this->expectException(OutOfBoundsException::class);

        $list->add(1);
        $list->get(-1);
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testHasTrue(ListInterface $list)
    {
        $list->add(1);

        self::assertTrue($list->has(0));
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testHasFalse(ListInterface $list)
    {
        $list->add(1);

        self::assertFalse($list->has(1));
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testIndexOf(ListInterface $list)
    {
        $list->add(1);

        self::assertSame(0, $list->indexOf(1));
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testIndexOfFuzzy(ListInterface $list)
    {
        $list->add(1);

        self::assertSame(0, $list->indexOf(true, false));
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testIndexOfNotFound(ListInterface $list)
    {
        $list->add(1);

        self::assertSame(-1, $list->indexOf(2));
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testLastIndexOf(ListInterface $list)
    {
        $list->addAll(new ArrayList([0, 1, 0, 2]));

        self::assertSame(2, $list->lastIndexOf(0));
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testLastIndexOfFuzzy(ListInterface $list)
    {
        $list->addAll(new ArrayList([0, 1, 0, 2]));

        self::assertSame(2, $list->lastIndexOf(false, false));
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testLastIndexOfNotFound(ListInterface $list)
    {
        $list->addAll(new ArrayList([0, 1, 0, 2]));

        self::assertSame(-1, $list->lastIndexOf(false));
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testRemoveAt(ListInterface $list)
    {
        $list->addAll(new ArrayList([0, 1, 2]));
        $oldElement = $list->removeAt(1);

        self::assertSame(1, $oldElement);
        self::assertCount(2, $list);
        self::assertSame(0, $list->get(0));
        self::assertSame(2, $list->get(1));
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testRemoveAtException(ListInterface $list)
    {
        $this->expectException(OutOfBoundsException::class);

        $list->add(1);
        $list->removeAt(1);
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testSet(ListInterface $list)
    {
        $list->add(0);
        $list->set(0, 1);

        self::assertSame(1, $list->get(0));
        self::assertCount(1, $list);
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testSetEmpty(ListInterface $list)
    {
        $list->set(0, 1);

        self::assertSame(1, $list->get(0));
        self::assertCount(1, $list);
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testSetException(ListInterface $list)
    {
        $this->expectException(OutOfBoundsException::class);

        $list->set(1, 1);
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testSubList(ListInterface $list)
    {
        $list->addAll(new ArrayList([0, 1, 2, 3, 4, 5]));
        $subList = $list->subList(1, 5);

        self::assertSame([1, 2, 3, 4], $subList->toArray());
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testSubListComplete(ListInterface $list)
    {
        $list->addAll(new ArrayList([0, 1, 2, 3, 4, 5]));
        $subList = $list->subList(0, 6);

        self::assertSame([0, 1, 2, 3, 4, 5], $subList->toArray());
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testSubListFromOutOfBounds(ListInterface $list)
    {
        $this->expectException(OutOfBoundsException::class);

        $list->addAll(new ArrayList([0, 1, 2]));
        $list->subList(0, 4);
    }

    /**
     * @dataProvider getLists
     * @param ListInterface $list
     */
    public function testSubListToOutOfBounds(ListInterface $list)
    {
        $this->expectException(OutOfBoundsException::class);

        $list->addAll(new ArrayList([0, 1, 2]));
        $list->subList(-1, 1);
    }

    public function getLists()
    {
        return [
            [new ArrayList()],
        ];
    }
}
