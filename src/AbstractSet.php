<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\DataStructure;

/**
 * Class AbstractSet
 *
 * Default implementation of the [@see SetInterface]
 *
 * @author Nate Brunette <n@tebru.net>
 */
abstract class AbstractSet extends AbstractCollection implements SetInterface
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
    public function add($element, bool $strict = true): bool
    {
        if ($this->contains($element, $strict)) {
            return false;
        }

        parent::add($element);

        return true;
    }

    /**
     * Adds any elements from specified collection that do not already exist
     *
     * By default this method will use strict comparison checking, passing false
     * in will use a double equals (==) instead.
     *
     * @param CollectionInterface $collection
     * @param bool $strict
     * @return bool
     */
    public function addAll(CollectionInterface $collection, bool $strict = true): bool
    {
        $size = $this->count();
        foreach ($collection as $element) {
            $this->add($element, $strict);
        }

        return $size !== $this->count();
    }
}
