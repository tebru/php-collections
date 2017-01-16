<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

use SplDoublyLinkedList;

/**
 * Class SplDoublyLinkedListIterator
 *
 * @author Nate Brunette <n@tebru.net>
 */
class SplDoublyLinkedListIterator implements ListIterator
{
    /**
     * @var SplDoublyLinkedList
     */
    private $list;

    /**
     * Constructor
     *
     * @param SplDoublyLinkedList $list
     */
    public function __construct(SplDoublyLinkedList $list)
    {
        $this->list = $list;
        $this->list->rewind();
    }

    /**
     * Return the current element
     *
     * @return mixed
     */
    public function current()
    {
        return $this->list->current();
    }

    /**
     * Return the key of the current element
     *
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->list->key();
    }

    /**
     * Checks if current position is valid
     *
     * @return boolean The return value will be casted to boolean and then evaluated.
     */
    public function valid(): bool
    {
        return $this->list->valid();
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->list->rewind();
    }

    /**
     * Insert element into list at current position
     *
     * @param mixed $element
     * @return void
     */
    public function add($element): void
    {
        $this->list->add($this->key(), $element);
    }

    /**
     * Returns true if the iterator has additional elements moving forward
     *
     * @return bool
     */
    public function hasNext(): bool
    {
        return $this->list->offsetExists($this->key() + 1);
    }

    /**
     * Returns true if the iterator has additional elements moving backward
     *
     * @return bool
     */
    public function hasPrevious(): bool
    {
        return $this->list->offsetExists($this->key() - 1);
    }

    /**
     * Moves the cursor forward and returns the element
     *
     * @return mixed
     */
    public function next()
    {
        $this->list->next();

        return $this->current();
    }

    /**
     * Returns the next index that would be returned by calling [@see next()]
     *
     * @return mixed
     */
    public function nextIndex(): int
    {
        return $this->key() + 1;
    }

    /**
     * Moves the cursor backward and returns the element
     *
     * @return mixed
     */
    public function previous()
    {
        $this->list->prev();

        return $this->current();
    }

    /**
     * Returns the next index that would be returned by calling [@see previous()]
     *
     * @return mixed
     */
    public function previousIndex(): int
    {
        return $this->key() - 1;
    }

    /**
     * Removes the current element
     *
     * @return void
     */
    public function remove(): void
    {
        $this->list->offsetUnset($this->key());
    }

    /**
     * Replaces the current element
     *
     * @param $element
     * @return void
     */
    public function set($element): void
    {
        $this->list->offsetSet($this->key(), $element);
    }
}
