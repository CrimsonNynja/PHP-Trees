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
    /* used for quick deletions */
    private $parent = null;
    /* the node's if, used for iterating over the tree */
    private $id;

    /**
     * constructs the node with the given value also generates a unique id for the node
     * @param mixed $value the value of the node
     */
    public function __construct($value, Node $parent=null)
    {
        $this->value = $value;
        $this->parent = $parent;

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
                $this->right = new Node($value, $this);
            }
            else {
                $this->right->addChild($value);
            }
        }
        else {
            if ($this->left === null) {
                $this->left = new Node($value, $this);
            }
            else {
                $this->left->addChild($value);
            }
        }
    }

    /**
     * removes the child of the node with the given id
     * @param int $id the id of the child to remove
     */
    public function removeChild(int $id)
    {
        if ($this->left !== null) {
            if ($this->left->getId() === $id) {
                $this->left = null;
            }
        }
        if ($this->right !== null) {
            if ($this->right->getId() === $id) {
                $this->right = null;
            }
        }
    }

    /**
     * replaces the given child with the given node
     * @param int $id the child to replace
     * @param Node $node the node to replace the child with
     */
    public function replaceChild(int $id, Node $node)
    {
        if ($this->left !== null) {
            if ($this->left->getId() === $id) {
                $this->left = $node;
            }
        }
        if ($this->right !== null) {
            if ($this->right->getId() === $id) {
                $this->right = $node;
            }
        }
    }

    /**
     * finds if the current node is a leaf node
     * @return bool true if the node is a leaf
     */
    public function isLeaf() : bool
    {
        if ($this->left !== null || $this->right !== null)
        {
            return false;
        }
        return true;
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
     * sets the node value
     * @param mixed $value the new value of the node
     */
    public function setValue($value)
    {
        $this->value = $value;
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

    /**
     * gets the parent of the current node
     * @return ?Node the parent node or null (if the root)
     */
    public function getParent() : ?Node
    {
        return $this->parent;
    }
}
