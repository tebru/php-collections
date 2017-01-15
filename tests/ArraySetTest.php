<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection\Test;

use PHPUnit_Framework_TestCase;
use Tebru\Collection\ArraySet;

/**
 * Class ArraySetTest
 *
 * @author Nate Brunette <n@tebru.net>
 *
 * @covers \Tebru\Collection\ArraySet
 */
class ArraySetTest extends PHPUnit_Framework_TestCase
{
    public function testConstructWithoutArgument()
    {
        self::assertInstanceOf(ArraySet::class, new ArraySet());
    }

    public function testConstructWithElements()
    {
        $elements = [1, false, null, new \stdClass()];
        $collection = new ArraySet($elements);

        self::assertCount(4, $collection);
        self::assertSame($elements[0], $collection->toArray()[0]);
        self::assertSame($elements[1], $collection->toArray()[1]);
        self::assertSame($elements[2], $collection->toArray()[2]);
        self::assertSame($elements[3], $collection->toArray()[3]);
    }

    public function testConstructWithAssociativeArray()
    {
        $collection = new ArraySet(['foo' => 'bar']);

        self::assertCount(1, $collection);
        self::assertSame('bar', $collection->toArray()[0]);
    }
}
