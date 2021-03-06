<?php

namespace PhpTrees;

use PhpTrees\RopeNode;

/**
 * implementation of a Rope, a way to represent text through a tree
 */
class Rope implements \ArrayAccess
{
    /* the root of the tree */
    private ?RopeNode $root = null;

    /**
     * constructs the rope with default value if given
     * @param string|null $s the default value of the rope
     */
    public function __construct(?string $string = null)
    {
        if ($string !== null) {
            $this->root = new RopeNode(value: $string);
        }
    }

    /**
     * constructs the rope from the given node
     * @param RopeNode $node the node to construct from
     */
    public function constructFromNode(RopeNode $node) : void
    {
        $node->setParent(parent: null);
        $this->root = $node;
    }

    /**
     * returns the length of the text
     * @return int length of the rope's text, 0 if the rope is empty
     */
    public function length() : int
    {
        return $this->root?->getLeafWeights() + 0;
    }

    /**
     * inserts the given string into the rope
     * @param string $value the value to insert
     * @param int|null $index the position to insert to, if not given, insert at the end
     */
    public function insert(string $value, ?int $index = null) : void
    {
        $index ??= $this->length();

        if ($index >= $this->length()) {
            $r = concatRope(r1: $this, r2: new Rope($value));
        }
        else {
            $ropes = splitRope(rope: $this, index: $index);
            $dummy = new Rope(string: $value);
            $r = concatRope(r1: $ropes[0], r2: $dummy);
            $r = concatRope(r1: $r, r2: $ropes[1]);
        }

        $this->root = $r->getRoot();
    }

    /**
     * gets the character at the given index
     * @param int $index the index of the character to retrieve
     * @param RopeNode $node the recursive node to search
     * @return string|null the char at the given position or null if index is out of range or if no root exists
     */
    public function index(int $index, RopeNode $node = null) : ?string
    {
        $node ??= $this->root;

        if ($node === null) {
            return null;
        }

        if ($node->getWeight() <= $index && $node->getRightChild() !== null) {
            return $this->index(node: $node->getRightChild(), index: $index - $node->getWeight());
        }
        if ($node->getLeftChild() !== null) {
            return $this->index(node: $node->getLeftChild(), index: $index);
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
     * @return RopeNode|null returns a reference to the location of the split (the new parent of the newly created nodes)
     */
    public function &splitNodeAtPosition(int $index, RopeNode $node = null) : ?RopeNode
    {
        $node ??= $this->root;

        if ($node->getWeight() <= $index && $node->getRightChild() !== null) {
            return $this->splitNodeAtPosition(node: $node->getRightChild(), index: $index - $node->getWeight());
        }
        if ($node->getLeftChild() !== null) {
            return $this->splitNodeAtPosition(node: $node->getLeftChild(), index: $index);
        }
        if (strlen($node->getValue()) > $index) {
            $node->splitAndAddChildren(index: $index);
            return $node;
        }
        return null;
    }

    /**
     * gets the substring between the 2 indexes
     * @param int $start the index to start from
     * @param int|null $length the length of the substring, if none given, defaults to the end of the string
     * @return string the substring found
     */
    public function substr(int $start, ?int $length = null) : string
    {
        if ($start > $this->length()) {
            return "";
        }

        $length = ($length === null ? $this->length() : $length);
        $end = $start + $length;
        if ($end > $this->length()) {
            $length = $this->length() - $start;
        }

        $ret = "";
        while (strlen($ret) < $length) {
            $index = $start + strlen($ret);
            $node = $this->getNodeOfIndex(index: $index);
            for ($i = $index; $i < strlen($node->getValue()); $i++) {
                if (strlen($ret) < $length) {
                    $ret .= $node->getValue()[$i];
                }
            }
            $end -= strlen($ret);
        }

        return $ret;
    }

    /**
     * removes the substring between the 2 indexes
     * @param int $start the index to start from
     * @param int|null $length the length of the sub-string, the end of the string if none is given
     */
    public function removeSubstr(int $start, int $length = null) : void
    {
        if ($start >= $this->length() || $length === 0) {
            return;
        }

        if ($length === null || $start + $length > $this->length()) {
            $c = splitRope(rope: $this, index: $start)[0];
        }
        else {
            $end = $start + $length;
            $r1 = splitRope(rope: $this, index: $start);
            $r2 = splitRope(rope: $r1[1], index: $end - $start);
            $c = concatRope(r1: $r1[0], r2: $r2[1]);
        }
        $this->root = $c->getRoot();
    }

    /**
     * gets the rope in a string representation
     * @param RopeNode|null the recursive node or node to start the operation on
     * @return string the rope as a string
     */
    public function toString(RopeNode $node = null) : string
    {
        $ret = "";
        $node ??= $this->root;

        if ($node?->getValue() !== null) {
            return $node->getValue();
        }
        if ($node?->getLeftChild() !== null) {
            $ret .= $this->toString(node: $node->getLeftChild());
        }
        if ($node?->getRightChild() !== null) {
            $ret .= $this->toString(node: $node->getRightChild());
        }

        return $ret;
    }

    /**
     * gets the root of the rope
     * @return RopeNode|null the Node of the root or null of not set
     */
    public function getRoot() : ?RopeNode
    {
        return $this->root;
    }

    /**
     * gets node of the given index and sets index to the required index of the node for the given index
     * @param int &$index the index to find
     * @param RopeNode|null $node the node to recurse on
     * @return RopeNode|null the node of the given index
     */
    private function &getNodeOfIndex(int &$index, RopeNode $node = null) : ?RopeNode
    {
        $node ??= $this->root;

        if ($node === null) {
            return null;
        }

        if ($node->getWeight() <= $index && $node->getRightChild() !== null) {
            $index = $index - $node->getWeight();
            return $this->getNodeOfIndex(node: $node->getRightChild(), index: $index);
        }
        if ($node->getLeftChild() !== null) {
            return $this->getNodeOfIndex(node: $node->getLeftChild(), index: $index);
        }
        if (strlen($node->getValue()) > $index) {
            return $node;
        }
        return null;
    }

    ///////////////////////////////
    //php functions
    //////////////////////////////

    /**
     * returns a string of the rope for PHP to read in such instances as 'echo $rope'
     * @return string a printable representation of the rope
     */
    public function __toString() : string
    {
        return $this->toString();
    }

    /**
     * clones the current rope
     */
    public function __clone()
    {
        if ($this->root !== null) {
            $this->root = clone $this->root;
        }
    }

    /**
     * check if the given offset exists in the Rope
     * @param mixed $offset the offset to check for
     * @return bool true if the given offset exists
     */
    public function offsetExists($offset) : bool
    {
        if (is_int($offset)) {
            if ($offset <= $this->length()) {
                return true;
            }
            return false;
        } else {
            throw new \Exception('Rope offset must be an integer');
        }
    }

    /**
     * gets the index of the rope
     * @param mixed $offset the offset to check
     */
    public function offsetGet($offset)
    {
        if (is_int($offset)) {
            return $this->index(index: $offset);
        }
        else {
            throw new \Exception('Rope offset must be an integer');
        }
    }

    /**
     *
     */
    public function offsetSet($offset, $value) : void
    {
        if ($offset === null && is_string($value)) {
            $this->insert(value: $value);
            return;
        }

        if (is_int($offset)) {
            if (is_string($value) && strlen($value) === 1) {
                $index = $offset;
                $node = &$this->getNodeOfIndex(index: $index);
                $v = substr_replace($node->getValue(), $value, $index, 1);
                $node->updateValue(value: $v);

            }
            else {
                throw new \Exception("Value must be a 1 char string");
            }
        }
        else {
            throw new \Exception('Rope offset must be an integer');
        }
    }

    /**
     * removes the character from the given index
     * @param mixed $offset the offset to remove the character from
     */
    public function offsetUnset($offset) : void
    {
        if (is_int($offset)) {
            $this->removeSubstr(start: $offset, length: 1);
        }
        else {
            throw new \Exception('Rope offset must be an integer');
        }
    }
}
