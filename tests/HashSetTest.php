<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection\Test;

use PHPUnit_Framework_TestCase;
use Tebru\Collection\ArrayList;
use Tebru\Collection\HashSet;

/**
 * Class HashSetTest
 *
 * @author Nate Brunette <n@tebru.net>
 *
 * @covers \Tebru\Collection\HashSet
 */
class HashSetTest extends PHPUnit_Framework_TestCase 
{
    public function testConstructWithoutArgument()
    {
        self::assertInstanceOf(HashSet::class, new HashSet());
    }

    public function testConstructWithElements()
    {
        $elements = [1, false, null, new \stdClass()];
        $collection = new HashSet(new ArrayList($elements));

        self::assertCount(4, $collection);
        self::assertSame($elements[0], $collection->toArray()[0]);
        self::assertSame($elements[1], $collection->toArray()[1]);
        self::assertSame($elements[2], $collection->toArray()[2]);
        self::assertSame($elements[3], $collection->toArray()[3]);
    }

    public function testConstructWithAssociativeArray()
    {
        $collection = new HashSet(new ArrayList(['foo' => 'bar']));

        self::assertCount(1, $collection);
        self::assertSame('bar', $collection->toArray()[0]);
    }

    public function testAddDuplicate()
    {
        $collection = new HashSet(new ArrayList([0, 1, 2]));

        self::assertFalse($collection->add(1));
        self::assertCount(3, $collection);
    }

    public function testAddDuplicateFuzzy()
    {
        $collection = new HashSet(new ArrayList([0, 1, 2]));

        self::assertFalse($collection->add(true, false));
        self::assertCount(3, $collection);
    }

    public function testAddAllDuplicates()
    {
        $collection = new HashSet(new ArrayList([0, 1, 2]));

        self::assertFalse($collection->addAll(new ArrayList([0, 1, 2])));
        self::assertCount(3, $collection);
    }

    public function testAddAllDuplicatesFuzzy()
    {
        $collection = new HashSet(new ArrayList([0, 1, 2]));

        self::assertFalse($collection->addAll(new ArrayList([false, true, 2]), false));
        self::assertCount(3, $collection);
    }

    public function testAddAllDuplicatesExtra()
    {
        $collection = new HashSet(new ArrayList([0, 1, 2]));

        self::assertTrue($collection->addAll(new ArrayList([0, 1, 2, 3])));
        self::assertCount(4, $collection);
    }
}
