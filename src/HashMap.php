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
     * An array of [@see MapEntry] elements
     *
     * @var MapEntry[]
     */
    protected $elements = [];

    /**
     * Constructor
     *
     * @param array $map
     */
    public function __construct(array $map = [])
    {
        foreach ($map as $key => $value) {
            $this->put($key, $value);
        }
    }

    /**
     * Removes all mappings from map
     *
     * @return void
     */
    public function clear()
    {
        $this->elements = [];
    }

    /**
     * Returns true if the key exists in the lookup table
     *
     * @param mixed $key
     * @return bool
     */
    public function containsKey($key): bool
    {
        return array_key_exists($this->hashCode($key), $this->elements);
    }

    /**
     * Returns true if the value exists in the map
     *
     * @param mixed $value
     * @return bool
     */
    public function containsValue($value): bool
    {
        return $this->exists(function (MapEntry $mapEntry) use ($value) {
            return $mapEntry->value === $value;
        });
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
        $set->addAllArray($this->elements);

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

        return $this->elements[$hashedKey]->value;
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
     * Returns a set of the keys in the map
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
            return new HashSet($this->getKeys());
        }

        $set->addAllArray($this->getKeys());

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
        $oldValue = $this->remove($key);
        $this->elements[$this->hashCode($key)] = new MapEntry($key, $value);

        return false === $oldValue ? null : $oldValue;
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
        if (!$this->containsKey($key)) {
            return false;
        }

        $hashedKey = $this->hashCode($key);
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $oldValue = $this->get($key);
        unset($this->elements[$hashedKey]);

        return $oldValue;
    }

    /**
     * Returns the number of mappings in the map
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->elements);
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
            return new ArrayList($this->getKeys());
        }

        $collection->addAllArray($this->getKeys());

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
            return new ArrayList($this->getValues());
        }

        $collection->addAllArray($this->getValues());

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
        $map = new static();

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

    /**
     * Returns an array of [@see MapEntry] keys
     *
     * @return array
     */
    private function getKeys()
    {
        return array_map(function (MapEntry $mapEntry) {
            return $mapEntry->key;
        }, $this->elements);
    }

    /**
     * Returns an array of [@see MapEntry] values
     *
     * @return array
     */
    private function getValues()
    {
        return array_map(function (MapEntry $mapEntry) {
            return $mapEntry->value;
        }, $this->elements);
    }
}
