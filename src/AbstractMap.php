<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

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
}
