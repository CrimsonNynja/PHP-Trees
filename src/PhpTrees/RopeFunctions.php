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
function split(Rope $rope, int $index) : array
{

}



// insertBetween($index, $s) inserts a string at the given position
