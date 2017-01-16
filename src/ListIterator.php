<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

use Iterator;

/**
 * Interface ListIterator
 *
 * @author Nate Brunette <n@tebru.net>
 */
interface ListIterator extends Iterator
{
    /**
     * Insert element into list at current position
     *
     * @param mixed $element
     * @return void
     */
    public function add($element): void;

    /**
     * Returns true if the iterator has additional elements moving forward
     *
     * @return bool
     */
    public function hasNext(): bool;

    /**
     * Returns true if the iterator has additional elements moving backward
     *
     * @return bool
     */
    public function hasPrevious(): bool;

    /**
     * Moves the cursor forward and returns the element
     *
     * @return mixed
     */
    public function next();

    /**
     * Returns the next index that would be returned by calling [@see next()]
     *
     * @return mixed
     */
    public function nextIndex(): int;

    /**
     * Moves the cursor backward and returns the element
     *
     * @return mixed
     */
    public function previous();

    /**
     * Returns the next index that would be returned by calling [@see previous()]
     *
     * @return mixed
     */
    public function previousIndex(): int;

    /**
     * Removes the current element
     *
     * @return void
     */
    public function remove(): void;

    /**
     * Replaces the current element
     *
     * @param $element
     * @return void
     */
    public function set($element): void;
}
