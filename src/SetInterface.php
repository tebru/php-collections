<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

/**
 * Interface SetInterface
 *
 * @author Nate Brunette <n@tebru.net>
 */
interface SetInterface extends CollectionInterface
{
    /**
     * Adds the element to the collection if it doesn't exist
     *
     * @param mixed $element
     * @return bool
     */
    public function add($element): bool;

    /**
     * Adds any elements from specified collection that do not already exist
     *
     * @param CollectionInterface $collection
     * @return bool
     */
    public function addAll(CollectionInterface $collection): bool;
}
