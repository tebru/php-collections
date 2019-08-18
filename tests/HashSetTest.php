<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection\Test;

use PHPUnit\Framework\TestCase;
use Tebru\Collection\HashSet;

/**
 * Class HashSetTest
 *
 * @author Nate Brunette <n@tebru.net>
 *
 * @covers \Tebru\Collection\HashSet
 */
class HashSetTest extends TestCase
{
    public function testConstructWithoutArgument()
    {
        self::assertInstanceOf(HashSet::class, new HashSet());
    }

    public function testConstructWithElements()
    {
        $elements = [1, false, null, new \stdClass()];
        $collection = new HashSet($elements);

        self::assertCount(4, $collection);
        self::assertSame($elements[0], $collection->toArray()[0]);
        self::assertSame($elements[1], $collection->toArray()[1]);
        self::assertSame($elements[2], $collection->toArray()[2]);
        self::assertSame($elements[3], $collection->toArray()[3]);
    }

    public function testConstructWithAssociativeArray()
    {
        $collection = new HashSet(['foo' => 'bar']);

        self::assertCount(1, $collection);
        self::assertSame('bar', $collection->toArray()[0]);
    }
}
