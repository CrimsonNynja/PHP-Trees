<?php

namespace PhpTrees;

class RopeNode
{
    private $value = null;
    private $left = null;
    private $right = null;
    private $parent = null;
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

    private function getLeafWeights(RopeNode $node) : int
    {
        $ret = 0;
        if ($node->hasChildren() === false) {
            return $node->getWeight();
        }
        else {
            if ($node->getLeftChild()) {
                $ret += $node->getLeftChild()->getWeight();
            }
            if ($node->getRightChild()) {
                $ret += $node->getRightChild()->getWeight();
            }
        }
        return $ret;
    }

    public function addRightChild(RopeNode $node) : void
    {
        $this->right = $node;
        $this->value = null;
    }

    public function addLeftChild(RopeNode $node) : void
    {
        $this->left = $node;
        $this->weight = $this->getLeftChild()->getLeafWeights($node);
        $this->value = null;
    }

    public function hasChildren() : bool
    {
        if ($this->left || $this->right) {
            return true;
        }
        return false;
    }

    public function getValue() : ?string
    {
        return $this->value;
    }

    public function getWeight() : int
    {
        return $this->weight;
    }

    public function getParent() : ?RopeNode
    {
        return $this->parent;
    }

    public function getLeftChild() : ?RopeNode
    {
        return $this->left;
    }

    public function getRightChild() : ?RopeNode
    {
        return $this->right;
    }
}
