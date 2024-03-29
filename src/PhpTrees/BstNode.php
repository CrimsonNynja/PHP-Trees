<?php

namespace PhpTrees;

/**
 * Node of a tree
 */
class BstNode
{
    /* the left child of the node */
    private ?BstNode $left = null;
    /* the right child of the node */
    private ?BstNode $right = null;
    /* the node's id, used for iterating over the tree */
    private readonly int $id;
    /* if set, used to comparing non literal values */
    private $comparator = null;

    /**
     * constructs the node with the given value also generates a unique id for the node
     * @param mixed $value the value of the node
     * @param BstNode|null $parent the nodes parent node, optional
     */
    public function __construct(
        private mixed $value,
        private ?BstNode $parent = null
    ) {
        static $id = 0;
        $this->id = $id++;
    }

    /**
     * sets the comparator for the tree
     * @param callable $comparator the comparator to use when adding children must take in 2 values the nodes value, and the value to add, and return a boolean denoting if the new value is higher or equal to the current one
     */
    public function setComparator(callable $comparator) : void
    {
        $this->comparator = $comparator;
    }

    /**
     * adds a child node to the node
     * @param mixed $value the value of the node to add
     */
    public function addChild(mixed $value) : void
    {
        if ($this->comparator !== null) {
            $this->addChildComparator(value: $value);
            return;
        }
        if ($value >= $this->value) {
            if ($this->right === null) {
                $this->right = new BstNode(parent: $this, value: $value);
            }
            else {
                $this->right->addChild(value: $value);
            }
        }
        else {
            if ($this->left === null) {
                $this->left = new BstNode(parent: $this, value: $value);
            }
            else {
                $this->left->addChild(value: $value);
            }
        }
    }

    /**
     * adds a new node based upon the comparator
     * @param mixed $value the value of the new node
     *
     * @note this should be renamed to something more descriptive
     */
    private function addChildComparator(mixed $value) : void
    {
        $cmp = ($this->comparator)($this->value, $value);
        if ($cmp === true) {
            if ($this->right === null) {
                $this->right = new BstNode(parent: $this, value: $value);
                $this->right->setComparator(comparator: $this->comparator);
            }
            else {
                $this->right->addChildComparator(value: $value);
            }
        }
        else {
            if ($this->left === null) {
                $this->left = new BstNode(parent: $this, value: $value);
                $this->left->setComparator(comparator: $this->comparator);
            }
            else {
                $this->left->addChildComparator(value: $value);
            }
        }
    }

    /**
     * removes the child of the node with the given id
     * @param int $id the id of the child to remove
     */
    public function removeChild(int $id) : void
    {
        if ($this->left?->getId() === $id) {
            $this->left = null;
        }
        if ($this->right?->getId() === $id) {
            $this->right = null;
        }
    }

    /**
     * replaces the given child with the given node
     * @param BstNode $node the node to replace the child with
     * @param int $id the child to replace
     */
    public function replaceChild(BstNode $newNode, int $idToReplace) : void
    {
        if ($this->left?->getId() === $idToReplace) {
            $this->left = $newNode;
        }
        if ($this->right?->getId() === $idToReplace) {
            $this->right = $newNode;
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
        if ($this->left?->getId() === $child->getId()) {
            return true;
        }
        if ($this->right?->getId() === $child->getId()) {
            return true;
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
    public function setValue(mixed $value) : void
    {
        $this->value = $value;
    }

    /**
     * gets the right child of the node if it exists
     * @return BstNode|null the right child or null
     */
    public function getRightChild() : ?BstNode
    {
        return $this->right;
    }

    /**
     * gets the left child of the node if it exists
     * @return BstNode|null the left child or null
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
     * @return BstNode|null the parent node or null (if the root)
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
     * checks if the node has a custom comparator set
     */
    public function hasComparator() : bool
    {
        if ($this->comparator === null) {
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
            $this->left->setParent(parent: $this);
        }

        if ($this->right !== null) {
            $this->right = clone $this->right;
            $this->right->setParent(parent: $this);
        }
    }
}
