<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

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
    public function clear(): void
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
        return $this->doContainsKey($this->hashCode($key));
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
        return $this->doGet($this->hashCode($key));
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
        return $this->doPut($this->hashCode($key), $key, $value);
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
        return $this->doRemove($this->hashCode($key));
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
    private function getKeys(): array
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
    private function getValues(): array
    {
        return array_map(function (MapEntry $mapEntry) {
            return $mapEntry->value;
        }, $this->elements);
    }

    /**
     * Internal implementation for containsKey()
     *
     * @param string $hashCode
     * @return bool
     */
    private function doContainsKey(string $hashCode): bool
    {
        return array_key_exists($hashCode, $this->elements);
    }

    /**
     * Internal implementation for get()
     *
     * @param string $hashCode
     * @return mixed
     */
    private function doGet(string $hashCode)
    {
        if (!$this->doContainsKey($hashCode)) {
            return null;
        }

        return $this->elements[$hashCode]->value;
    }

    /**
     * Internal implementation for put()
     *
     * @param string $hashCode
     * @param mixed $key
     * @param mixed $value
     * @return mixed|null
     */
    private function doPut(string $hashCode, $key, $value)
    {
        $oldValue = $this->doRemove($hashCode);
        $this->elements[$hashCode] = new MapEntry($key, $value);

        return $oldValue;
    }

    /**
     * Internal implementation for remove()
     *
     * @param string $hashCode
     * @return mixed|null
     */
    private function doRemove(string $hashCode)
    {
        if (!$this->doContainsKey($hashCode)) {
            return null;
        }

        $oldValue = $this->doGet($hashCode);
        unset($this->elements[$hashCode]);

        return $oldValue;
    }
}
