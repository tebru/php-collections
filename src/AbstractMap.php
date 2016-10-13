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
    public function putAll(MapInterface $map)
    {
        /** @var MapEntry $entrySet */
        foreach ($map->entrySet() as $entrySet) {
            $this->put($entrySet->key, $entrySet->value);
        }
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
