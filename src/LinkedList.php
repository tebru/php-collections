<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

use Exception;
use Iterator;
use OutOfBoundsException;
use SplDoublyLinkedList;

/**
 * Class LinkedList
 *
 * @author Nate Brunette <n@tebru.net>
 */
class LinkedList extends AbstractSequentialList implements DequeInterface
{
    /**
     * @var SplDoublyLinkedList
     */
    private $linkedList;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->linkedList = new SplDoublyLinkedList();
        $this->linkedList->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO);
    }

    /**
     * Returns true if the collection contains element
     *
     * @param mixed $element
     * @return bool
     */
    public function contains($element): bool
    {
        foreach ($this->listIterator() as $item) {
            if ($item === $element) {
                return true;
            }
        }

        return false;
    }

    /**
     * Ensure the element exists in the collection
     *
     * Returns true if the collection can contain duplicates,
     * and false if it cannot.
     *
     * @param mixed $element
     * @return bool
     */
    public function add($element): bool
    {
        $this->addLast($element);

        return true;
    }

    /**
     * Removes all elements from a collection
     *
     * @return void
     */
    public function clear(): void
    {
        while (!$this->linkedList->isEmpty()) {
            $this->linkedList->shift();
        }
    }

    /**
     * Returns the size of the collection
     *
     * @return int
     */
    public function count(): int
    {
        return $this->linkedList->count();
    }

    /**
     * Return a [@see ListIterator] instance
     *
     * @return ListIterator
     */
    public function listIterator(): ListIterator
    {
        return new SplDoublyLinkedListIterator($this->linkedList);
    }

    /**
     * Retrieve an external iterator
     *
     * @return ListIterator
     */
    public function getIterator(): ListIterator
    {
        return $this->listIterator();
    }

    /**
     * Returns true if an element exists at the index
     *
     * @param int $index
     * @return bool
     */
    public function has(int $index): bool
    {
        return $this->linkedList->offsetExists($index);
    }

    /**
     * Returns the index of the last instance of the element, -1 if the element
     * doesn't exist
     *
     * @param mixed $element
     * @return int
     */
    public function lastIndexOf($element): int
    {
        $iterator = $this->descendingIterator();
        foreach ($iterator as $index => $item) {
            if ($item === $element) {
                return $index;
            }
        }

        return -1;
    }

    /**
     * Removes the element at the specified index
     *
     * This returns the element that was previously at this index
     *
     * @param int $index
     * @return mixed
     * @throws \OutOfBoundsException if the index does not exist
     */
    public function removeAt(int $index)
    {
        $previous = null;
        if ($this->has($index)) {
            $previous = $this->get($index);
        }

        $this->linkedList->offsetUnset($index);

        return $previous;
    }

    /**
     * Returns a new ListInterface ranging from $fromIndex inclusive to
     * $toIndex exclusive
     *
     * @param int $fromIndex
     * @param int $toIndex
     * @return ListInterface
     * @throws \OutOfBoundsException If to or from index does not exist
     */
    public function subList(int $fromIndex, int $toIndex): ListInterface
    {
        if (!$this->has($fromIndex) || !$this->has($toIndex - 1)) {
            throw new OutOfBoundsException('Unable to create sub list as $toIndex or $fromIndex do not exist in list');
        }

        $newList = array_slice($this->toArray(), $fromIndex, $toIndex - $fromIndex);

        $list = new static();
        $list->addAllArray($newList);

        return $list;
    }

    /**
     * Insert element in front of queue
     *
     * @param mixed $element
     * @return void
     */
    public function addFirst($element): void
    {
        $this->linkedList->unshift($element);
    }

    /**
     * Insert element at end of queue
     *
     * @param mixed $element
     * @return void
     */
    public function addLast($element): void
    {
        $this->linkedList->push($element);
    }

    /**
     * Retrieves, but does not remove the first element
     *
     * @return mixed
     */
    public function getFirst()
    {
        return $this->linkedList->bottom();
    }

    /**
     * Retrieves, but does not remove the last element
     *
     * @return mixed
     */
    public function getLast()
    {
        return $this->linkedList->top();
    }

    /**
     * Retrieves and removes the head of the queue
     *
     * @return mixed
     */
    public function removeFirst()
    {
        return $this->linkedList->shift();
    }

    /**
     * Retrieves and removes the last element of the queue
     *
     * @return mixed
     */
    public function removeLast()
    {
        return $this->linkedList->pop();
    }

    /**
     * Returns an iterator in reverse order
     *
     * @return Iterator
     */
    public function descendingIterator(): Iterator
    {
        $iterator = clone $this->linkedList;
        $iterator->setIteratorMode(SplDoublyLinkedList::IT_MODE_LIFO);

        return new SplDoublyLinkedListIterator($iterator);
    }

    /**
     * Inserts the element in the front of the queue
     *
     * Returns true on success, false on failure
     *
     * @param mixed $element
     * @return bool
     */
    public function offerFirst($element): bool
    {
        try {
            $this->addFirst($element);
        } catch (Exception $exception) {
            return false;
        }

        return true;
    }

    /**
     * Inserts the element at the end of the queue
     *
     * Returns true on success, false on failure
     *
     * @param mixed $element
     * @return bool
     */
    public function offerLast($element): bool
    {
        try {
            $this->addLast($element);
        } catch (Exception $exception) {
            return false;
        }

        return true;
    }

    /**
     * Retrieves, but does not remove the first element of queue or null if empty
     *
     * @return mixed
     */
    public function peekFirst()
    {
        if ($this->linkedList->isEmpty()) {
            return null;
        }

        return $this->getFirst();
    }

    /**
     * Retrieves, but does not remove the last element of queue or null if empty
     *
     * @return mixed
     */
    public function peekLast()
    {
        if ($this->linkedList->isEmpty()) {
            return null;
        }

        return $this->getLast();
    }

    /**
     * Retrieves and removes the head of the queue and returns null if the
     * queue is empty.
     *
     * @return mixed
     */
    public function pollFirst()
    {
        if ($this->linkedList->isEmpty()) {
            return null;
        }

        return $this->removeFirst();
    }

    /**
     * Retrieves and removes the end of the queue and returns null if the
     * queue is empty.
     *
     * @return mixed
     */
    public function pollLast()
    {
        if ($this->linkedList->isEmpty()) {
            return null;
        }

        return $this->removeLast();
    }

    /**
     * Removes and returns the first element of the queue
     *
     * @return mixed
     */
    public function pop()
    {
        return $this->removeFirst();
    }

    /**
     * Inserts the element at the head of the queue
     *
     * @param mixed $element
     * @return void
     */
    public function push($element): void
    {
        $this->addFirst($element);
    }

    /**
     * Removes the first occurrence of the element
     *
     * @param mixed $element
     * @return bool
     */
    public function removeFirstOccurrence($element): bool
    {
        return $this->remove($element);
    }

    /**
     * Removes the last occurrence of the element
     *
     * @param mixed $element
     * @return bool
     */
    public function removeLastOccurrence($element): bool
    {
        $linkedList = clone $this->linkedList;
        $linkedList->setIteratorMode(SplDoublyLinkedList::IT_MODE_LIFO);
        $iterator = new SplDoublyLinkedListIterator($linkedList);

        while ($iterator->hasNext()) {
            $current = $iterator->current();
            if ($current === $element) {
                $iterator->remove();
                return true;
            }

            $iterator->next();
        }

        return false;
    }

    /**
     * Retrieves, but does not remove the head of the queue
     *
     * @return mixed
     */
    public function element()
    {
        return $this->getFirst();
    }

    /**
     * Inserts the element into the end of the queue if possible
     *
     * Returns true if the element was successfully inserted into the queue
     *
     * @param mixed $element
     * @return bool
     */
    public function offer($element): bool
    {
        return $this->offerLast($element);
    }

    /**
     * Retrieves, but does not remove the head of the queue and returns null if the
     * queue is empty
     *
     * @return mixed
     */
    public function peek()
    {
        return $this->peekFirst();
    }

    /**
     * Retrieves and removes the head of the queue and returns null if the
     * queue is empty.
     *
     * @return mixed
     */
    public function poll()
    {
        return $this->pollFirst();
    }
}
