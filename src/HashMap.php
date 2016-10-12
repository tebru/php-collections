<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

use OutOfRangeException;

/**
 * Class HashMap
 *
 * [@see MapInterface] implementation
 *
 * @author Nate Brunette <n@tebru.net>
 */
class HashMap extends AbstractMap
{
    /**
     * The mapping keys
     *
     * @var array
     */
    protected $keys = [];

    /**
     * The mapping values
     *
     * @var array
     */
    protected $values = [];

    /**
     * Removes all mappings from map
     *
     * @return void
     */
    public function clear()
    {
        $this->keys = [];
        $this->values = [];
    }

    /**
     * Returns true if the key exists in the map
     *
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * @param mixed $key
     * @param bool $strict
     * @return bool
     */
    public function containsKey($key, bool $strict = true): bool
    {
        return in_array($key, $this->keys, $strict);
    }

    /**
     * Returns true if the value exists in the map
     *
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * @param mixed $value
     * @param bool $strict
     * @return bool
     */
    public function containsValue($value, bool $strict = true): bool
    {
        return in_array($value, $this->values, $strict);
    }

    /**
     * Return a set representation of map
     *
     * If a set is passed in, that set will be populated, otherwise
     * a default set will be used.
     *
     * @param SetInterface $set
     * @return SetInterface
     */
    public function entrySet(SetInterface $set = null): SetInterface
    {
        $set = $set ?? new HashSet();
        foreach ($this->keys as $index => $key) {
            $set->add(new MapEntry($key, $this->values[$index]));
        }

        return $set;
    }

    /**
     * Get the value at the specified key
     *
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * @param mixed $key
     * @param bool $strict
     * @return mixed
     * @throws \OutOfRangeException if the key doesn't exist
     */
    public function get($key, bool $strict = true)
    {
        if (!$this->containsKey($key, $strict)) {
            throw new OutOfRangeException(sprintf('Tried to access array at key "%s"', $key));
        }

        $index = array_search($key, $this->keys, $strict);

        return $this->values[$index];
    }

    /**
     * Returns true if the map is empty
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return 0 === $this->count();
    }

    /**
     * Returns a set of they keys in the map
     *
     * If a set is passed in, that set will be populated, otherwise
     * a default set will be used.
     *
     * @param SetInterface $set
     * @return SetInterface
     */
    public function keySet(SetInterface $set = null): SetInterface
    {
        if (null === $set) {
            return new HashSet(new ArrayList($this->keys));
        }

        $set->addAll(new ArrayList($this->keys));

        return $set;
    }

    /**
     * Returns the previous value or null if there was no value
     *
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * @param mixed $key
     * @param mixed $value
     * @param bool $strict
     * @return mixed
     * @throws \OutOfRangeException if the key doesn't exist
     */
    public function put($key, $value, bool $strict = true)
    {
        $oldValue = null;
        if ($this->containsKey($key, $strict)) {
            $oldValue = $this->get($key, $strict);
            $this->remove($key, $strict);
        }

        $this->keys[] = $key;
        $this->values[] = $value;

        return $oldValue;
    }

    /**
     * Remove the mapping for the key and returns the previous value
     * or null
     *
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * @param mixed $key
     * @param bool $strict
     * @return mixed
     */
    public function remove($key, bool $strict = true)
    {
        if (!$this->containsKey($key, $strict)) {
            return false;
        }

        $oldValue = $this->get($key, $strict);
        $index = array_search($key, $this->keys, $strict);

        array_splice($this->keys, $index, 1);
        array_splice($this->values, $index, 1);

        return $oldValue;
    }

    /**
     * Returns the number of mappings in the map
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->keys);
    }

    /**
     * Returns the keys as a collection
     *
     * @param CollectionInterface $collection
     * @return CollectionInterface
     */
    public function keys(CollectionInterface $collection = null): CollectionInterface
    {
        if (null === $collection) {
            return new ArrayList($this->keys);
        }

        $collection->addAll(new ArrayList($this->keys));

        return $collection;
    }

    /**
     * Returns the values as a collection
     *
     * @param CollectionInterface $collection
     * @return CollectionInterface
     */
    public function values(CollectionInterface $collection = null): CollectionInterface
    {
        if (null === $collection) {
            return new ArrayList($this->values);
        }

        $collection->addAll(new ArrayList($this->values));

        return $collection;
    }
}
