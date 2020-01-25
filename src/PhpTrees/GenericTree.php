<?php

namespace PhpTrees;

use PhpTrees\GenericNode;

/**
 * a generic tree that allows unlimited children for each node, with no ordering
 */
class GenericTree
{
    /* the root of the tree */
    private $root;

    /**
     * construct the node
     * @param mixed $root the value of the initial root
     */
    public function __construct($rootValue = null)
    {
        $this->root = new GenericNode($rootValue);
    }

    /**
     * gets the root of the tree
     * @return GenericNode|null gets the root of the node
     */
    public function getRoot() : ?GenericNode
    {
        return $this->root;
    }

    /**
     * finds the node of the given ID
     * @param int 4id the id of the node to bind
     * @param GenericNode|null $node the node to recurse on
     * @return GenericNode|null the node if found, or null
     */
    public function findNode(int $id, ?GenericNode $node = null) : ?GenericNode
    {
        if ($node === null) {
            $node = $this->root;
        }
        if ($node === null) {
            return null;
        }

        if ($node->getID() === $id) {
            return $node;
        }
        else {
            $result = null;
            $children = $node->getChildren();
            foreach($children as $child) {
                if ($result === null) {
                    $result = $this->findNode($id, $child);
                }
            }
            return $result;
        }
    }

    /**
     * finds the first node with the given value
     * @param mixed $value the value to look for
     * @param GenericNode|null $node the node to recurse on
     * @return GenericNode|null the node if found, or null
     */
    public function findNodeByValue($value, ?GenericNode $node = null) : ?GenericNode
    {
        if ($node === null) {
            $node = $this->root;
        }
        if ($node === null) {
            return null;
        }

        if ($node->getValue() === $value) {
            return $node;
        }
        else {
            $result = null;
            $children = $node->getChildren();
            foreach($children as $child) {
                if ($result === null) {
                    $result = $this->findNode($id, $child);
                }
            }
            return $r
    }
}
