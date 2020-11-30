<?php

namespace PhpTrees;

use Exception;

/**
 * Node for the GenericTree type
 */
class GenericNode
{
    /* The nodes children */
    private array $children = [];
    /* the nodes id */
    private int $id = 0;

    /**
     * constructs a node
     * @param mixed $value the default value of the node, null if not given
     */
    public function __construct(
        private mixed $value = null,
        private ?GenericNode $parent = null
    ) {
        static $id = 0;
        $this->id = $id++;
    }

    /**
     * adds a child to the node
     * @param mixed value the value of the child
     */
    public function addChild(mixed $value) : void
    {
        if ($value instanceof GenericNode) {
            $this->addChildFromNode(node: $value);
        }
        else {
            $n = new GenericNode(value: $value);
            $n->setParent(node: $this);
            $this->children[] = $n;
        }
    }

    /**
     * adds multiple children to the node
     * @param mixed $values the variatic values to add
     */
    public function addChildren(mixed ...$values) : void
    {
        foreach($values as $value) {
            $this->addChild(value: $value);
        }
    }

    /**
     * adds a child from the given node. If the given node has a parent, it is changed to this node
     * @param GenericNode $node the node to add as a child
     */
    public function addChildFromNode(GenericNode $node) : void
    {
        $node->setParent(node: null);

        if ($node->getParent() === null && $node->getChildren() === []) {
            $node->setParent(node: $this);
            $this->children[] = $node;
        }
        if ($this->checkForCycles(node: $this, node2: $node) === true) {
            throw new Exception("Error: adding this node will create a cycle");
        }
        else {
            $node->setParent(node: $this);
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
            return $this->checkForCycles(node: $node->getParent(), node2: $node2);
        }
        return false;
    }

    /**
     * sets the parent of this node to the given node, or none
     * @param GenericNode}null the node to set as the parent
     */
    public function setParent(?GenericNode $node) : void
    {
        $this->parent = $node;
    }

    /**
     * sets the nodes value
     * @param mixed $value the value to set to
     */
    public function setValue(mixed $value) : void
    {
        $this->value = $value;
    }

    /**
     * gets the value of the node
     * @return mixed the nodes value
     */
    public function getValue() : mixed
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
