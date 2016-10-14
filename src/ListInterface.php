<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

/**
 * Interface ListInterface
 *
 * An ordered collection where the user can control where elements are
 * inserted in the list.
 *
 * @author Nate Brunette <n@tebru.net>
 */
interface ListInterface extends CollectionInterface
{
    /**
     * Add an element to the end of the list
     *
     * @param mixed $element
     * @return bool
     */
    public function add($element): bool;

    /**
     * Insert element at the specified index
     *
     * @param int $index
     * @param mixed $element
     * @return void
     */
    public function insert(int $index, $element);

    /**
     * All all elements of collection to end of list
     *
     * @param CollectionInterface $collection
     * @return bool
     */
    public function addAll(CollectionInterface $collection): bool;

    /**
     * Inserts all elements of a collection at index
     *
     * @param int $index
     * @param CollectionInterface $collection
     * @return bool
     */
    public function insertAll(int $index, CollectionInterface $collection): bool;

    /**
     * Returns the element at the index
     *
     * @param int $index
     * @return mixed
     * @throws \OutOfBoundsException if the index does not exist
     */
    public function get(int $index);

    /**
     * Returns true if an element exists at the index
     *
     * @param int $index
     * @return bool
     */
    public function has(int $index): bool;

    /**
     * Returns the index of the first instance of the element, -1 if the element
     * doesn't exist
     *
     * @param mixed $element
     * @return int
     */
    public function indexOf($element): int;

    /**
     * Returns the index of the last instance of the element, -1 if the element
     * doesn't exist
     *
     * @param mixed $element
     * @return int
     */
    public function lastIndexOf($element): int;

    /**
     * Remove the first instance of the element
     *
     * @param mixed $element
     * @return bool
     */
    public function remove($element): bool;

    /**
     * Removes the element at the specified index
     *
     * This returns the element that was previously at this index
     *
     * @param int $index
     * @return mixed
     * @throws \OutOfBoundsException if the index does not exist
     */
    public function removeAt(int $index);

    /**
     * Replace the element at the specified index
     *
     * Returns the element that was previously at this index
     *
     * @param int $index
     * @param mixed $element
     * @return mixed
     * @throws \OutOfBoundsException if the index does not exist
     */
    public function set(int $index, $element);

    /**
     * Returns a new ListInterface ranging from $fromIndex inclusive to
     * $toIndex exclusive
     *
     * @param int $fromIndex
     * @param int $toIndex
     * @return ListInterface
     */
    public function subList(int $fromIndex, int $toIndex): ListInterface;
}
