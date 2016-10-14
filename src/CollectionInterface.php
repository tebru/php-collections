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
     * @return bool
     */
    public function addAll(CollectionInterface $collection): bool;

    /**
     * Ensure all elements of an array exists in this collection
     *
     * Return true if the collection has changed, and false if it hasn't
     *
     * @param array $collection
     * @return bool
     */
    public function addAllArray(array $collection): bool;

    /**
     * Removes all elements from a collection
     *
     * @return void
     */
    public function clear();

    /**
     * Returns true if the collection contains element
     *
     * @param mixed $element
     * @return bool
     */
    public function contains($element): bool;

    /**
     * Returns true if the collection contains all elements from another collection
     *
     * @param CollectionInterface $collection
     * @return bool
     */
    public function containsAll(CollectionInterface $collection): bool;

    /**
     * Returns true if the collection contains all elements from an array
     *
     * @param array $collection
     * @return bool
     */
    public function containsAllArray(array $collection): bool;

    /**
     * Returns true if the collection is empty
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Removes object if it exists
     *
     * Returns true if the element was removed
     *
     * @param mixed $element
     * @return bool
     */
    public function remove($element): bool;

    /**
     * Remove all items in a collection from this collection
     *
     * Returns true if the collection was modified
     *
     * @param CollectionInterface $collection
     * @return bool
     */
    public function removeAll(CollectionInterface $collection): bool;

    /**
     * Remove all items in an array from this collection
     *
     * Returns true if the collection was modified
     *
     * @param array $collection
     * @return bool
     */
    public function removeAllArray(array $collection): bool;

    /**
     * Remove all items from this collection that don't exist in specified collection
     *
     * Returns true if the collection was modified
     *
     * @param CollectionInterface $collection
     * @return bool
     */
    public function retainAll(CollectionInterface $collection): bool;

    /**
     * Remove all items from this collection that don't exist in specified array
     *
     * Returns true if the collection was modified
     *
     * @param array $collection
     * @return bool
     */
    public function retainAllArray(array $collection): bool;

    /**
     * Returns an array of all elements in the collection
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Find the first element in collection
     *
     * The closure will get passed each element.  Returning true will end the
     * loop and return that element
     *
     * @param callable $find
     * @return mixed
     */
    public function find(callable $find);

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
