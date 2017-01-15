<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

use Countable;

/**
 * Interface MapInterface
 *
 * Represents an object with keys and values.  Keys must be unique.
 *
 * @author Nate Brunette <n@tebru.net>
 */
interface MapInterface extends Countable
{
    /**
     * Removes all mappings from map
     *
     * @return void
     */
    public function clear();

    /**
     * Returns true if the key exists in the map
     *
     * @param mixed $key
     * @return bool
     */
    public function containsKey($key): bool;

    /**
     * Returns true if the value exists in the map
     *
     * @param mixed $value
     * @return bool
     */
    public function containsValue($value): bool;

    /**
     * Return a set representation of map
     *
     * If a set is passed in, that set will be populated, otherwise
     * a default set will be used.
     *
     * @param SetInterface $set
     * @return SetInterface
     */
    public function entrySet(SetInterface $set = null): SetInterface;

    /**
     * Get the value at the specified key
     *
     * @param mixed $key
     * @return mixed
     */
    public function get($key);

    /**
     * Returns true if the map is empty
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Returns a set of the keys in the map
     *
     * If a set is passed in, that set will be populated, otherwise
     * a default set will be used.
     *
     * @param SetInterface $set
     * @return SetInterface
     */
    public function keySet(SetInterface $set = null): SetInterface;

    /**
     * Returns the previous value or null if there was no value
     *
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function put($key, $value);

    /**
     * Adds all the mappings from specified map to this map
     *
     * @param MapInterface $map
     * @return void
     */
    public function putAll(MapInterface $map);

    /**
     * Adds all the mappings from specified array to this map
     *
     * @param array $map
     * @return void
     */
    public function putAllArray(array $map);

    /**
     * Remove the mapping for the key and returns the previous value
     * or null
     *
     * @param mixed $key
     * @return mixed
     */
    public function remove($key);

    /**
     * Returns the keys as a collection
     *
     * If a collection is passed in, that collection will be populated, otherwise
     * a default collection will be used.
     *
     * @param CollectionInterface $collection
     * @return CollectionInterface
     */
    public function keys(CollectionInterface $collection = null): CollectionInterface;

    /**
     * Returns the values as a collection
     *
     * If a collection is passed in, that collection will be populated, otherwise
     * a default collection will be used.
     *
     * @param CollectionInterface $collection
     * @return CollectionInterface
     */
    public function values(CollectionInterface $collection = null): CollectionInterface;

    /**
     * Filter the collection using closure
     *
     * The closure will get passed a [@see MapEntry].  Returning true from the
     * closure will include that entry in the new map.
     *
     * @param callable $filter
     * @return MapInterface
     */
    public function filter(callable $filter): MapInterface;

    /**
     * Find the first [@see MapEntry] in map
     *
     * The closure will get passed a MapEntry.  Returning true will end the
     * loop and return that MapEntry
     *
     * @param callable $find
     * @return MapEntry|null
     */
    public function find(callable $find);

    /**
     * Use a closure to determine existence in the map
     *
     * The closure will get passed a [@see MapEntry].  Returning true from the
     * closure will return true from this method.
     *
     * @param callable $exists
     * @return bool
     */
    public function exists(callable $exists): bool;

    /**
     * Returns the number of mappings in the map
     *
     * @return int
     */
    public function count(): int;
}
