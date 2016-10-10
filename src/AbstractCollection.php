<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\DataStructure;

use ArrayIterator;
use Traversable;

/**
 * Class AbstractCollection
 *
 * Provides a default implementation of the [@see CollectionInterface]
 *
 * @author Nate Brunette <n@tebru.net>
 */
abstract class AbstractCollection implements CollectionInterface
{
    /**
     * An array of elements
     *
     * @var array
     */
    protected $elements = [];

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
     * Ensure all elements of a collection exists in this collection
     *
     * Return true if the collection has changed, and false if it hasn't
     *
     * @param CollectionInterface $collection
     * @return mixed
     */
    public function addAll(CollectionInterface $collection): bool
    {
        $size = $this->count();
        foreach ($collection as $element) {
            $this->add($element);
        }

        return $size !== $this->count();
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
     * @param mixed $element
     * @param bool $strict
     * @return bool
     */
    public function contains($element, bool $strict = true): bool
    {
        foreach ($this->elements as $item) {
            if ($this->equals($item, $element, $strict)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns true if the collection contains all elements from another collection
     *
     * @param CollectionInterface $collection
     * @return bool
     */
    public function containsAll(CollectionInterface $collection): bool
    {
        $containsAll = true;
        foreach ($collection as $element) {
            if (!$this->contains($element)) {
                $containsAll = false;
                break;
            }
        }

        return $containsAll;
    }

    /**
     * Returns true if the collection is empty
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return 0 === $this->count();
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
        foreach ($this->elements as $index => $item) {
            if ($this-$this->equals($item, $element, $strict)) {
                array_splice($this->elements, $index, 1);

                return true;
            }
        }

        return false;
    }

    /**
     * Remove all items in a collection from this collection
     *
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * Returns true if the collection was modified
     *
     * @param CollectionInterface $collection
     * @param bool $strict
     * @return bool
     */
    public function removeAll(CollectionInterface $collection, bool $strict = true): bool
    {
        $size = $this->count();
        foreach ($collection as $element) {
            $this->remove($element, $strict);
        }

        return $size !== $this->count();
    }

    /**
     * Remove all items from this collection that don't exist in specified collection
     *
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * Returns true if the collection was modified
     *
     * @param CollectionInterface $collection
     * @param bool $strict
     * @return bool
     */
    public function retainAll(CollectionInterface $collection, bool $strict = true): bool
    {
        $size = $this->count();
        foreach ($collection as $element) {
            if (!$this->contains($element)) {
                $this->remove($element, $strict);
            }
        }

        return $size !== $this->count();
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
     * @return Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->elements);
    }

    /**
     * Return true if the elements are equal
     *
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * @param mixed $element1
     * @param mixed $element2
     * @param bool $strict
     * @return bool
     */
    protected function equals($element1, $element2, bool $strict = true): bool
    {
        if ($strict) {
            return $element1 === $element2;
        }

        return $element1 == $element2;
    }
}
