<?php

namespace PhpTrees;

class BTreeNode
{
    /* the nodes parent */
    private $parent;
    /* maximum degree for the node */
    private $maxDegree;
    private $keys;
    private $children;

    public function __construct(int $maxDegree)
    {
        $this->maxDegree = $maxDegree;
    }

    public function insert($value) : void
    {
        //TODO need to check if the new value should remain in this node or not
        $this->keys[] = $value;
    }

    public function hasKey($key)
    {

    }

    public function isLeaf() : bool
    {

    }

    /**
     * gets the parent of the node
     * @return BTreeNode the nodes parent if it exists
     */
    public function getParent() : ?BTreeNode
    {
        return $this->parent;
    }

    public function getMaxDegree() : int
    {
        return $this->maxDegree;
    }
}
