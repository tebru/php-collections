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
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * @param mixed $element
     * @param bool $strict
     * @return bool
     */
    public function add($element, bool $strict = true): bool
    {
        $this->elements[] = $element;

        return true;
    }

    /**
     * Removes object if it exists
     *
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * Returns true if the element was removed
     *
     * @param mixed $element
     * @param bool $strict
     * @return bool
     */
    public function remove($element, bool $strict = true): bool
    {
        $index = $this->indexOf($element, $strict);

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
     * Returns the size of the collection
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->elements);
    }

    /**
     * Returns true if the collection contains element
     *
     * @param mixed $element
     * @param bool $strict
     * @return bool
     */
    public function contains($element, bool $strict = true): bool
    {
        return in_array($element, $this->elements, $strict);
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
     * Filter the collection using closure
     *
     * The closure will get passed each element.  Returning true from the
     * closure will include that element in the new collection.
     *
     * @param callable $filter
     * @return CollectionInterface
     */
    public function filter(callable $filter): CollectionInterface
    {
        return new static(array_filter($this->elements, $filter));
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
        if ($index < 0 || $index > $this->count()) {
            throw new OutOfBoundsException(sprintf('Element unable to be inserted at index "%s"', $index));
        }

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
        if ($index < 0 || $index > $this->count()) {
            throw new OutOfBoundsException(sprintf('Elements unable to be inserted at index "%s"', $index));
        }

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
        $index = array_search($element, $this->elements, $strict);

        return false === $index ? -1 : $index;
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
        $elements = array_reverse($this->elements);

        $index = array_search($element, $elements, $strict);

        // return -1 if not found or (size - index found - 1) to return the index of the element after reverse
        return false === $index ? -1 : $this->count() - $index - 1;
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
        if ($index < 0 || $index > $this->count()) {
            throw new OutOfBoundsException(sprintf('Element unable to be set at index "%s"', $index));
        }

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

        $newList = array_slice($this->elements, $fromIndex, $toIndex - $fromIndex);

        return new static($newList);
    }
}
