<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

use ArrayIterator;
use OutOfBoundsException;

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
     * An array of elements
     *
     * @var array
     */
    protected $elements = [];

    /**
     * Constructor
     *
     * @param array $elements
     */
    public function __construct(array $elements = [])
    {
        $this->elements = array_values($elements);
    }

    /**
     * Ensure the element exists in the collection
     *
     * Returns true if the collection can contain duplicates,
     * and false if it cannot.
     *
     * @param mixed $element
     * @return bool
     */
    public function add($element): bool
    {
        $this->elements[] = $element;

        return true;
    }

    /**
     * Removes object if it exists
     *
     * Returns true if the element was removed
     *
     * @param mixed $element
     * @return bool
     */
    public function remove($element): bool
    {
        $index = $this->indexOf($element);

        if (-1 === $index) {
            return false;
        }

        array_splice($this->elements, $index, 1);

        return true;
    }

    /**
     * Removes all elements from a collection
     *
     * @return void
     */
    public function clear()
    {
        $this->elements = [];
    }

    /**
     * Returns an array of all elements in the collection
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->elements;
    }

    /**
     * Retrieve an external iterator
     *
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->elements);
    }

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
        if (!$this->has($index)) {
            throw new OutOfBoundsException(sprintf('Tried to access element at index "%s"', $index));
        }

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
        $this->assertIndex($index);

        $oldElement = null;
        if ($this->has($index)) {
            $oldElement = $this->get($index);
        }

        $this->elements[$index] = $element;

        return $oldElement;
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

    /**
     * Assert the index is able to be inserted
     *
     * @param int $index
     * @return void
     * @throws \OutOfBoundsException If the index is less than 0 or greater than current size
     */
    protected function assertIndex(int $index)
    {
        if ($index < 0 || $index > $this->count()) {
            throw new OutOfBoundsException(sprintf('Element unable to be inserted at index "%s"', $index));
        }
    }
}
