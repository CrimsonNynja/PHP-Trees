<?php

use PHPUnit\Framework\TestCase;
use PhpTrees\Rope;

class RopeFunctionsTest extends TestCase
{
    public function testConcat()
    {
        $r = new Rope("words 1");
        $r2 = new Rope("words2");
        $concat = concatRope($r, $r2);

        $this->assertNull($concat->getRoot()->getValue());
        $this->assertSame($concat->getRoot()->getRightChild()->getValue(), "words2");
        $this->assertSame($concat->getRoot()->getLeftChild()->getValue(), "words 1");
        $this->assertSame($concat->getRoot()->getWeight(), 7);
        //TODO assert length, and to_string here as well
        //TODO assert empty test cases as well
    }
}
