<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\DataStructure;

use Countable;
use IteratorAggregate;
use Traversable;

/**
 * Interface CollectionInterface
 *
 * The root interface in the collection hierarchy.  This interface should be
 * implemented on unordered collections that may contain duplicate elements.
 *
 * @author Nate Brunette <n@tebru.net>
 */
interface CollectionInterface extends IteratorAggregate, Countable
{
    /**
     * Ensure the element exists in the collection
     *
     * Returns true if the collection can contain duplicates,
     * and false if it cannot.
     *
     * @param mixed $element
     * @return bool
     */
    public function add($element): bool;

    /**
     * Ensure all elements of a collection exists in this collection
     *
     * Return true if the collection has changed, and false if it hasn't
     *
     * @param CollectionInterface $collection
     * @return mixed
     */
    public function addAll(CollectionInterface $collection): bool;

    /**
     * Removes all elements from a collection
     *
     * @return void
     */
    public function clear();

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
    public function contains($element, bool $strict = true): bool;

    /**
     * Returns true if the collection contains all elements from another collection
     *
     * @param CollectionInterface $collection
     * @return bool
     */
    public function containsAll(CollectionInterface $collection): bool;

    /**
     * Returns true if the collection is empty
     *
     * @return bool
     */
    public function isEmpty(): bool;

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
    public function remove($element, bool $strict = true): bool;

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
    public function removeAll(CollectionInterface $collection, bool $strict = true): bool;

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
    public function retainAll(CollectionInterface $collection, bool $strict = true): bool;

    /**
     * Returns an array of all elements in the collection
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Retrieve an external iterator
     *
     * @return Traversable
     */
    public function getIterator(): Traversable;

    /**
     * Returns the size of the collection
     *
     * @return int
     */
    public function count(): int;
}
