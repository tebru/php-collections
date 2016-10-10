<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\DataStructure;

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
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * @param mixed $element
     * @param bool $strict
     * @return bool
     */
    public function add($element, bool $strict = true): bool;

    /**
     * Adds any elements from specified collection that do not already exist
     *
     * @param CollectionInterface $collection
     * @return bool
     */
    public function addAll(CollectionInterface $collection): bool;
}
