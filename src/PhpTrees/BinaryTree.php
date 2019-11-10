<?php

namespace PhpTrees;

use PhpTrees\Node;

/**
 * implementation of a binary tree
 */
class BinaryTree implements \Iterator
{
    /* the root of the tree */
    private $root;
    private $mode;
    /* used for iterating over the tree */
    private $iteratorPosition;

    /**
     * constructs a new BinaryTree
     * @param mixed $rootValue the initial value of the tree's root
     */
    public function __construct($rootValue, $mode=null)
    {
        $this->root = new Node($rootValue);
        $this->mode = $mode;
    }

    /**
     * adds a node to the tree
     * @param mixed $value the value to add to the tree
     */
    public function insert($value)
    {
        $this->root->addChild($value);
    }

    /**
     * inserts multiple entries in the tree in order
     * @param mixed ...$values the values to insert, inserted in the order they are given in
     */
    public function insertMultiple(...$values)
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
    public function getRoot()
    {
        return $this->root;
    }

    public function delete()
    {

    }

    /**
     *
     */
    public function traverse(string $traversalType)
    {

    }

    /**
     * checks if the tree has the given value
     * @param mixed $value the value to check for
     * @param Node $node the node to check from, also used i recursion
     * @return bool if the value was found or not
     */
    public function hasValue($value, Node $node=null) : bool
    {
        if ($node === null) {
            $node = $this->root;
        }

        if ($this->root === null) {
            return false;
        }

        if ($node->getValue() == $value) {
            return true;
        }
        else {
            if ($value > $node->getValue() && $node->getRightChild() !== null) {
                return $this->hasValue($value, $node->getRightChild());
            }
            else if ($node->getLeftChild() !== null){
                return $this->hasValue($value, $node->getLeftChild());
            }
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

    public function change($node, $newValue)
    {

    }

    /**
     * gets the node with the smallest value
     * @param Node $node the node to recurse on
     * @return Node the minimum node
     */
    private function getMinNode(Node $node=null)
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
    private function getMaxNode(Node $node=null)
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

    //////////////////////////////////
    //Iterator functions
    //////////////////////////////////

    /**
     * gets the current value of the iterator
     * @return mixed the value of the currently on node
     */
    public function current()
    {
        return $this->iteratorPosition->getValue();
    }

    public function key()
    {
        return $this->iteratorPosition->getId();
    }

    public function next() : void
    {

    }

    /**
     * sets the iterator to the start value, or the left most leaf of the tree
     */
    public function rewind() : void
    {
        $this->iteratorPosition = $this->getMinNode();
    }

    public function valid() : bool
    {

    }
}
