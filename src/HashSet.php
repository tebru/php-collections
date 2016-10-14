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
        if ($this->contains($element)) {
            return false;
        }

        $this->map->put($element, true);

        return true;
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
     * Removes object if it exists
     *
     * Returns true if the element was removed
     *
     * @param mixed $element
     * @return bool
     */
    public function remove($element): bool
    {
        $size = $this->map->count();
        $this->map->remove($element);

        return $size !== $this->map->count();
    }

    /**
     * Returns an array of all elements in the collection
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->map->keys()->toArray();
    }

    /**
     * Filter the collection using closure
     *
     * The closure will get passed each element.  Returning true from the
     * closure will include that element in the new collection.
     *
     * @param callable $filter
     * @return CollectionInterface
     */
    public function filter(callable $filter): CollectionInterface
    {
        return new static(array_filter($this->toArray(), $filter));
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
}
