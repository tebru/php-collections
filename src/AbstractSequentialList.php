<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

use OutOfBoundsException;

/**
 * Class AbstractSequentialList
 *
 * @author Nate Brunette <n@tebru.net>
 */
abstract class AbstractSequentialList extends AbstractList
{
    /**
     * Return a [@see ListIterator] instance
     *
     * @return ListIterator
     */
    abstract public function listIterator(): ListIterator;

    /**
     * Returns the index of the first instance of the element, -1 if the element
     * doesn't exist
     *
     * @param mixed $element
     * @return int
     */
    public function indexOf($element): int
    {
        $iterator = $this->listIterator();
        foreach ($iterator as $index => $item) {
            if ($item === $element) {
                return $index;
            }
        }

        return -1;
    }

    /**
     * Returns the element at the index
     *
     * @param int $index
     * @return mixed
     * @throws \OutOfBoundsException if the index does not exist
     */
    public function get(int $index)
    {
        $iterator = $this->listIterator();
        while ($iterator->nextIndex() < $index) {
            $iterator->next();
        }

        return $iterator->next();
    }

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
    public function set(int $index, $element)
    {
        $iterator = $this->listIterator();
        while ($iterator->nextIndex() < $index) {
            $iterator->next();
        }

        $oldElement = $iterator->next();
        $iterator->set($element);

        return $oldElement;
    }

    /**
     * Insert element at the specified index
     *
     * @param int $index
     * @param mixed $element
     * @return void
     */
    public function insert(int $index, $element): void
    {
        $iterator = $this->listIterator();
        while ($iterator->nextIndex() < $index) {
            $iterator->next();
        }

        $iterator->next();
        $iterator->add($element);
    }

    /**
     * Inserts all elements of a collection at index
     *
     * @param int $index
     * @param CollectionInterface $collection
     * @return bool
     */
    public function insertAll(int $index, CollectionInterface $collection): bool
    {
        $iterator = $this->listIterator();
        while ($iterator->nextIndex() < $index) {
            $iterator->next();
        }

        $iterator->next();
        foreach ($collection as $element) {
            $iterator->add($element);
            $iterator->next();
        }

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
        $iterator = $this->listIterator();
        while ($iterator->hasNext()) {
            $current = $iterator->current();
            if ($current === $element) {
                $iterator->remove();
                return true;
            }

            $iterator->next();
        }

        if ($iterator->current() === $element) {
            $iterator->remove();
            return true;
        }

        return false;
    }

    /**
     * Returns an array of all elements in the collection
     *
     * @return array
     */
    public function toArray(): array
    {
        $returnArray = [];

        if ($this->isEmpty()) {
            return $returnArray;
        }

        $iterator = $this->listIterator();
        $returnArray[] = $iterator->current();

        while ($iterator->hasNext()) {
            $returnArray[] = $iterator->next();
        }

        return $returnArray;
    }

    protected function assertIndex(int $index)
    {
        if ($index < 0 || $index > $this->count() - 1) {
            throw new OutOfBoundsException(sprintf('Element unable to be set at index "%s"', $index));
        }
    }
}
