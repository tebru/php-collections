<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\DataStructure;

use IteratorIterator;

/**
 * Class HashSet
 *
 * @author Nate Brunette <n@tebru.net>
 */
class HashSet extends AbstractSet
{
    /**
     * @var MapInterface
     */
    protected $map;

    /**
     * Constructor
     *
     * Use [@see AbstractSet::add] to ensure uniqueness
     *
     * @param CollectionInterface $elements
     */
    public function __construct(CollectionInterface $elements = null)
    {
        $this->map = new HashMap();

        if (null !== $elements) {
            $this->addAll($elements);
        }
    }

    /**
     * Adds the element to the collection if it doesn't exist
     *
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * @param mixed $element
     * @param bool $strict
     * @return bool
     */
    public function add($element, bool $strict = true): bool
    {
        if ($this->contains($element, $strict)) {
            return false;
        }

        $this->map->put($element, true);

        return true;
    }

    /**
     * Adds any elements from specified collection that do not already exist
     *
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * @param CollectionInterface $collection
     * @param bool $strict
     * @return bool
     */
    public function addAll(CollectionInterface $collection, bool $strict = true): bool
    {
        $size = $this->count();
        foreach ($collection as $element) {
            $this->add($element, $strict);
        }

        return $size !== $this->count();
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
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * Returns true if the element was removed
     *
     * @param mixed $element
     * @param bool $strict
     * @return bool
     */
    public function remove($element, bool $strict = true): bool
    {
        $size = $this->map->count();
        $this->map->remove($element, $strict);

        return $size !== $this->map->count();
    }

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
    public function contains($element, bool $strict = true): bool
    {
        return $this->map->containsKey($element, $strict);
    }

    /**
     * Returns an array of all elements in the collection
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->map->keySet()->toArray();
    }

    /**
     * Retrieve an external iterator
     *
     * @return IteratorIterator
     */
    public function getIterator(): IteratorIterator
    {
        return new IteratorIterator($this->map->entrySet());
    }

    /**
     * Returns the size of the collection
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->map);
    }
}
