<?php

namespace PhpTrees;

use PhpTrees\Node;

/**
 * implementation of a binary tree
 */
class BinaryTree implements \Iterator
{
    private $root;
    private $mode;

    public function __construct($rootValue, $mode=null)
    {
        $this->root = new Node($rootValue);
        $this->mode = $mode;
    }

    /**
     * adds a node to the tree
     * @param $value the value to add to the tree
     */
    public function insert($value)
    {
        $this->root->addChild($value);
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
     * @param $value the value to check for
     * @param $node the node to check from, also used i recursion
     * @return bool if the value was found or not
     */
    public function hasValue($value, $node=null) : bool
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
        else if ($node->getLeftChild() !== null || $node->getRightChild() !== null) {
            if ($value > $node->getValue()) {
                return $this->hasValue($value, $node->getRightChild());
            }
            else {
                return $this->hasValue($value, $node->getLeftChild());
            }
        }
        return false;
    }

    public function change($node, $newValue)
    {

    }

    /**
     * gets the smallest value in the binary tree
     * @return T the minimum value in the tree
     */
    public function getMinValue($node=null)
    {
        if ($node === null) {
            $node = $this->root;
        }

        if ($this->root === null) {
            return null;
        }

        if ($node->getLeftChild() === null) {
            return $node->getValue();
        }
        else {
            return $this->getMinValue($node->getLeftChild());
        }
    }

    /**
     * gets the largest value in the binary tree
     * @return T the maximum value in the tree
     */
    public function getMaxValue($node=null)
    {
        if ($node === null) {
            $node = $this->root;
        }

        if ($this->root === null) {
            return null;
        }

        if ($node->getRightChild() === null) {
            return $node->getValue();
        }
        else {
            return $this->getMaxValue($node->getRightChild());
        }
    }



    ////////Allows tree to be used with foreach loops

    public function rewind()
    {

    }

    public function current()
    {

    }

    public function key()
    {

    }

    public function next()
    {

    }

    public function valid()
    {

    }
}
