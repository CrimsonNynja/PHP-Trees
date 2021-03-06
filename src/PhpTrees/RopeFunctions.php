<?php

use PhpTrees\Rope;

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

    $rCopy = clone $r1;
    $r2Copy = clone $r2;
    $ret = new Rope(string: "");
    $ret->getRoot()->addLeftChild(node: $rCopy->getRoot());
    $ret->getRoot()->addRightChild(node: $r2Copy->getRoot());

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

    $r1 = clone $rope;
    $cursor = &$r1->splitNodeAtPosition(index: $index);
    $removedChild = $cursor->removeRightChildren();
    $r2 = new Rope(string: $removedChild->getValue());

    $lastCursor = null;
    while ($cursor !== null) {
        if ($cursor->getRightChild() !== null && $cursor->getRightChild() !== $lastCursor) {
            $node = $cursor->removeRightChildren();
            $dummy = new Rope();
            $dummy->constructFromNode(node: clone $node);
            $r2 = concatRope(r1: $r2, r2: $dummy);
        }

        $lastCursor = $cursor;
        $cursor = &$cursor->getParent();
    }

    return [$r1, $r2];
}
