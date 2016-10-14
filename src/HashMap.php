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
     * Returns true if the key exists in the lookup table
     *
     * @param mixed $key
     * @return bool
     */
    public function containsKey($key): bool
    {
        return array_key_exists($this->hashCode($key), $this->keys);
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
        foreach ($this->keys as $hashCode => $key) {
            $set->add(new MapEntry($key, $this->values[$hashCode]));
        }

        return $set;
    }

    /**
     * Get the value at the specified key
     *
     * @param mixed $key
     * @return mixed
     * @throws \OutOfRangeException if the key doesn't exist
     */
    public function get($key)
    {
        $hashedKey = $this->hashCode($key);
        if (!$this->containsKey($key)) {
            throw new OutOfRangeException(sprintf('Tried to access array at key "%s"', $hashedKey));
        }

        return $this->values[$hashedKey];
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
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function put($key, $value)
    {
        $oldValue = null;
        $hashedKey = $this->hashCode($key);
        if ($this->containsKey($key)) {
            $oldValue = $this->get($key);
            $this->remove($hashedKey);
        }

        $this->keys[$hashedKey] = $key;
        $this->values[$hashedKey] = $value;

        return $oldValue;
    }

    /**
     * Remove the mapping for the key and returns the previous value
     * or null
     *
     * @param mixed $key
     * @return mixed
     */
    public function remove($key)
    {
        $hashedKey = $this->hashCode($key);
        if (!$this->containsKey($key)) {
            return false;
        }

        $oldValue = $this->get($key);
        unset($this->keys[$hashedKey], $this->values[$hashedKey]);

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

    /**
     * Filter the collection using closure
     *
     * The closure will get passed a [@see MapEntry].  Returning true from the
     * closure will include that entry in the new map.
     *
     * @param callable $filter
     * @return MapInterface
     */
    public function filter(callable $filter): MapInterface
    {
        $map = new HashMap();

        /** @var MapEntry $mapEntry */
        foreach ($this->entrySet() as $mapEntry) {
            if (false !== $filter($mapEntry)) {
                $map->put($mapEntry->key, $mapEntry->value);
            }
        }

        return $map;
    }

    /**
     * Generate a hashcode for a php value
     *
     * @param mixed $value
     * @return string
     */
    protected function hashCode($value): string
    {
        $type = gettype($value);
        switch ($type) {
            case 'object':
                return spl_object_hash($value);
            case 'array':
                return md5(serialize($value));
            default:
                return $type . md5($value);
        }
    }
}
