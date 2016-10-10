<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\DataStructure;

/**
 * Class ArrayList
 *
 * Implements [@see ListInterface] and maintains an array of elements
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ArrayList extends AbstractList
{
    /**
     * Constructor
     *
     * @param array $elements
     */
    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    /**
     * Returns a new ListInterface ranging from $fromIndex inclusive to
     * $toIndex exclusive
     *
     * @param int $fromIndex
     * @param int $toIndex
     * @return ListInterface
     */
    public function subList(int $fromIndex, int $toIndex): ListInterface
    {
        $newList = array_slice($this->elements, $fromIndex, $toIndex - $fromIndex);

        return new ArrayList($newList);
    }
}
