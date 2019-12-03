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
    function length() : int
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
    function insert(string $value, int $index = null) : void
    {

    }

    /**
     * gets the character as the given index
     * @param int $index the index of the character to retrieve
     * @param RopeNode $node the recursive node to search
     * @return ?string the char at the given position or null if index is out of range or if no root exists
     */
    function index(int $index, RopeNode $node = null) : ?string
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
     * gets the substring between the 2 indexes
     * @param int $start the index to start from
     * @param int $end the index to end on, if not given defaults to the end of the rope
     * @return string the substring found
     */
    function substr(int $start, int $end = null) : string
    {

    }

    /**
     * removes the substring between the 2 indexes
     * @param int $start the index to start from
     * @param int $end the index to end on, if not given defaults to the end of the rope
     */
    function removeSubstr(int $start, int $end = null) : void
    {

    }

    /**
     * gets the rope in a string representation
     * @return string the rope as a string
     */
    function toString() : string
    {

    }

    /**
     * gets the root of the rope
     * @return ?RopeNode the Node of the root or null of not set
     */
    function getRoot() : ?RopeNode
    {
        return $this->root;
    }

    // THOUGHTS
    // this could implement PHP ArrayAccess interface (offsetExists, offsetGet, offsetSet, offsetUnset)
    // is there need to implement iterators here>
}
