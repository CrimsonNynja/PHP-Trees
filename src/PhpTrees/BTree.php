<?php

namespace PhpTrees;

use PhpTrees\BTreeNode;

class BTree
{
    /* the root of the tree */
    private $root = null;
    /* maximum degree for the tree's nodes */
    private $maxDegree;

    public function __construct(int $maxDegree, $initRootValue = null)
    {
        $this->maxDegree = $maxDegree;
        if ($initRootValue !== null) {
            $this->root = new BTreeNode($this->maxDegree);
            $this->root->insert($initRootValue);
        }
    }

    public function insert($value) : void
    {

    }

    /**
     * gets the root of the tree
     * @return BTreeNode the trees root if it exists
     */
    public function getRoot() : ?BTreeNode
    {
        return $this->root;
    }

    public function find()
    {

    }

    public function hasValue()
    {

    }

    public function delete()
    {

    }
}
