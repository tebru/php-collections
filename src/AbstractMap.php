<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\DataStructure;

use ArrayIterator;
use OutOfRangeException;
use Traversable;

/**
 * Class AbstractMap
 *
 * Default implementation of [@see MapInterface]
 *
 * @author Nate Brunette <n@tebru.net>
 */
abstract class AbstractMap implements MapInterface
{
    /**
     * The map mappings as key => value
     *
     * @var array
     */
    protected $mappings = [];

    /**
     * Removes all mappings from map
     *
     * @return void
     */
    public function clear()
    {
        $this->mappings = [];
    }

    /**
     * Returns true if the key exists in the map
     *
     * @param string $key
     * @return bool
     */
    public function containsKey(string $key): bool
    {
        return array_key_exists($key, $this->mappings);
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
        foreach ($this->mappings as $key => $mappingValue) {
            if ($this->equals($mappingValue, $value, $strict)) {
                return true;
            }
        }

        return false;
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
        foreach ($this->mappings as $key => $value) {
            $set->add([$key => $value]);
        }

        return $set;
    }

    /**
     * Get the value at the specified key
     *
     * @param string $key
     * @return mixed
     * @throws \OutOfRangeException if the key doesn't exist
     */
    public function get(string $key)
    {
        $this->assertKey($key);

        return $this->mappings[$key];
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
            return new HashSet(array_keys($this->mappings));
        }

        $keys = array_keys($this->mappings);
        foreach ($keys as $key) {
            $set->add($key);
        }

        return $set;
    }

    /**
     * Returns the previous value or null if there was no value
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function put(string $key, $value)
    {
        $oldValue = null;
        if ($this->containsKey($key)) {
            $oldValue = $this->get($key);
        }

        $this->mappings[$key] = $value;

        return $oldValue;
    }

    /**
     * Adds all the mappings from specified map to this map
     *
     * @param MapInterface $map
     * @return void
     */
    public function putAll(MapInterface $map)
    {
        foreach ($map->entrySet() as $item) {
            $this->put(key($item), current($item));
        }
    }

    /**
     * Returns the number of mappings in the map
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->mappings);
    }

    /**
     * Returns the values as a collection
     *
     * @param CollectionInterface $collection
     * @return CollectionInterface
     */
    public function values(CollectionInterface $collection = null): CollectionInterface
    {
        $values = array_values($this->mappings);
        if (null === $collection) {
            return new ArrayList($values);
        }

        $collection->addAll(new ArrayList($values));

        return $collection;
    }

    /**
     * Retrieve an external iterator
     *
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->mappings);
    }

    /**
     * Return true if the elements are equal
     *
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * @param mixed $value1
     * @param mixed $value2
     * @param bool $strict
     * @return bool
     */
    protected function equals($value1, $value2, bool $strict = true): bool
    {
        if ($strict) {
            return $value1 === $value2;
        }

        return $value1 == $value2;
    }

    /**
     * Ensure that the key exists
     *
     * @param string $key
     * @throws \OutOfRangeException if the key doesn't exist
     */
    protected function assertKey(string $key)
    {
        if (!$this->containsKey($key)) {
            throw new OutOfRangeException(sprintf('Tried to access array at key "%s"', $key));
        }
    }
}
