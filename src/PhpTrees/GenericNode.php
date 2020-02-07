<?php

namespace PhpTrees;

use Exception;

/**
 * Node for the GenericTree type
 */
class GenericNode
{
    /* The value of the node */
    private $value = null;
    /* The nodes children */
    private array $children = [];
    /* the nodes parent */
    private ?GenericNode $parent = null;
    /* the nodes id */
    private int $id = 0;

    /**
     * constructs a node
     * @param mixes $value the default value of the node, null if not given
     */
    public function __construct($value = null)
    {
        $this->setValue($value);
        static $id = 0;
        $this->id = $id++;
    }

    /**
     * adds a child to the node
     * @param mixed value the value of the child
     */
    public function addChild($value) : void
    {
        if ($value instanceof GenericNode) {
            $this->addChildFromNode($value);
        }
        else {
            $n = new GenericNode($value);
            $n->setParent($this);
            $this->children[] = $n;
        }
    }

    /**
     * adds multiple children to the node
     * @param mixed $values the variatic values to add
     */
    public function addChildren(...$values) : void
    {
        foreach($values as $value) {
            $this->addChild($value);
        }
    }

    /**
     * adds a child from the given node. If the given node has a parent, it is changed to this node
     * @param GenericNode $node the node to add as a child
     */
    public function addChildFromNode(GenericNode $node) : void
    {
        $node->setParent(null);

        if ($node->getParent() === null && $node->getChildren() === []) {
            $node->setParent($this);
            $this->children[] = $node;
        }
        if ($this->checkForCycles($this, $node) === true) {
            throw new Exception("Error: adding this node will create a cycle");
        }
        else {
            $node->setParent($this);
            $this->children[] = $node;
        }
    }

    /**
     * checks if the node is cyclic with the other node
     * @param GenericNode $node the fist node to check, this node is recursed on
     * @param GenericNode $node2 the second node to check, this node is compared from
     * @return bool true if a cycle exists
     */
    public function checkForCycles(GenericNode $node, GenericNode $node2) : bool
    {
        if ($node->getID() === $node2->getID()) {
            return true;
        }
        if ($node->getParent() !== null) {
            return $this->checkForCycles($node->getParent(), $node2);
        }
        return false;
    }

    public function setParent(?GenericNode $node) : void
    {
        $this->parent = $node;
    }

    /**
     * sets the nodes value
     * @param mixed $value the value to set to
     */
    public function setValue($value) : void
    {
        $this->value = $value;
    }

    /**
     * gets the value of the node
     * @return mixed the nodes value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * gets the nodes children
     * @return array the nodes children
     */
    public function getChildren() : array
    {
        return $this->children;
    }

    /**
     * gets the nodes parent if it exists
     * @return GenericNode|null the nodes parent or null if it dose not exist
     */
    public function getParent() : ?GenericNode
    {
        return $this->parent;
    }

    /**
     * gets the nodes ID
     * @return int the id of the node
     */
    public function getID() : int
    {
        return $this->id;
    }
}
