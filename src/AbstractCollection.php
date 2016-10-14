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
        return $this->addAllArray($collection->toArray());
    }

    /**
     * Ensure all elements of an array exists in this collection
     *
     * Return true if the collection has changed, and false if it hasn't
     *
     * @param array $collection
     * @return bool
     */
    public function addAllArray(array $collection): bool
    {
        $size = $this->count();
        foreach ($collection as $element) {
            $this->add($element);
        }

        return $size !== $this->count();
    }

    /**
     * Returns true if the collection contains element
     *
     * @param mixed $element
     * @return bool
     */
    public function contains($element): bool
    {
        return in_array($element, $this->toArray(), true);
    }

    /**
     * Returns true if the collection contains all elements from another collection
     *
     * @param CollectionInterface $collection
     * @return bool
     */
    public function containsAll(CollectionInterface $collection): bool
    {
        return $this->containsAllArray($collection->toArray());
    }

    /**
     * Returns true if the collection contains all elements from an array
     *
     * @param array $collection
     * @return bool
     */
    public function containsAllArray(array $collection): bool
    {
        foreach ($collection as $element) {
            if (!$this->contains($element)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns the size of the collection
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->toArray());
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
        return $this->removeAllArray($collection->toArray());
    }

    /**
     * Remove all items in an array from this collection
     *
     * Returns true if the collection was modified
     *
     * @param array $collection
     * @return bool
     */
    public function removeAllArray(array $collection): bool
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
        return $this->retainAllArray($collection->toArray());
    }

    /**
     * Remove all items from this collection that don't exist in specified array
     *
     * Returns true if the collection was modified
     *
     * @param array $collection
     * @return bool
     */
    public function retainAllArray(array $collection): bool
    {
        $size = $this->count();
        foreach ($this as $element) {
            if (!in_array($element, $collection, true)) {
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

        return null;
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
