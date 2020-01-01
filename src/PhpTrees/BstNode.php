<?php

namespace PhpTrees;

/**
 * Node of a tree
 */
class BstNode
{
    /* the nodes value */
    private $value = null;
    /* the left child of the node */
    private $left = null;
    /* the right child of the node */
    private $right = null;
    /* used for quick deletions */
    private $parent = null;
    /* the node's id, used for iterating over the tree */
    private $id = 0;
    /* if set, used to comparing non literal values */
    private $comparitor = null;

    /**
     * constructs the node with the given value also generates a unique id for the node
     * @param mixed $value the value of the node
     * @param BstNode $parent the nodes parent node
     */
    public function __construct($value, BstNode $parent = null)
    {
        $this->value = $value;
        $this->parent = $parent;

        static $id = 0;
        $this->id = $id++;
    }

    /**
     * sets the comparitor for the tree
     * @param callable $comparitor the comparitor to use when adding children must take in 2 values the nodes value, and the value to add, and return a boolean denoting if the new value is higher or equal to the current one
     */
    public function setComparitor(callable $comparitor) : void
    {
        $this->comparitor = $comparitor;
    }

    /**
     * adds a child node to the node
     * @param mixed $value the value of the node to add
     */
    public function addChild($value) : void
    {
        if ($this->comparitor !== null) {
            $this->addChildComparitor($value);
            return;
        }
        if ($value >= $this->value) {
            if ($this->right === null) {
                $this->right = new BstNode($value, $this);
            }
            else {
                $this->right->addChild($value);
            }
        }
        else {
            if ($this->left === null) {
                $this->left = new BstNode($value, $this);
            }
            else {
                $this->left->addChild($value);
            }
        }
    }

    private function addChildComparitor($value) : void
    {
        $cmp = $this->comparitor->__invoke($this->value, $value);
        if ($cmp === true) {
            if ($this->right === null) {
                $this->right = new BstNode($value, $this);
                $this->right->setComparitor($this->comparitor);
            }
            else {
                $this->right->addChildComparitor($value);
            }
        }
        else {
            if ($this->left === null) {
                $this->left = new BstNode($value, $this);
                $this->left->setComparitor($this->comparitor);
            }
            else {
                $this->left->addChildComparitor($value);
            }
        }
    }

    /**
     * removes the child of the node with the given id
     * @param int $id the id of the child to remove
     */
    public function removeChild(int $id) : void
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
     * @param BstNode $node the node to replace the child with
     */
    public function replaceChild(int $id, BstNode $node) : void
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
     * checks if any of the nodes child nodes are the given node
     * @param BstNode $child the child to check the presence of
     */
    public function hasChild(BstNode $child) : bool
    {
        if ($this->left !== null) {
            if ($this->left->getId() === $child->getId()) {
                return true;
            }
        }
        if ($this->right !== null) {
            if ($this->right->getId() === $child->getId()) {
                return true;
            }
        }
        return false;
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
    public function setValue($value) : void
    {
        $this->value = $value;
    }

    /**
     * gets the right child of the node if it exists
     * @return ?Node the right child or null
     */
    public function getRightChild() : ?BstNode
    {
        return $this->right;
    }

    /**
     * gets the left child of the node if it exists
     * @return ?Node the left child or null
     */
    public function getLeftChild() : ?BstNode
    {
        return $this->left;
    }

    /**
     * gets the node id
     * @return int the id of the node
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * gets the parent of the current node
     * @return BstNode the parent node or null (if the root)
     */
    public function getParent() : ?BstNode
    {
        return $this->parent;
    }

    /**
     * sets the current parent to the given parent
     * @param BstNode $parent the new parent to be set to
     */
    public function setParent(BstNode $parent) : void
    {
        $this->parent = $parent;
    }

    /**
     * checks if the node has a custom comparitor set
     */
    public function hasComparitor() : bool
    {
        if ($this->comparitor === null) {
            return false;
        }
        return true;
    }

    //////////////////////////////////
    //Iterator functions
    //////////////////////////////////

    /**
     * allows the BST to be cloned correctly
     */
    public function __clone()
    {
        if ($this->left !== null) {
            $this->left = clone $this->left;
            $this->left->setParent($this);
        }

        if ($this->right !== null) {
            $this->right = clone $this->right;
            $this->right->setParent($this);
        }
    }
}
