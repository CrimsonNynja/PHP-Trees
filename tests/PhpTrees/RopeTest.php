<?php

namespace Tests\PhpTrees;

use Exception;
use PHPUnit\Framework\TestCase;
use PhpTrees\Rope;

final class RopeTest extends TestCase
{
    public function testConstruct()
    {
        $r = new Rope();
        $this->assertNull($r->getRoot());

        $r = new Rope(string: "test");
        $this->assertSame($r->getRoot()->getValue(), "test");
        $this->assertNull($r->getRoot()->getLeftChild());
        $this->assertNull($r->getRoot()->getRightChild());
    }

    public function testIndex()
    {
        $r = new Rope();
        $this->assertNull($r->index(index: 1));
        $this->assertNull($r->getRoot());

        $r = new Rope(string: "Test Word");
        $this->assertSame($r->index(index: 0), "T");
        $this->assertSame($r->index(index: 8), "d");
        $this->assertSame($r->index(index: 3), "t");
        $this->assertSame($r->getRoot()->getWeight(), 9);

        $r = new Rope(string: "Test");
        $r2 = new Rope(string: "Word");
        $r3 = new Rope(string: "Three");
        $r = concatRope(r1: $r, r2: $r2);
        $r = concatRope(r1: $r, r2: $r3);
        $this->assertSame($r->index(index: 0), "T");
        $this->assertSame($r->index(index: 4), "W");
        $this->assertSame($r->index(index: 8), "T");
        $this->assertSame($r->index(index: 9), "h");
        $this->assertSame($r->index(index: 12), "e");
        $this->assertNull($r->index(index: 13));
        $this->assertSame($r->getRoot()->getWeight(), 8);
    }

    public function testLength()
    {
        $r = new Rope();
        $this->assertSame($r->length(), 0);

        $r = new Rope(string: "test");
        $this->assertSame($r->length(), 4);

        $r = new Rope(string: "Test");
        $r2 = new Rope(string: "Word");
        $r3 = new Rope(string: "Three");
        $r = concatRope(r1: $r, r2: $r2);
        $r = concatRope(r1: $r, r2: $r3);
        $this->assertSame($r->length(), 13);
    }

    public function testInsert()
    {
        $r = new Rope(string: "this is test");
        $r->insert(value: "another ", index: 8);
        $this->assertSame($r->toString(), "this is another test");

        $r = new Rope(string: "this is test");
        $r->insert(value: "another ", index: 18);
        $this->assertSame($r->toString(), "this is testanother ");

        $r = new Rope(string: "now this is test");
        $r->insert(value: "ing");
        $this->assertSame($r->toString(), "now this is testing");
    }

    public function testRemoveSubStr()
    {
        $r = new Rope(string: "this is test");
        $r->removeSubstr(start: 2, length: 2);
        $this->assertSame($r->toString(), "th is test");

        $r = new Rope(string: "this is test");
        $r->removeSubstr(start: 22, length: 45);
        $this->assertSame($r->toString(), "this is test");

        $r = new Rope(string: "this is test");
        $r->removeSubstr(start: 2, length: 42);
        $this->assertSame($r->toString(), "th");

        $r = new Rope(string: "this is test");
        $r->removeSubstr(start: 0, length: 1);
        $this->assertSame($r->toString(), "his is test");

        $r = new Rope(string: "this is test");
        $r->removeSubstr(start: 3, length: 0);
        $this->assertSame($r->toString(), "this is test");
    }

    public function testSubstr()
    {
        $r = new Rope(string: "this is a test");
        $this->assertSame($r->substr(start: 42, length: 67), "");
        $this->assertSame($r->substr(start: 0), "this is a test");
        $this->assertSame($r->substr(start: 5), "is a test");
        $this->assertSame($r->substr(start: 2, length: 4), "is i");


        $r = new Rope(string: "this is a test");
        $r2 = new Rope(string: "this is second test");
        $concat = concatRope(r1: $r, r2: $r2);
        $this->assertSame($concat->substr(start: 2, length: 4), "is i");
        $this->assertSame($concat->substr(start: 17), "s is second test");
        $this->assertSame($concat->substr(start: 2, length: 15), "is is a testthi");
    }

    public function testToString()
    {
        $r = new Rope();
        $this->assertSame($r->toString(), "");

        $r = new Rope(string: "test");
        $this->assertSame($r->toString(), "test");

        $r = new Rope(string: "Test");
        $r2 = new Rope(string: "Word");
        $r3 = new Rope(string: "Three");
        $r = concatRope(r1: $r, r2: $r2);
        $r = concatRope(r1: $r, r2: $r3);
        $this->assertSame($r->toString(), "TestWordThree");
    }

    public function testOffsetGet()
    {
        $r = new Rope(string: "test string");
        $r2 = new Rope(string: "second test");
        $concat = concatRope(r1: $r, r2: $r2);

        $this->assertSame($r[0], "t");
        $this->assertSame($r[5], "s");
        $this->assertSame($concat[16], "d");
        try {
            $this->assertSame($r["test"], "a");
            $this->fail("Exception for non integer index should be thrown");
        } catch (Exception $e) {
            $this->assertEquals("Rope offset must be an integer", $e->getMessage());
        }
    }

    public function testOffsetExists()
    {
        $r = new Rope(string: "test string");
        $r2 = new Rope(string: "second test");
        $concat = concatRope(r1: $r, r2: $r2);

        $this->assertTrue(isset($r[0]));
        $this->assertFalse(isset($r[67]));
        $this->assertTrue(isset($concat[0]));
        $this->assertTrue(isset($concat[20]));
        $this->assertFalse(isset($concat[67]));

        try {
            $this->assertTrue(isset($concat["test"]));
            $this->fail("Exception for non integer index should be thrown");
        } catch (Exception $e) {
            $this->assertEquals("Rope offset must be an integer", $e->getMessage());
        }
    }

    public function testRemoveOffset()
    {
        $r = new Rope(string: "test string");
        $r2 = new Rope(string: "second test");
        $concat = concatRope(r1: $r, r2: $r2);

        unset($r[0]);
        $this->assertSame($r->toString(), "est string");
        unset($concat[20]);
        $this->assertSame($concat->toString(), "test stringsecond tet");

        try {
            unset($concat["test"]);
            $this->fail("Exception for non integer index should be thrown");
        } catch (Exception $e) {
            $this->assertEquals("Rope offset must be an integer", $e->getMessage());
        }
    }

    public function testOffsetSet()
    {
        $r = new Rope(string: "test string");
        $r2 = new Rope(string: "second test");
        $concat = concatRope(r1: $r, r2: $r2);


        $r[] = 'More Words';
        $this->assertSame($r->toString(), "test stringMore Words");
        $r[0] = 'w';
        $this->assertSame($r->toString(), "west stringMore Words");
        $concat[20] = 'a';
        $this->assertSame($concat->toString(), "test stringsecond teat");

        try {
            $concat["test"] = 'w';
            $this->fail("Exception for non integer index should be thrown");
        } catch (Exception $e) {
            $this->assertEquals("Rope offset must be an integer", $e->getMessage());
        }

        try {
            $concat[6] = 'more';
            $this->fail("Exception for set constraints should be thrown");
        } catch (Exception $e) {
            $this->assertEquals("Value must be a 1 char string", $e->getMessage());
        }
    }

    public function test__toString()
    {
        $r = new Rope(string: "words");
        $this->expectOutputString("words");
        echo $r;
    }
}
