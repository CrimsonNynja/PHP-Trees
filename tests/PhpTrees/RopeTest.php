<?php

use PHPUnit\Framework\TestCase;
use PhpTrees\Rope;

final class RopeTest extends TestCase
{
    public function testConstruct()
    {
        $r = new Rope();
        $this->assertNull($r->getRoot());

        $r = new Rope("test");
        $this->assertSame($r->getRoot()->getValue(), "test");
        $this->assertNull($r->getRoot()->getLeftChild());
        $this->assertNull($r->getRoot()->getRightChild());
    }

    public function testIndex()
    {
        $r = new Rope();
        $this->assertNull($r->index(1));
        $this->assertNull($r->getRoot());

        $r = new Rope("Test Word");
        $this->assertSame($r->index(0), "T");
        $this->assertSame($r->index(8), "d");
        $this->assertSame($r->index(3), "t");
        $this->assertSame($r->getRoot()->getWeight(), 9);

        $r = new Rope("Test");
        $r2 = new Rope("Word");
        $r3 = new Rope("Three");
        $r = concatRope($r, $r2);
        $r = concatRope($r, $r3);
        $this->assertSame($r->index(0), "T");
        $this->assertSame($r->index(4), "W");
        $this->assertSame($r->index(8), "T");
        $this->assertSame($r->index(9), "h");
        $this->assertSame($r->index(12), "e");
        $this->assertNull($r->index(13));
        $this->assertSame($r->getRoot()->getWeight(), 8);
    }

    public function testLength()
    {
        $r = new Rope();
        $this->assertSame($r->length(), 0);

        $r = new Rope("test");
        $this->assertSame($r->length(), 4);

        $r = new Rope("Test");
        $r2 = new Rope("Word");
        $r3 = new Rope("Three");
        $r = concatRope($r, $r2);
        $r = concatRope($r, $r3);
        $this->assertSame($r->length(), 13);
    }

    public function testToString()
    {
        $r = new Rope();
        $this->assertSame($r->toString(), "");

        $r = new Rope("test");
        $this->assertSame($r->toString(), "test");

        $r = new Rope("Test");
        $r2 = new Rope("Word");
        $r3 = new Rope("Three");
        $r = concatRope($r, $r2);
        $r = concatRope($r, $r3);
        $this->assertSame($r->toString(), "TestWordThree");
    }

    public function testInsert()
    {
        $r = new Rope("this is test");
        $r->insert("another ", 8);
        $this->assertSame($r->toString(), "this is another test");

        $r = new Rope("this is test");
        $r->insert("another ", 18);
        $this->assertSame($r->toString(), "this is testanother ");
    }

    public function testRemoveSubStr()
    {
        $r = new Rope("this is test");
        $r->removeSubstr(2, 2);
        $this->assertSame($r->toString(), "th is test");

        $r = new Rope("this is test");
        $r->removeSubstr(22, 45);
        $this->assertSame($r->toString(), "this is test");

        $r = new Rope("this is test");
        $r->removeSubstr(2, 42);
        $this->assertSame($r->toString(), "th");

        $r = new Rope("this is test");
        $r->removeSubstr(0, 1);
        $this->assertSame($r->toString(), "his is test");

        $r = new Rope("this is test");
        $r->removeSubstr(3, 0);
        $this->assertSame($r->toString(), "this is test");
    }

    public function testSubstr()
    {
        $r = new Rope("this is a test");
        $this->assertSame($r->substr(42, 67), "");
        $this->assertSame($r->substr(0), "this is a test");
        $this->assertSame($r->substr(5), "is a test");
        $this->assertSame($r->substr(2, 4), "is i");


        $r = new Rope("this is a test");
        $r2 = new Rope("this is second test");
        $concat = concatRope($r, $r2);
        $this->assertSame($concat->substr(2, 4), "is i");
        $this->assertSame($concat->substr(17), "s is second test");
        $this->assertSame($concat->substr(2, 15), "is is a testthi");
    }
}
