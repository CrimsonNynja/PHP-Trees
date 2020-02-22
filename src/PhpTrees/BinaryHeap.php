<?php

namespace PhpTrees;

/**
 * implementation of a binary heap (currently just a Min Heap)
 * this is an array implementation, and as such stores everything in an array internally
 */
class BinaryHeap
{
    /* internal array to store the heap in */
    private array $heap = [];
    /* comparator for any non standard objects */
    private $comparator = null;

    /**
     * constructs the heap with the initial root, if given
     * as this is a heap the root value may not remain consistent
     *
     * @param mixed|null $root the initial root of the heap
     * @param callable|null $comparator custom comparator for any non standard objects stored in the heap in the form func ($a, $b) and returns true if $a > $b
     */
    public function __construct($root = null, ?callable $comparator = null)
    {
        if ($root !== null) {
            $this->insert($root);
        }
        $this->comparator = $comparator;
    }

    /**
     * constructs a heap from an array
     * this function will be much faster then inserting each element from that array individually
     * Note that if any values in the heap already exists, they will be replaced here
     *
     * @param array<mixed> $values the array to build the heap on
     */
    public function constructFromArray(array $values) : void
    {
        $this->heap = $values;
        $this->heapify();
    }

    /**
     * inserts a value into the heap
     *
     * @param mixed $value the value to add
     */
    public function insert($value) : void
    {
        $this->heap[] = $value;
        $this->bubbleUp(sizeof($this->heap) - 1);
    }

    /**
     * inserts multiple values into the heap
     *
     * @param mixed ...$values the variatic values to add, can be of differing types
     */
    public function insertMultiple(...$values) : void
    {
        foreach($values as $value) {
            $this->insert($value);
        }
    }

    /**
     * deletes the minimum value from the heap
     *
     * @return mixed returns teh element removed
     */
    public function deleteMin()
    {
        if ($this->heap !== []) {
            $ret = $this->heap[0];
            $this->heap[0] = array_pop($this->heap);
            $this->bubbleDown(0);
            return $ret;
        }
    }

    /**
     * gets the smallest value in the heap, if it exists
     *
     * @return mixed|null the smallest value in the heap
     */
    public function getMinValue()
    {
        if ($this->heap !== []) {
            return $this->heap[0];
        }
        return null;
    }

    /**
     * gets the max element in the heap, if it exists
     *
     * @return mixed|null the maximum element in the heap
     */
    public function getMaxValue()
    {
        if ($this->heap !== []) {
            $max = $this->heap[(int)sizeof($this->heap) / 2];
            for ($i = 1 + (sizeof($this->heap) / 2); $i < sizeof($this->heap); ++$i) {
                $max = max($max, $this->heap[$i]);
            }
            return $max;
        }
        return null;
    }

    /**
     * gets the internal representation of the heap
     *
     * @return array the heap representation in the array
     */
    public function getInternalArray() : array
    {
        return $this->heap;
    }

    /**
     * gets the amount of elements in the heap
     *
     * @return int the size of the heap
     */
    public function getSize() : int
    {
        return sizeof($this->heap);
    }

    /**
     * checks if the heap has a comparator
     *
     * @return bool true if the heap has a custom comparator
     */
    public function hasComparator() : bool
    {
        if ($this->comparator === null) {
            return false;
        }
        return true;
    }

    /**
     * rebuilds the heap. This is useful if you want a heap from an array
     */
    private function heapify() : void
    {
        for ($i = sizeof($this->heap) - 1; $i >= 0; --$i) {
            $this->bubbleDown($i);
        }
    }

    /**
     * bubbles up the value in the heap, if it needs to
     *
     * @param int $index the index to start bubbling up from
     */
    private function bubbleUp(int $index) : void
    {
        if ($index === 0) {
            return;
        }

        $parentIndex = (int)($index - 1) / 2;

        if ($this->comparator !== null) {
            if ($this->comparator->__invoke($this->heap[$parentIndex], $this->heap[$index])) {
                $dummy = $this->heap[$parentIndex];
                $this->heap[$parentIndex] = $this->heap[$index];
                $this->heap[$index] = $dummy;
                $this->bubbleUp($parentIndex);
            }
        }
        else {
            if ($this->heap[$parentIndex] > $this->heap[$index]) {
                $dummy = $this->heap[$parentIndex];
                $this->heap[$parentIndex] = $this->heap[$index];
                $this->heap[$index] = $dummy;
                $this->bubbleUp($parentIndex);
            }
        }
    }

    /**
     * turns an array into a heap
     * more efficient then inserting each element individually if an array is already created
     *
     * @param int $index the index to bubble down on
     */
    private function bubbleDown(int $index) : void
    {
        $length = sizeof($this->heap);
        $leftIndex = (2 * $index) + 1;
        $rightIndex = (2 * $index) + 2;

        if ($leftIndex >= $length) {
            return;
        }

        $minIndex = $index;

        if ($this->comparator !== null) {
            if ($this->comparator->__invoke($this->heap[$index], $this->heap[$leftIndex])) {
                $minIndex = $leftIndex;
            }
        }
        else {
            if ($this->heap[$index] > $this->heap[$leftIndex]) {
                $minIndex = $leftIndex;
            }
        }

        if (($rightIndex < $length)) {
            if ($this->comparator !== null) {
                if ($this->comparator->__invoke($this->heap[$minIndex], $this->heap[$rightIndex])) {
                    $minIndex = $rightIndex;
                }
            }
            else {
                if ($this->heap[$minIndex] > $this->heap[$rightIndex]) {
                    $minIndex = $rightIndex;
                }
            }
        }

        if ($minIndex !== $index) {
            $dummy = $this->heap[$index];
            $this->heap[$index] = $this->heap[$minIndex];
            $this->heap[$minIndex] = $dummy;
            $this->bubbleDown($minIndex);
        }
    }
}
