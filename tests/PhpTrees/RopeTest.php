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

    public function testInsert()
    {
        $r = new Rope("this is test");
        $r->insert("another ", 8);
        $this->assertSame($r->toString(), "this is another test");

        $r = new Rope("this is test");
        $r->insert("another ", 18);
        $this->assertSame($r->toString(), "this is testanother ");

        $r = new Rope("now this is test");
        $r->insert("ing");
        $this->assertSame($r->toString(), "now this is testing");
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

    public function testOffsetGet()
    {
        $r = new Rope("test string");
        $r2 = new Rope("second test");
        $concat = concatRope($r, $r2);

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
        $r = new Rope("test string");
        $r2 = new Rope("second test");
        $concat = concatRope($r, $r2);

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
        $r = new Rope("test string");
        $r2 = new Rope("second test");
        $concat = concatRope($r, $r2);

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
        $r = new Rope("test string");
        $r2 = new Rope("second test");
        $concat = concatRope($r, $r2);


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
}
