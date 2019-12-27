<?php

namespace PhpTrees;

class RopeNode
{
    /* THe value of the node */
    private $value = null;
    /* the left child of the node */
    private $left = null;
    /* the right child of the node */
    private $right = null;
    /* the nodes parent */
    private $parent = null;
    /* the weight of the node, representing the value length */
    private $weight = 0;

    /**
     * constructs a Rope Node
     * @param string $value the initial value of the node, null if not given
     */
    public function __construct(string $value = null)
    {
        $this->value = $value;
        if ($this->value !== null) {
            $this->weight = strlen($this->value);
        }
    }

    /**
     * gets the combined weight of all leaf nodes
     * @param RopeNode $node the node to recurse from, if non given the current node is used
     * @return int the combined weight of the leaves
     */
    public function getLeafWeights(RopeNode $node = null) : int
    {
        if ($node === null) {
            $node = $this;
        }

        $ret = 0;
        if ($node->hasChildren() === false) {
            return $node->getWeight();
        }
        else {
            if ($node->getLeftChild() !== null) {
                $ret += $node->getLeafWeights($node->getLeftChild());
            }
            if ($node->getRightChild() !== null) {
                $ret += $node->getLeafWeights($node->getRightChild());
            }
        }
        return $ret;
    }

    /**
     * adds a right child to the node and removes the value
     * @param RopeNode $node the node to add
     */
    public function addRightChild(RopeNode $node) : void
    {
        $node->setParent($this);
        $this->right = $node;
        $this->value = null;
        if ($this->left === null) {
            $this->weight = 0;
        }
    }

    /**
     * adds a left child to the node and recalculates the weight and removes the value
     * @param RopeNode $node the node to add
     */
    public function addLeftChild(RopeNode $node) : void
    {
        $this->left = $node;
        $this->weight = $this->getLeftChild()->getLeafWeights($node);
        $this->value = null;
        $this->left->parent = $this;
    }

    /**
     * removes all of the right children from the node
     * @return RopeNode the children that were removed(unlined)
     */
    public function removeRightChildren() : ?RopeNode
    {
        $ret = $this->right;
        $this->right = null;
        if ($this->left) {
            $this->weight = $this->getLeftChild()->getLeafWeights();
        }
        return $ret;
    }

    /**
     * split the node into 2, making the current value into two children values
     * @param int $index the index to split at
     */
    public function splitAndAddChildren(int $index) : void
    {
        if ($this->value !== null && $index < $this->weight) {
            $value = $this->value;
            $this->addLeftChild(new RopeNode(substr($value, 0, $index)));
            $this->addRightChild(new RopeNode(substr($value, $index)));
        }
    }

    /**
     * finds if the current node has any children
     * @return bool true is any of the left or right children exist
     */
    public function hasChildren() : bool
    {
        if ($this->left || $this->right) {
            return true;
        }
        return false;
    }

    /**
     * gets the current value of the node
     * @return string the value, null if it has none
     */
    public function getValue() : ?string
    {
        return $this->value;
    }

    /**
     * gets the weight of the node
     * @return int the weight of the node, always at least 0
     */
    public function getWeight() : int
    {
        return $this->weight;
    }

    /**
     * gets the parent of the node
     * @return RopeNode the nodes parent, null if it has none
     */
    public function &getParent() : ?RopeNode
    {
        return $this->parent;
    }

    /**
     * gets the left child of the node
     * @return RopeNode the nodes left child, null if it has none
     */
    public function getLeftChild() : ?RopeNode
    {
        return $this->left;
    }

    /**
     * gets the right child of the node
     * @return RopeNode the nodes right child, null if it has none
     */
    public function getRightChild() : ?RopeNode
    {
        return $this->right;
    }

    /**
     * sets the nodes parent to the given node
     * @param RopeNode $parent the parent to set to
     */
    public function setParent(?RopeNode $parent) : void
    {
        $this->parent = $parent;
    }

    /**
     * changes the value of the node, if it is a leaf
     * @param string $newVal the new value for the node
     */
    public function changeValue(string $newVal) : void
    {
        if ($this->hasChildren() === false) {
            $this->value = $newVal;
        }
    }

    ///////////////////////////////
    //php functions
    //////////////////////////////

    /**
     * clones the current RopeNode
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
