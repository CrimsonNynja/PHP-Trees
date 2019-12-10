<?php

use PhpTrees\Rope;
use PhpTrees\RopeNode;

/**
 * concatenates the given ropes
 * @param Rope $r1 first rope to concat
 * @param Rope $r2 second rope to concat
 * @return Rope the concatenated rope
 */
function concatRope(Rope $r1, Rope $r2) : Rope
{
    //TODO need to handle null cases here
    $ret = new Rope("");
    $ret->getRoot()->addLeftChild($r1->getRoot());
    $ret->getRoot()->addRightChild($r2->getRoot());

    return $ret;
}

/**
 * splits the rope at the given index
 * @param Rope $rope the rope to split
 * @param int $index the position to split at
 * @return array<Rope> the rope split up and returned as as array
 */
function splitRope(Rope $rope, int $index) : array
{
    if ($index >= $rope->length()) {
        return [$rope];
    }

    $r1 = $rope;
    $node = $r1->splitNodeAtPosition($index);
    $n = $node->removeRightChildren();
    $r2 = new Rope($n->getValue());
    //TODO split for larger ropes, need to traverse back up the tree and add back to r2, and take from r1

    return [$r1, $r2];

}



// insertBetween($index, $s) inserts a string at the given position
