<?php

use PHPUnit\Framework\TestCase;
use PhpTrees\BinarySearchTree;
use PhpTrees\Node;

class BinarySearchTreeTest extends TestCase
{
    public function testConstruct()
    {
        $b = new PhpTrees\BinarySearchTree(1);
        $this->assertSame($b->getRoot()->getValue(), 1);
        $this->assertNull($b->getRoot()->getLeftChild());
        $this->assertNull($b->getRoot()->getRightChild());
    }

    public function testInsert()
    {
        $b = new PhpTrees\BinarySearchTree(5);
        $b->insert(7);
        $b->insert(3);
        $this->assertSame($b->getRoot()->getValue(), 5);
        $this->assertSame($b->getRoot()->getRightChild()->getValue(), 7);
        $this->assertSame($b->getRoot()->getLeftChild()->getValue(), 3);

        $b->insert(9);
        $this->assertSame($b->getRoot()->getRightChild()->getRightChild()->getValue(), 9);
    }

    public function testGetRoot()
    {
        $b = new PhpTrees\BinarySearchTree(5);
        $this->assertSame($b->getRoot()->getValue(), 5);
        $this->assertNull($b->getRoot()->getLeftChild());
        $this->assertNull($b->getRoot()->getRightChild());

        $b->insert(3);
        $b->insert(7);
        $this->assertSame($b->getRoot()->getValue(), 5);
        $this->assertSame($b->getRoot()->getLeftChild()->getValue(), 3);
        $this->assertSame($b->getRoot()->getRightChild()->getValue(), 7);
    }

    public function testGetMinValue()
    {
        $b = new PhpTrees\BinarySearchTree(5);
        $this->assertSame($b->getMinValue(), 5);
        $b->insert(7);
        $this->assertSame($b->getMinValue(), 5);
        $b->insert(3);
        $this->assertSame($b->getMinValue(), 3);
    }

    public function testGetMaxValue()
    {
        $b = new PhpTrees\BinarySearchTree(5);
        $this->assertSame($b->getMaxValue(), 5);
        $b->insert(7);
        $this->assertSame($b->getMaxValue(), 7);
        $b->insert(3);
        $this->assertSame($b->getMaxValue(), 7);
    }

    public function testHasValue()
    {
        $b = new PhpTrees\BinarySearchTree(5);
        $this->assertTrue($b->hasValue(5));
        $this->assertFalse($b->hasValue(7));

        $b->insert(3);
        $b->insert(7);
        $this->assertTrue($b->hasValue(3));
        $this->assertTrue($b->hasValue(7));

        $b->insert(9);
        $b->insert(11);
        $this->assertTrue($b->hasValue(9));
        $this->assertTrue($b->hasValue(11));
    }

    public function testInsertMultiple()
    {
        $b = new PhpTrees\BinarySearchTree(5);
        $b->insertMultiple(3, 7, 9);
        $this->assertTrue($b->hasValue(5));
        $this->assertTrue($b->hasValue(3));
        $this->assertTrue($b->hasValue(7));
        $this->assertTrue($b->hasValue(9));
    }

    public function testHasValues()
    {
        $b = new PhpTrees\BinarySearchTree(5);
        $b->insertMultiple(3, 7, 9, 11, 15, 1, 2);
        $this->assertFalse($b->hasValues(1, 2, 3, 4));
        $this->assertTrue($b->hasValues(1, 5));
        $this->assertTrue($b->hasValues(5, 3, 7, 9, 11, 15, 1, 2));
    }
}
