<?php

use PHPUnit\Framework\TestCase;
use PhpTrees\Rope;

final class RopeFunctionsTest extends TestCase
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
        $this->assertSame($concat->length(), 13);

        $r = new Rope("words 1");
        $r2 = new Rope();
        $concat = concatRope($r, $r2);
        $this->assertSame($r, $concat);

        $r = new Rope();
        $r2 = new Rope("words 2");
        $concat = concatRope($r, $r2);
        $this->assertSame($r2, $concat);

        $r = new Rope();
        $r2 = new Rope();
        $concat = concatRope($r, $r2);
        $this->assertSame($r, $concat);
    }

    public function testSplit()
    {
        $r = new Rope("words 1");
        $r2 = new Rope("words2");
        $concat = concatRope($r, $r2);
        $this->assertSame(splitRope($concat, 50), [$concat]);
        $this->assertSame(splitRope($concat, $concat->length()), [$concat]);

        $r = new Rope("words 1");
        $split = splitRope($r, 7);
        $this->assertSame($split[0]->toString(), "words 1");
        $this->assertArrayNotHasKey(1, $split);

        $r = new Rope("words 1");
        $split = splitRope($r, 6);
        $this->assertSame($split[0]->toString(), "words ");
        $this->assertSame($split[1]->toString(), "1");

        //TODO extend split test when code is
    }
}
