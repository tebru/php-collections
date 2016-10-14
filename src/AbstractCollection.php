<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

/**
 * Class AbstractCollection
 *
 * Provides a skeletal implementation of the [@see CollectionInterface]
 *
 * @author Nate Brunette <n@tebru.net>
 */
abstract class AbstractCollection implements CollectionInterface
{
    /**
     * Ensure all elements of a collection exists in this collection
     *
     * Return true if the collection has changed, and false if it hasn't
     *
     * @param CollectionInterface $collection
     * @return bool
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
     * Remove all items in a collection from this collection
     *
     * Returns true if the collection was modified
     *
     * @param CollectionInterface $collection
     * @return bool
     */
    public function removeAll(CollectionInterface $collection): bool
    {
        $size = $this->count();
        foreach ($collection as $element) {
            $this->remove($element);
        }

        return $size !== $this->count();
    }

    /**
     * Remove all items from this collection that don't exist in specified collection
     *
     * Returns true if the collection was modified
     *
     * @param CollectionInterface $collection
     * @return bool
     */
    public function retainAll(CollectionInterface $collection): bool
    {
        $size = $this->count();
        foreach ($this as $element) {
            if (!$collection->contains($element)) {
                $this->remove($element);
            }
        }

        return $size !== $this->count();
    }

    /**
     * Find the first element in collection
     *
     * The closure will get passed each element.  Returning true will end the
     * loop and return that element
     *
     * @param callable $find
     * @return mixed
     */
    public function find(callable $find)
    {
        foreach ($this as $element) {
            if (true === $find($element)) {
                return $element;
            }
        }
    }

    /**
     * Use a closure to determine existence in the collection
     *
     * The closure will get passed each element.  Returning true from the
     * closure will return true from this method.
     *
     * @param callable $exists
     * @return bool
     */
    public function exists(callable $exists): bool
    {
        foreach ($this as $element) {
            if (true === $exists($element)) {
                return true;
            }
        }

        return false;
    }
}
