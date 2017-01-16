<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

use Iterator;

/**
 * Interface DequeInterface
 *
 * @author Nate Brunette <n@tebru.net>
 */
interface DequeInterface extends QueueInterface
{
    /**
     * Insert element in front of queue
     *
     * @param mixed $element
     * @return void
     */
    public function addFirst($element): void;

    /**
     * Insert element at end of queue
     *
     * @param mixed $element
     * @return void
     */
    public function addLast($element): void;

    /**
     * Returns an iterator in reverse order
     *
     * @return Iterator
     */
    public function descendingIterator(): Iterator;

    /**
     * Retrieves, but does not remove the first element
     *
     * @return mixed
     */
    public function getFirst();

    /**
     * Retrieves, but does not remove the last element
     *
     * @return mixed
     */
    public function getLast();

    /**
     * Inserts the element in the front of the queue
     *
     * Returns true on success, false on failure
     *
     * @param mixed $element
     * @return bool
     */
    public function offerFirst($element): bool;

    /**
     * Inserts the element at the end of the queue
     *
     * Returns true on success, false on failure
     *
     * @param mixed $element
     * @return bool
     */
    public function offerLast($element): bool;

    /**
     * Retrieves, but does not remove the first element of queue or null if empty
     *
     * @return mixed
     */
    public function peekFirst();

    /**
     * Retrieves, but does not remove the last element of queue or null if empty
     *
     * @return mixed
     */
    public function peekLast();

    /**
     * Retrieves and removes the head of the queue and returns null if the
     * queue is empty.
     *
     * @return mixed
     */
    public function pollFirst();

    /**
     * Retrieves and removes the end of the queue and returns null if the
     * queue is empty.
     *
     * @return mixed
     */
    public function pollLast();

    /**
     * Removes and returns the first element of the queue
     *
     * @return mixed
     */
    public function pop();

    /**
     * Inserts the element at the head of the queue
     *
     * @param mixed $element
     * @return void
     */
    public function push($element): void;

    /**
     * Removes the first occurrence of the element
     *
     * @param mixed $element
     * @return bool
     */
    public function removeFirstOccurrence($element): bool;

    /**
     * Retrieves and removes the last element of the queue
     *
     * @return mixed
     */
    public function removeLast();

    /**
     * Removes the last occurrence of the element
     *
     * @param mixed $element
     * @return bool
     */
    public function removeLastOccurrence($element): bool;
}
