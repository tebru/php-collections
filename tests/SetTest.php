<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection\Test;

use PHPUnit_Framework_TestCase;
use Tebru\Collection\ArrayList;
use Tebru\Collection\ArraySet;
use Tebru\Collection\HashSet;
use Tebru\Collection\SetInterface;

/**
 * class SetTest
 *
 * @author Nate Brunette <n@tebru.net>
 * @covers \Tebru\Collection\HashSet
 * @covers \Tebru\Collection\ArraySet
 */
class SetTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getSets
     * @param SetInterface $collection
     */
    public function testAddDuplicate(SetInterface $collection)
    {
        $collection->addAllArray([0, 1, 2]);

        self::assertFalse($collection->add(1));
        self::assertCount(3, $collection);
    }

    /**
     * @dataProvider getSets
     * @param SetInterface $collection
     */
    public function testAddAllDuplicates(SetInterface $collection)
    {
        $collection->addAllArray([0, 1, 2]);

        self::assertFalse($collection->addAll(new ArrayList([0, 1, 2])));
        self::assertCount(3, $collection);
    }

    /**
     * @dataProvider getSets
     * @param SetInterface $collection
     */
    public function testAddAllDuplicatesExtra(SetInterface $collection)
    {
        $collection->addAllArray([0, 1, 2]);

        self::assertTrue($collection->addAll(new ArrayList([0, 1, 2, 3])));
        self::assertCount(4, $collection);
    }

    public function getSets()
    {
        return [
            [new HashSet()],
            [new ArraySet()],
        ];
    }
}
