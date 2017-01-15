<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

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
}
