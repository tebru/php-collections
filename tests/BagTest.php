<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection\Test;

use PHPUnit_Framework_TestCase;
use Tebru\Collection\ArrayList;
use Tebru\Collection\Bag;

/**
 * Class BagTest
 *
 * @author Nate Brunette <n@tebru.net>
 *
 * @covers \Tebru\Collection\Bag
 */
class BagTest extends PHPUnit_Framework_TestCase
{
    public function testConstructWithoutArgument()
    {
        self::assertInstanceOf(Bag::class, new Bag());
    }

    public function testConstructWithElements()
    {
        $elements = [1, false, null, new \stdClass()];
        $collection = new Bag($elements);

        self::assertCount(4, $collection);
        self::assertSame($elements[0], $collection->toArray()[0]);
        self::assertSame($elements[1], $collection->toArray()[1]);
        self::assertSame($elements[2], $collection->toArray()[2]);
        self::assertSame($elements[3], $collection->toArray()[3]);
    }

    public function testConstructWithAssociativeArray()
    {
        $collection = new Bag(['foo' => 'bar']);

        self::assertAttributeEquals(['bar'], 'elements', $collection);
        self::assertCount(1, $collection);
        self::assertSame('bar', $collection->toArray()[0]);
    }

    public function testRemoveFuzzy()
    {
        $collection = new Bag([1]);

        self::assertTrue($collection->remove(true, false));
        self::assertCount(0, $collection);
    }

    public function testRemoveAllFuzzy()
    {
        $collection = new Bag([0, 1, 2]);
        $collection->removeAll(new ArrayList([true]), false);

        self::assertSame([0, 2], $collection->toArray());
    }
}
