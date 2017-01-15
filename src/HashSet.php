<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

use ArrayIterator;

/**
 * Class HashSet
 *
 * An [@see SetInterface] backed by a [@see HashMap]
 *
 * @author Nate Brunette <n@tebru.net>
 */
class HashSet extends AbstractSet
{
    /**
     * The data storage
     *
     * @var MapInterface
     */
    protected $map;

    /**
     * Constructor
     *
     * Use [@see AbstractSet::add] to ensure uniqueness
     *
     * @param array $elements
     */
    public function __construct(array $elements = null)
    {
        $this->map = new HashMap();

        if (null !== $elements) {
            $this->addAllArray($elements);
        }
    }

    /**
     * Adds the element to the collection if it doesn't exist
     *
     * @param mixed $element
     * @return bool
     */
    public function add($element): bool
    {
        $key = $this->getKey($element);
        if ($this->contains($element)) {
            return false;
        }

        $this->map->put($key, $element);

        return true;
    }

    /**
     * Returns true if the collection contains element
     *
     * @param mixed $element
     * @return bool
     */
    public function contains($element): bool
    {
        $key = $this->getKey($element);

        return $this->map->containsKey($key);
    }

    /**
     * Removes all elements from a collection
     *
     * @return void
     */
    public function clear()
    {
        $this->map->clear();
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
        $collectionKeys = array_map(function ($element) { return $this->getKey($element); }, $collection);

        $size = $this->count();
        foreach ($this as $element) {
            if (!in_array($this->getKey($element), $collectionKeys, true)) {
                $this->remove($element);
            }
        }

        return $size !== $this->count();
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
        $key = $this->getKey($element);
        $size = $this->map->count();
        $this->map->remove($key);

        return $size !== $this->map->count();
    }

    /**
     * Returns an array of all elements in the collection
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->map->values()->toArray();
    }

    /**
     * Retrieve an external iterator
     *
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->toArray());
    }

    /**
     * Return the key to use for the HashMap
     *
     * @param mixed $element
     * @return mixed
     */
    protected function getKey($element)
    {
        return $element;
    }
}
