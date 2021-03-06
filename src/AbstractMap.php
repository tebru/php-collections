<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

/**
 * Class AbstractMap
 *
 * A skeletal implementation of [@see MapInterface]
 *
 * @author Nate Brunette <n@tebru.net>
 */
abstract class AbstractMap implements MapInterface
{
    /**
     * Adds all the mappings from specified map to this map
     *
     * @param MapInterface $map
     * @return void
     */
    public function putAll(MapInterface $map): void
    {
        /** @var MapEntry $entrySet */
        foreach ($map->entrySet() as $entrySet) {
            $this->put($entrySet->key, $entrySet->value);
        }
    }

    /**
     * Adds all the mappings from specified array to this map
     *
     * @param array $map
     * @return void
     */
    public function putAllArray(array $map): void
    {
        /** @var MapEntry $entrySet */
        foreach ($map as $key => $value) {
            $this->put($key, $value);
        }
    }

    /**
     * Find the first [@see MapEntry] in map
     *
     * The closure will get passed a MapEntry.  Returning true will end the
     * loop and return that MapEntry
     *
     * @param callable $find
     * @return MapEntry|null
     */
    public function find(callable $find): ?MapEntry
    {
        /** @var MapEntry $mapEntry */
        foreach ($this->entrySet() as $mapEntry) {
            if (true === $find($mapEntry)) {
                return $mapEntry;
            }
        }

        return null;
    }

    /**
     * Use a closure to determine existence in the map
     *
     * The closure will get passed a [@see MapEntry].  Returning true from the
     * closure will return true from this method.
     *
     * @param callable $exists
     * @return bool
     */
    public function exists(callable $exists): bool
    {
        /** @var MapEntry $mapEntry */
        foreach ($this->entrySet() as $mapEntry) {
            if (true === $exists($mapEntry)) {
                return true;
            }
        }

        return false;
    }
}
