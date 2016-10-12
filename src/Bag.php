<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

use ArrayIterator;

/**
 * Class Bag
 *
 * A generic [@see CollectionInterface] backed by an array.
 *
 * @author Nate Brunette <n@tebru.net>
 */
class Bag extends AbstractCollection
{
    /**
     * The collection elements
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
     * Removes all elements from a collection
     *
     * @return void
     */
    public function clear()
    {
        $this->elements = [];
    }

    /**
     * Returns true if the collection contains element
     *
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
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
        $index = array_search($element, $this->elements, $strict);

        if (false === $index) {
            return false;
        }

        array_splice($this->elements, $index, 1);

        return true;
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
     * Returns the size of the collection
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->elements);
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
}
