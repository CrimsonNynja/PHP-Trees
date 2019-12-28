<?php

namespace PhpTrees;

use PhpTrees\Node;
use PhpTrees\Stack;

/**
 * implementation of a binary tree
 */
class BinarySearchTree implements \Iterator
{
    /* the root of the tree */
    private $root = null;
    /* used for iterating over the tree */
    private $iteratorPosition = false;
    /* used for iterating through the tree */
    private $iteratorStack = null;

    /**
     * constructs a new BinarySearchTree
     * @param mixed $rootValue the initial value of the tree's root
     */
    public function __construct($rootValue = null)
    {
        if ($rootValue !== null) {
            $this->root = new Node($rootValue);
        }
    }

    /**
     * adds a node to the tree
     * @param mixed $value the value to add to the tree
     */
    public function insert($value) : void
    {
        if ($this->root !== null) {
            $this->root->addChild($value);
        }
        else {
            $this->root = new Node($value);
        }
    }

    /**
     * inserts multiple entries in the tree in order
     * @param mixed ...$values the values to insert, inserted in the order they are given in
     */
    public function insertMultiple(...$values) : void
    {
        foreach($values as $value)
        {
            $this->insert($value);
        }
    }

    /**
     * gets the Node of the trees root
     * @return Node the roots
     */
    public function getRoot() : ?Node
    {
        return $this->root;
    }

    /**
     * returns the node of the given value
     * @param mixed $value the value to look for
     * @return Node the node with the given value or null
     */
    public function find($value, Node $node = null) : ?Node
    {
        if ($node === null) {
            $node = $this->root;
        }

        if ($this->root === null) {
            return null;
        }

        if ($node->getValue() == $value) {
            return $node;
        }
        else {
            if ($value > $node->getValue() && $node->getRightChild() !== null) {
                return $this->find($value, $node->getRightChild());
            }
            else if ($node->getLeftChild() !== null){
                return $this->find($value, $node->getLeftChild());
            }
        }
        return null;
    }

    /**
     * checks if the tree has the given value
     * @param mixed $value the value to check for
     * @param Node $node the node to check from, also used i recursion
     * @return bool if the value was found or not
     */
    public function hasValue($value) : bool
    {
        if ($this->find($value)) {
            return true;
        }
        return false;
    }

    /**
     * checks that the tree has all values specified
     * @param mixed ...$values the values to check for
     * @return bool if all the values exists or not
     */
    public function hasValues(...$values) : bool
    {
        $ret = true;
        foreach($values as $value)
        {
            $ret &= $this->hasValue($value);
        }
        return $ret;
    }

    /**
     * gets the node with the smallest value
     * @param Node $node the node to recurse on
     * @return Node the minimum node
     */
    private function getMinNode(Node $node = null) : Node
    {
        if ($node === null) {
            $node = $this->root;
        }

        if ($this->root === null) {
            return null;
        }

        if ($node->getLeftChild() === null) {
            return $node;
        }
        else {
            return $this->getMinNode($node->getLeftChild());
        }
    }

    /**
     * gets the smallest value in the binary tree
     * @return mixed the minimum value in the tree
     */
    public function getMinValue()
    {
        return $this->getMinNode()->getValue();
    }

    /**
     * gets the node with the largest value
     * @param Node $node the node to recurse on
     * @return Node the maximum node
     */
    private function getMaxNode(Node $node = null) : Node
    {
        if ($node === null) {
            $node = $this->root;
        }

        if ($this->root === null) {
            return null;
        }

        if ($node->getRightChild() === null) {
            return $node;
        }
        else {
            return $this->getMaxNode($node->getRightChild());
        }
    }

    /**
     * gets the largest value in the binary tree
     * @return mixed the maximum value in the tree
     */
    public function getMaxValue()
    {
        return $this->getMaxNode()->getValue();
    }

    /**
     * deletes the given node from the tree
     * @param Node $node the node to delete
     */
    public function delete(Node $node) : void
    {
        if ($node->getLeftChild() === null && $node->getRightChild() === null) {
            //no children
            if ($node->getId() == $this->root->getId()) {
                $this->root = null;
            }
            else {
                $node->getParent()->removeChild($node->getId());
            }
        }
        else if ($node->getLeftChild() !== null && $node -> getRightChild() !== null)
        {
            //2 children
            $maximumLeft = $this->getMaxNode($node->getLeftChild());
            $node->setValue($maximumLeft->getValue());
            $maximumLeft->getParent()->removeChild($maximumLeft->getId());
        }
        else if ($node->getLeftChild() !== null || $node->getRightChild() !== null) {
            //1 child
            $childReplacingWith = $node->getLeftChild() !== null ? $node->getLeftChild() : $node->getRightChild();
            if ($node->getId() == $this->root->getId()) {
                $this->root = $childReplacingWith;
            }
            else {
                $node->getParent()->replaceChild($node->getId(), $childReplacingWith);
            }
        }

    }

    //TODO make a delete by id

    //////////////////////////////////
    //Iterator functions
    //////////////////////////////////

    /**
     * allows the BST to be cloned correctly
     * also resets the iterator to the default
     */
    public function __clone()
    {
        $this->root = clone $this->root;
        $this->iteratorPosition = false;
        $this->iteratorStack = null;
    }

    /**
     * gets the current value of the iterator
     * @return mixed the value of the current pointed at node
     */
    public function current()
    {
        return $this->iteratorPosition->getValue();
    }

    /**
     * gets the key for a for loop
     * @return int the id of the next returned node
     */
    public function key() : int
    {
        return $this->iteratorPosition->getId();
    }

    /**
     * moves the iterator up one position
     */
    public function next() : void
    {
        if ($this->iteratorStack->isEmpty() === true) {
            $this->iteratorStack = null;
        }
        else {
            $ret = $this->iteratorStack->pop();
            if ($ret->getRightChild() !== null) {
                $node = $ret->getRightChild();
                while($node !== null) {
                    $this->iteratorStack->push($node);
                    $node = $node->getLeftChild();
                }
            }
            $this->iteratorPosition = $this->iteratorStack->peek();
        }
    }

    /**
     * sets the iterator to the start value, or the left ;most leaf of the tree
     */
    public function rewind() : void
    {
        if ($this->root !== null) {
            $this->iteratorStack = new Stack();
            $node = $this->root;
            while ($node !== null) {
                $this->iteratorStack->push($node);
                $node = $node->getLeftChild();
            }
            $this->iteratorPosition = $this->iteratorStack->peek();
        }
    }

    /**
     *  checks if the iterator should continue
     * @return boolean if the iterator should continue or not
     */
    public function valid() : bool
    {
        if ($this->iteratorPosition === false) {
            return false;
        }
        return true;
    }
}
