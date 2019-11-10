<?php

namespace PhpTrees;

/**
 * Node of a tree
 */
class Node
{
    private $value = null;
    private $left = null;
    private $right = null;

    public function __construct($value)
    {
        $this->value = $value;
    }

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

    public function getValue()
    {
        return $this->value;
    }

    public function getRightChild()
    {
        return $this->right;
    }

    public function getLeftChild()
    {
        return $this->left;
    }
}
