<?php

namespace Tests\PhpTrees;

use PHPUnit\Framework\TestCase;
use PhpTrees\Rope;

final class RopeFunctionsTest extends TestCase
{
    public function testConcat()
    {
        $r = new Rope(string: "words 1");
        $r2 = new Rope(string: "words2");
        $concat = concatRope(r1: $r, r2: $r2);

        $this->assertNull($r->getRoot()->getLeftChild());
        $this->assertNull($r->getRoot()->getRightChild());
        $this->assertNull($r->getRoot()->getParent());
        $this->assertNull($r2->getRoot()->getLeftChild());
        $this->assertNull($r2->getRoot()->getLeftChild());
        $this->assertNull($r->getRoot()->getParent());

        $this->assertNull($concat->getRoot()->getValue());
        $this->assertSame($concat->getRoot()->getRightChild()->getValue(), "words2");
        $this->assertSame($concat->getRoot()->getLeftChild()->getValue(), "words 1");
        $this->assertSame($concat->getRoot()->getWeight(), 7);
        $this->assertSame($concat->length(), 13);

        $r = new Rope(string: "words 1");
        $r2 = new Rope();
        $concat = concatRope(r1: $r, r2: $r2);
        $this->assertSame($r, $concat);
        $this->assertNull($r->getRoot()->getLeftChild());
        $this->assertNull($r->getRoot()->getRightChild());
        $this->assertNull($r->getRoot()->getParent());
        $this->assertNull($r2->getRoot());

        $r = new Rope();
        $r2 = new Rope(string: "words 2");
        $concat = concatRope(r1: $r, r2: $r2);
        $this->assertSame($r2, $concat);
        $this->assertNull($r->getRoot());
        $this->assertNull($r2->getRoot()->getLeftChild());
        $this->assertNull($r2->getRoot()->getLeftChild());

        $r = new Rope();
        $r2 = new Rope();
        $concat = concatRope(r1: $r, r2: $r2);
        $this->assertSame($r, $concat);
        $this->assertNull($r->getRoot());
        $this->assertNull($r2->getRoot());

        $r = new Rope(string: "words 1");
        $r2 = new Rope(string: "words2");
        $rope1 = concatRope(r1: $r, r2: $r2);
        $r = new Rope(string: "words3");
        $r2 = new Rope(string: "words 4");
        $rope2 = concatRope(r1: $r, r2: $r2);
        $rope = concatRope(r1: $rope1, r2: $rope2);
        $this->assertSame($rope->toString(), "words 1words2words3words 4");
        $this->assertNull($r->getRoot()->getParent());
        $this->assertNull($r2->getRoot()->getParent());
        $this->assertNull($rope1->getRoot()->getParent());
        $this->assertNull($rope2->getRoot()->getParent());
    }

    public function testSplit()
    {
        $r = new Rope(string: "words 1");
        $r2 = new Rope(string: "words2");
        $concat = concatRope(r1: $r, r2: $r2);
        $this->assertSame(splitRope(rope: $concat, index: 50), [$concat]);
        $this->assertSame(splitRope(rope: $concat, index: $concat->length()), [$concat]);

        $r = new Rope(string: "words 1");
        $split = splitRope(rope: $r, index: 7);
        $this->assertSame($split[0]->toString(), "words 1");
        $this->assertArrayNotHasKey(1, $split);

        $r = new Rope(string: "words 1");
        $split = splitRope(rope: $r, index: 6);
        $this->assertSame($split[0]->toString(), "words ");
        $this->assertSame($split[1]->toString(), "1");

        $r = new Rope(string: "words 1");
        $r2 = new Rope(string: "words2");
        $rope1 = concatRope(r1: $r, r2: $r2);
        $r = new Rope(string: "words3");
        $r2 = new Rope(string: "words 4");
        $rope2 = concatRope(r1: $r, r2: $r2);
        $rope = concatRope(r1: $rope1, r2: $rope2);
        $split = splitRope(rope: $rope, index: 10);
        $this->assertSame($split[0]->toString(), "words 1wor");
        $this->assertSame($split[1]->toString(), "ds2words3words 4");

        $r = new Rope(string: "words 1");
        $r2 = new Rope(string: "words2");
        $r3 = concatRope(r1: $r, r2: $r2);
        $split = splitRope(rope: $r3, index: 1);
    }
}
