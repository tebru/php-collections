<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

use Countable;
use IteratorAggregate;

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
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * @param mixed $element
     * @param bool $strict
     * @return bool
     */
    public function add($element, bool $strict = true): bool;

    /**
     * Ensure all elements of a collection exists in this collection
     *
     * Return true if the collection has changed, and false if it hasn't
     *
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * @param CollectionInterface $collection
     * @param bool $strict
     * @return bool|mixed
     */
    public function addAll(CollectionInterface $collection, bool $strict = true): bool;

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
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * @param CollectionInterface $collection
     * @param bool $strict
     * @return bool
     */
    public function containsAll(CollectionInterface $collection, bool $strict = true): bool;

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
     * Filter the collection using closure
     *
     * The closure will get passed each element.  Returning true from the
     * closure will include that element in the new collection.
     *
     * @param callable $filter
     * @return CollectionInterface
     */
    public function filter(callable $filter): CollectionInterface;

    /**
     * Use a closure to determine existence in the collection
     *
     * The closure will get passed each element.  Returning true from the
     * closure will return true from this method.
     *
     * @param callable $exists
     * @return bool
     */
    public function exists(callable $exists): bool;

    /**
     * Returns the size of the collection
     *
     * @return int
     */
    public function count(): int;
}
