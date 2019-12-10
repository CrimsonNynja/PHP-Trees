<?php

namespace PhpTrees;

use PhpTrees\RopeNode;

class Rope
{
    /* the root of the tree */
    private $root = null;

    /**
     * constructs the rope with default value if given
     * @param string $s the default value of the rope
     */
    public function __construct(string $s = null)
    {
        if ($s !== null) {
            $this->root = new RopeNode($s);
        }
    }

    /**
     * returns the length of the text
     * @return int length of the rope's text, 0 if the rope is empty
     */
    public function length() : int
    {
        if ($this->root !== null) {
            return $this->root->getLeafWeights();
        }
        return 0;
    }

    /**
     * inserts the given string into the rope
     * @param string $value the value to insert
     * @param int $the position to insert to, if not given, insert at the end
     */
    public function insert(string $value, int $index = null) : void
    {

    }

    /**
     * gets the character at the given index
     * @param int $index the index of the character to retrieve
     * @param RopeNode $node the recursive node to search
     * @return ?string the char at the given position or null if index is out of range or if no root exists
     */
    public function index(int $index, RopeNode $node = null) : ?string
    {
        if ($node === null) {
            $node = $this->root;
        }
        if ($node === null) {
            return null;
        }

        if ($node->getWeight() <= $index && $node->getRightChild() !== null) {
            return $this->index($index - $node->getWeight(), $node->getRightChild());
        }
        if ($node->getLeftChild() !== null) {
            return $this->index($index, $node->getLeftChild());
        }
        if (strlen($node->getValue()) > $index) {
            return $node->getValue()[$index];
        }
        return null;
    }

    /**
     * splits the given node at the given position into 2 nodes
     * @param int $index the index to split at
     * @param RopeNode $node the recursive node to search
     * @return RopeNode returns the location of the split (the new parent of the newly created nodes)
     */
    public function splitNodeAtPosition(int $index, RopeNode $node = null) : ?RopeNode
    {
        if ($node === null) {
            $node = $this->root;
        }

        if ($node->getWeight() <= $index && $node->getRightChild() !== null) {
            return $this->splitNodeAtPosition($index - $node->getWeight(), $node->getRightChild());
        }
        if ($node->getLeftChild() !== null) {
            return $this->splitNodeAtPosition($index, $node->getLeftChild());
        }
        if (strlen($node->getValue()) > $index) {
            $node->splitAndAddChildren($index);
            return $node;
        }
        return null;
    }

    /**
     * gets the substring between the 2 indexes
     * @param int $start the index to start from
     * @param int $end the index to end on, if not given defaults to the end of the rope
     * @return string the substring found
     */
    public function substr(int $start, int $end = null) : string
    {

    }

    /**
     * removes the substring between the 2 indexes
     * @param int $start the index to start from
     * @param int $end the index to end on, if not given defaults to the end of the rope
     */
    public function removeSubstr(int $start, int $end = null) : void
    {

    }

    /**
     * gets the rope in a string representation
     * @return string the rope as a string
     */
    public function toString(RopeNode $node = null) : string
    {
        $ret = "";

        if ($node === null) {
            $node = $this->root;
        }

        if ($node !== null) {
            if ($node->getValue() !== null) {
                return $node->getValue();
            }
            if ($node->getLeftChild() !== null) {
                $ret .= $this->toString($node->getLeftChild());
            }
            if ($node->getRightChild() !== null) {
                $ret .= $this->toString($node->getRightChild());
            }
        }

        return $ret;
    }

    /**
     * gets the root of the rope
     * @return ?RopeNode the Node of the root or null of not set
     */
    public function getRoot() : ?RopeNode
    {
        return $this->root;
    }

    // THOUGHTS
    // this could implement PHP ArrayAccess interface (offsetExists, offsetGet, offsetSet, offsetUnset)
    // is there need to implement iterators here>
}
