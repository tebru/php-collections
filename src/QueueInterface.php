<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

/**
 * Interface QueueInterface
 *
 * @author Nate Brunette <n@tebru.net>
 */
interface QueueInterface extends CollectionInterface
{
    /**
     * Retrieves, but does not remove the head of the queue
     *
     * @return mixed
     */
    public function element();

    /**
     * Inserts the element into the end of the queue if possible
     *
     * Returns true if the element was successfully inserted into the queue
     *
     * @param mixed $element
     * @return bool
     */
    public function offer($element): bool;

    /**
     * Retrieves, but does not remove the head of the queue and returns null if the
     * queue is empty
     *
     * @return mixed
     */
    public function peek();

    /**
     * Retrieves and removes the head of the queue and returns null if the
     * queue is empty.
     *
     * @return mixed
     */
    public function poll();

    /**
     * Retrieves and removes the head of the queue
     *
     * @return mixed
     */
    public function removeFirst();
}
