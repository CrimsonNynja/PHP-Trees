<?php

use PHPUnit\Framework\TestCase;
use PhpTrees\BinaryTree;
use PhpTrees\Node;

class BinaryTreeTest extends TestCase
{
    public function testConstruct()
    {
        $b = new PhpTrees\BinaryTree(1);
        $this->assertSame($b->getRoot()->getValue(), 1);
        $this->assertNull($b->getRoot()->getLeftChild());
        $this->assertNull($b->getRoot()->getRightChild());
    }

    // public function testInsert()
    // {
    //     $b = new PhpTrees\BinaryTree(5);
    //     $b->insert(7);
    //     $b->insert(3);
    //     $this->assertSame($b->getRoot()->getValue(), 5);
    //     $this->assertSame($b->getRoot()->getRightChild()->getValue(), 7);
    //     $this->assertSame($b->getRoot()->getLeftChild()->getValue(), 3);

    //     $b->insert(9);
    //     $this->assertSame($b->getRoot()->getRightChild()->getRightChild()->getValue(), 9);
    // }

    // public function testGetRoot()
    // {
    //     $b = new PhpTrees\BinaryTree(5);
    //     $this->assertSame($b->getRoot()->getValue(), 5);
    //     $this->assertNull($b->getRoot()->getLeftChild());
    //     $this->assertNull($b->getRoot()->getRightChild());

    //     $b->insert(3);
    //     $b->insert(7);
    //     $this->assertSame($b->getRoot()->getValue(), 5);
    //     $this->assertSame($b->getRoot()->getLeftChild()->getValue(), 3);
    //     $this->assertSame($b->getRoot()->getRightChild()->getValue(), 7);
    // }

    // public function testGetMinValue()
    // {
    //     $b = new PhpTrees\BinaryTree(5);
    //     $this->assertSame($b->getMinValue(), 5);
    //     $b->insert(7);
    //     $this->assertSame($b->getMinValue(), 5);
    //     $b->insert(3);
    //     $this->assertSame($b->getMinValue(), 3);
    // }

    // public function testGetMaxValue()
    // {
    //     $b = new PhpTrees\BinaryTree(5);
    //     $this->assertSame($b->getMaxValue(), 5);
    //     $b->insert(7);
    //     $this->assertSame($b->getMaxValue(), 7);
    //     $b->insert(3);
    //     $this->assertSame($b->getMaxValue(), 7);
    // }

    public function testHasValue()
    {
        $b = new PhpTrees\BinaryTree(5);
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
}
