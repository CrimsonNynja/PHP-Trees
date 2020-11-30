<?php

namespace PhpTrees;

use PhpTrees\BstNode;
use PhpTrees\Stack;

/**
 * implementation of a binary tree
 */
class BinarySearchTree implements \Iterator
{
    /* the root of the tree */
    private ?BstNode $root = null;
    /* used for iterating over the tree */
    private ?BstNode $iteratorPosition = null;
    /* used for iterating through the tree */
    private ?Stack $iteratorStack = null;
    /* if set, used to comparing non literal values */
    private $comparator = null;
    /* the size of the BST */
    private int $size = 0;

    /**
     * constructs a new BinarySearchTree
     * @param mixed $rootValue the initial value of the tree's root
     * @param callable|null $comparator the optional comparator used to sort added values
     * @see setComparator
     */
    public function __construct(mixed $rootValue = null, ?callable $comparator = null)
    {
        if ($rootValue !== null) {
            $this->root = new BstNode(value: $rootValue);
            $this->size += 1;
        }
        if ($comparator !== null) {
            $this->setComparator(comparator: $comparator);
        }
    }

    /**
     * sets the comparator for the values to be added/found with
     * @param callable $comparator the comparing function to use, int the form function($a, $b), returning a bool
     * @return bool weather the comparitor was set or not
     */
    public function setComparator(callable $comparator) : bool
    {
        if ($this->getSize() <= 1) {
            $this->comparator = $comparator;
            $this->root?->setComparator(comparator: $this->comparator);
            return true;
        }
        return false;
    }

    /**
     * adds a node to the tree
     * @param mixed $value the value to add to the tree
     */
    public function insert(mixed $value) : void
    {
        $this->size += 1;
        if ($this->root !== null) {
            $this->root->addChild(value: $value);
        }
        else {
            $this->root = new BstNode(value: $value);
            if ($this->comparator !== null) {
                $this->root->setComparator(comparator: $this->comparator);
            }
        }
    }

    /**
     * inserts multiple entries in the tree in order
     * @param mixed ...$values the values to insert, inserted in the order they are given in
     */
    public function insertMultiple(mixed ...$values) : void
    {
        foreach($values as $value)
        {
            $this->insert(value: $value);
        }
    }

    /**
     * gets the Node of the trees root
     * @return BstNode|null the trees root
     */
    public function getRoot() : ?BstNode
    {
        return $this->root;
    }

    /**
     * gets the size of the BST
     * @return int the size of the BST, i.e. amount of nodes
     */
    public function getSize() : int
    {
        return $this->size;
    }

    /**
     * returns the node of the given value
     * @param mixed $value the value to look for
     * @return BstNode|null the node with the given value or null
     */
    public function find(mixed $value, BstNode $node = null) : ?BstNode
    {
        $node ??= $this->root;

        if ($this->root === null) {
            return null;
        }

        if ($node->getValue() == $value) {
            return $node;
        }
        else {
            if ($this->comparator !== null) {
                return $this->findComparator(node: $node, value: $value);
            }
            if ($value > $node->getValue() && $node->getRightChild() !== null) {
                return $this->find(node: $node->getRightChild(), value: $value);
            }
            else if ($node->getLeftChild() !== null) {
                return $this->find(node: $node->getLeftChild(), value: $value);
            }
        }
        return null;
    }

    /**
     * finds a node based on the given comparator
     * @param mixed $value the value to look for
     * @return BstNode|null the node with the given value or null
     */
    private function findComparator(mixed $value, BstNode $node = null) : ?BstNode
    {
        $cmp = ($this->comparator)($node->getValue(), $value);
        if ($cmp === true && $node->getRightChild() !== null) {
            return $this->find(node: $node->getRightChild(), value: $value);
        }
        else if ($node->getLeftChild() !== null) {
            return $this->find(node: $node->getLeftChild(), value: $value);
        }
        return null;
    }

    /**
     * checks if the tree has the given value
     * @param mixed $value the value to check for
     * @return bool if the value was found or not
     */
    public function hasValue(mixed $value) : bool
    {
        if ($this->find(value: $value)) {
            return true;
        }
        return false;
    }

    /**
     * checks that the tree has all values specified
     * @param mixed ...$values the values to check for
     * @return bool if all the values exists or not
     */
    public function hasValues(mixed ...$values) : bool
    {
        $ret = true;
        foreach($values as $value)
        {
            $ret &= $this->hasValue(value: $value);
        }
        return $ret;
    }

    /**
     * gets the node with the smallest value
     * @param BstNode $node the node to recurse on
     * @return BstNode|null the minimum node
     */
    private function getMinNode(BstNode $node = null) : ?BstNode
    {
        $node ??= $this->root;

        if ($this->root === null) {
            return null;
        }

        if ($node->getLeftChild() === null) {
            return $node;
        }
        else {
            return $this->getMinNode(node: $node->getLeftChild());
        }
    }

    /**
     * gets the smallest value in the binary tree
     * @return mixed the minimum value in the tree
     */
    public function getMinValue() : mixed
    {
        $mn = $this->getMinNode();
        if ($mn !== null) {
            return $mn->getValue();
        }
        return $mn;
    }

    /**
     * gets the node with the largest value
     * @param BstNode $node the node to recurse on
     * @return BstNode the maximum node, if one exists
     */
    private function getMaxNode(BstNode $node = null) : ?BstNode
    {
        $node ??= $this->root;

        if ($this->root === null) {
            return null;
        }

        if ($node->getRightChild() === null) {
            return $node;
        }
        else {
            return $this->getMaxNode(node: $node->getRightChild());
        }
    }

    /**
     * gets the largest value in the binary tree
     * @return mixed the maximum value in the tree
     */
    public function getMaxValue() : mixed
    {
        $mn = $this->getMaxNode();
        if ($mn !== null) {
            return $mn->getValue();
        }
        return $mn;
    }

    /**
     * deletes the given node from the tree
     * @param BstNode $node the node to delete
     */
    public function delete(BstNode $node) : void
    {
        if ($node->getLeftChild() === null && $node->getRightChild() === null) {
            //no children
            if ($node->getId() == $this->root->getId()) {
                $this->root = null;
            }
            else {
                $node->getParent()->removeChild(id: $node->getId());
            }
        }
        else if ($node->getLeftChild() !== null && $node -> getRightChild() !== null)
        {
            //2 children
            $maximumLeft = $this->getMaxNode(node: $node->getLeftChild());
            $node->setValue(value: $maximumLeft->getValue());
            $maximumLeft->getParent()->removeChild(id: $maximumLeft->getId());
        }
        else if ($node->getLeftChild() !== null || $node->getRightChild() !== null) {
            //1 child
            $childReplacingWith = $node->getLeftChild() !== null ? $node->getLeftChild() : $node->getRightChild();
            if ($node->getId() == $this->root->getId()) {
                $this->root = $childReplacingWith;
            }
            else {
                $node->getParent()->replaceChild(id: $node->getId(), node: $childReplacingWith);
            }
        }

    }

    /**
     * if the tree has a custom comparator or not
     * @return bool true if a custom comparator has been set
     */
    public function hasComparator() : bool
    {
        if ($this->comparator !== null) {
            return true;
        }
        return false;
    }

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
        $this->iteratorPosition = null;
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
        $ret = $this->iteratorStack->pop();
        if ($ret->getRightChild() !== null) {
            $node = $ret->getRightChild();
            while($node !== null) {
                $this->iteratorStack->push($node);
                $node = $node->getLeftChild();
            }
        }
        if ($this->iteratorStack->peek() !== false) {
            $this->iteratorPosition = $this->iteratorStack->peek();
        }
        else {
            $this->iteratorPosition = null;
        }
    }

    /**
     * sets the iterator to the start value, or the left most leaf of the tree
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
     * checks if the iterator should continue
     * @return boolean if the iterator should continue or not
     */
    public function valid() : bool
    {
        if ($this->iteratorPosition === null) {
            return false;
        }
        return true;
    }
}
