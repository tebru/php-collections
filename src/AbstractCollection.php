<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

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
     * Returns true if the collection contains all elements from another collection
     *
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * @param CollectionInterface $collection
     * @param bool $strict
     * @return bool
     */
    public function containsAll(CollectionInterface $collection, bool $strict = true): bool
    {
        $containsAll = true;
        foreach ($collection as $element) {
            if (!$this->contains($element, $strict)) {
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
            if (!$this->contains($element, $strict)) {
                $this->remove($element, $strict);
            }
        }

        return $size !== $this->count();
    }
}
