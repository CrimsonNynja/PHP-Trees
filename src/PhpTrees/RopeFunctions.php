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
    if ($r1->length() === 0 && $r2->length() !== 0) {
        return $r2;
    }

    if ($r2->length() === 0) {
        return $r1;
    }

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

    $cursor = $node;
    $lastCursor = null;
    while ($cursor !== null) {
        if ($cursor->getRightChild() !== null && $cursor->getRightChild() !== $lastCursor) {
            $node = $cursor->removeRightChildren();
            if ($node->hasChildren() === false) {
                $dummy = new Rope($node->getValue());
            }
            else {
                $dummy = new Rope();
                $dummy->constructFromNode($node);
            }
            $r2 = concatRope($r2, $dummy);
        }

        $lastCursor = $cursor;
        $cursor = $cursor->getParent();
    }

    return [$r1, $r2];
}
