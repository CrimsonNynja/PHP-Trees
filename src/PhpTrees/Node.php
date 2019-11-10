<?php

namespace PhpTrees;

/**
 * Node of a tree
 */
class Node
{
    /* the nodes value */
    private $value = null;
    /* the left child of the node */
    private $left = null;
    /* the right child of the node */
    private $right = null;
    /* the node's if, used for iterating over the tree */
    private $id;

    /**
     * constructs the node with the given value also generates a unique id for the node
     * @param mixed $value the value of the node
     */
    public function __construct($value)
    {
        $this->value = $value;
        static $id = 0;
        $this->id = $id++;
    }

    /**
     * adds a child node to the node
     * @param mixed $value the value of the node to add
     */
    public function addChild($value)
    {
        if ($value >= $this->value) {
            if ($this->right === null) {
                $this->right = new Node($value);
            }
            else {
                $this->right->addChild($value);
            }
        }
        else {
            if ($this->left === null) {
                $this->left = new Node($value);
            }
            else {
                $this->left->addChild($value);
            }
        }
    }

    /**
     * gets the value of the node
     * @return mixed the value of the node
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * gets the right child of the node if it exists
     * @return ?Node the right child or null
     */
    public function getRightChild() : ?Node
    {
        return $this->right;
    }

    /**
     * gets the left child of the node if it exists
     * @return ?Node the left child or null
     */
    public function getLeftChild() : ?Node
    {
        return $this->left;
    }

    /**
     * gets the node id
     */
    public function getId()
    {
        return $this->id;
    }
}
