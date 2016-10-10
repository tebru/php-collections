<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\DataStructure;

use OutOfBoundsException;

/**
 * Class AbstractList
 *
 * A default implementation of the [@see ListInterface]
 *
 * @author Nate Brunette <n@tebru.net>
 */
abstract class AbstractList extends AbstractCollection implements ListInterface
{
    /**
     * Insert element at the specified index
     *
     * @param int $index
     * @param mixed $element
     * @return void
     * @throws \OutOfBoundsException if the index doesn't exist
     */
    public function insert(int $index, $element)
    {
        $this->assertIndex($index);

        array_splice($this->elements, $index, 0, [$element]);
    }

    /**
     * Inserts all elements of a collection at index
     *
     * @param int $index
     * @param CollectionInterface $collection
     * @return bool
     * @throws \OutOfBoundsException if the index doesn't exist
     */
    public function insertAll(int $index, CollectionInterface $collection): bool
    {
        $this->assertIndex($index);

        $size = $this->count();
        array_splice($this->elements, $index, 0, $collection->toArray());

        return $size !== $this->count();
    }

    /**
     * Returns the element at the index
     *
     * @param int $index
     * @return mixed
     * @throws \OutOfBoundsException if the index doesn't exist
     */
    public function get(int $index)
    {
        $this->assertIndex($index);

        return $this->elements[$index];
    }

    /**
     * Returns true if an element exists at the index
     *
     * @param int $index
     * @return bool
     */
    public function has(int $index): bool
    {
        return array_key_exists($index, $this->elements);
    }

    /**
     * Returns the index of the first instance of the element, -1 if the element
     * doesn't exist
     *
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * @param mixed $element
     * @param bool $strict
     * @return int
     */
    public function indexOf($element, bool $strict = true): int
    {
        foreach ($this->elements as $index => $item) {
            if ($this->equals($item, $element, $strict)) {
                return $index;
            }
        }

        return -1;
    }

    /**
     * Returns the index of the last instance of the element, -1 if the element
     * doesn't exist
     *
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * @param mixed $element
     * @param bool $strict
     * @return int
     */
    public function lastIndexOf($element, bool $strict = true): int
    {
        $returnIndex = -1;
        foreach ($this->elements as $index => $item) {
            if ($this->equals($item, $element, $strict)) {
                $returnIndex = $index;
            }
        }

        return $returnIndex;
    }

    /**
     * Removes the element at the specified index
     *
     * This returns the element that was previously at this index
     *
     * @param int $index
     * @return mixed
     * @throws \OutOfBoundsException if the index doesn't exist
     */
    public function removeAt(int $index)
    {
        $oldElement = $this->get($index);
        array_splice($this->elements, $index, 1);

        return $oldElement;
    }

    /**
     * Replace the element at the specified index
     *
     * Returns the element that was previously at this index
     *
     * @param int $index
     * @param mixed $element
     * @return mixed
     * @throws \OutOfBoundsException if the index doesn't exist
     */
    public function set(int $index, $element)
    {
        $oldElement = $this->get($index);
        $this->elements[$index] = $element;

        return $oldElement;
    }

    /**
     * Ensure that the index exists
     *
     * @param int $index
     * @return void
     * @throws OutOfBoundsException if the index doesn't exist
     */
    protected function assertIndex(int $index)
    {
        if (!$this->has($index)) {
            throw new OutOfBoundsException(sprintf('Tried to access element at index "%s"', $index));
        }
    }
}
