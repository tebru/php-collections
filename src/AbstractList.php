<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

use OutOfBoundsException;

/**
 * Class AbstractList
 *
 * A skeletal implementation of the [@see ListInterface]
 *
 * @author Nate Brunette <n@tebru.net>
 */
abstract class AbstractList extends AbstractCollection implements ListInterface
{
    /**
     * Returns the index of the first instance of the element, -1 if the element
     * doesn't exist
     *
     * @param mixed $element
     * @return int
     */
    public function indexOf($element): int
    {
        $index = array_search($element, $this->toArray(), true);

        return false === $index ? -1 : $index;
    }

    /**
     * Returns the index of the last instance of the element, -1 if the element
     * doesn't exist
     *
     * @param mixed $element
     * @return int
     */
    public function lastIndexOf($element): int
    {
        $elements = array_reverse($this->toArray());

        $index = array_search($element, $elements, true);

        // return -1 if not found or (size - index found - 1) to return the index of the element after reverse
        return false === $index ? -1 : $this->count() - $index - 1;
    }

    /**
     * Returns a new ListInterface ranging from $fromIndex inclusive to
     * $toIndex exclusive
     *
     * @param int $fromIndex
     * @param int $toIndex
     * @return ListInterface
     * @throws \OutOfBoundsException If to or from index does not exist
     */
    public function subList(int $fromIndex, int $toIndex): ListInterface
    {
        if (!$this->has($fromIndex) || !$this->has($toIndex - 1)) {
            throw new OutOfBoundsException('Unable to create sub list as $toIndex or $fromIndex do not exist in list');
        }

        $newList = array_slice($this->toArray(), $fromIndex, $toIndex - $fromIndex);

        return new static($newList);
    }
}
