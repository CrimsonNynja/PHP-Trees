<?php

namespace PhpTrees;

/**
 * implementation of a stack
 */
class Stack
{
    private array $container = [];

    /**
     * pushes the given values onto the stack
     * @param mixed ...$vars the vars to place on the stack
     */
    public function push(mixed ...$vars) : void
    {
        foreach($vars as $var) {
            $this->container[] = $var;
        }
    }

    /**
     *  pops the last element off the stack and returns the element popped
     * @return mixed the element popped
     */
    public function pop() : mixed
    {
        return array_pop(array: $this->container);
    }

    /**
     * shows the element on top of the stack
     * @return mixed the element on top of the stack
     */
    public function peek() : mixed
    {
        return end(array: $this->container);
    }

    /**
     * empties the stack
     */
    public function clear() : void
    {
        $this->container = [];
    }

    /**
     * gets the size of the stack
     * @return int the size of the stack
     */
    public function getSize() : int
    {
        return sizeof($this->container);
    }

    /**
     * checks if the stack is empty
     * @return bool true if the stack is empty
     */
    public function isEmpty() : bool
    {
        if (sizeof($this->container) > 0) {
            return false;
        }
        return true;
    }

    /**
     * gets the stack as an array
     * @return array|null the array representation of the stack
     */
    public function getAsArray() : ?array
    {
        return $this->container;
    }
}
