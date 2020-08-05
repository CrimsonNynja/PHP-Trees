<?php

use PHPUnit\Framework\TestCase;
use PhpTrees\BinarySearchTree;
use PhpTrees\BstNode;

final class BinarySearchTreeTest extends TestCase
{
    public function testConstruct()
    {
        $b = new BinarySearchTree(1);
        $this->assertSame($b->getRoot()->getValue(), 1);
        $this->assertNull($b->getRoot()->getLeftChild());
        $this->assertNull($b->getRoot()->getRightChild());

        $b = new BinarySearchTree();
        $this->assertNull($b->getRoot());
    }

    public function testInsert()
    {
        $b = new BinarySearchTree(5);
        $b->insert(7);
        $b->insert(3);
        $this->assertSame($b->getRoot()->getValue(), 5);
        $this->assertSame($b->getRoot()->getRightChild()->getValue(), 7);
        $this->assertSame($b->getRoot()->getLeftChild()->getValue(), 3);

        $b->insert(9);
        $this->assertSame($b->getRoot()->getRightChild()->getRightChild()->getValue(), 9);

        $b = new BinarySearchTree();
        $b->insert(7);
        $this->assertSame($b->getRoot()->getValue(), 7);
    }

    public function testGetRoot()
    {
        $b = new BinarySearchTree(5);
        $this->assertSame($b->getRoot()->getValue(), 5);
        $this->assertNull($b->getRoot()->getLeftChild());
        $this->assertNull($b->getRoot()->getRightChild());

        $b->insert(3);
        $b->insert(7);
        $this->assertSame($b->getRoot()->getValue(), 5);
        $this->assertSame($b->getRoot()->getLeftChild()->getValue(), 3);
        $this->assertSame($b->getRoot()->getRightChild()->getValue(), 7);

        $b = new BinarySearchTree();
        $this->assertNull($b->getRoot());

    }

    public function testGetSize()
    {
        $b = new BinarySearchTree();
        $this->assertSame($b->getSize(), 0);

        $b = new BinarySearchTree(5);
        $this->assertSame($b->getSize(), 1);

        $b->insert(7);
        $this->assertSame($b->getSize(), 2);
        $b->insertMultiple(1, 4, 5, 6, 7);
        $this->assertSame($b->getSize(), 7);
    }

    public function testGetMinValue()
    {
        $b = new BinarySearchTree(5);
        $this->assertSame($b->getMinValue(), 5);
        $b->insert(7);
        $this->assertSame($b->getMinValue(), 5);
        $b->insert(3);
        $this->assertSame($b->getMinValue(), 3);

        $b = new BinarySearchTree();
        $this->assertNull($b->getMinValue());
    }

    public function testGetMaxValue()
    {
        $b = new BinarySearchTree(5);
        $this->assertSame($b->getMaxValue(), 5);
        $b->insert(7);
        $this->assertSame($b->getMaxValue(), 7);
        $b->insert(3);
        $this->assertSame($b->getMaxValue(), 7);

        $b = new BinarySearchTree();
        $this->assertNull($b->getMaxValue());
    }

    public function testHasValue()
    {
        $b = new BinarySearchTree(5);
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
        $b = new BinarySearchTree(5);
        $b->insertMultiple(3, 7, 9);
        $this->assertTrue($b->hasValue(5));
        $this->assertTrue($b->hasValue(3));
        $this->assertTrue($b->hasValue(7));
        $this->assertTrue($b->hasValue(9));
    }

    public function testHasValues()
    {
        $b = new BinarySearchTree(5);
        $b->insertMultiple(3, 7, 9, 11, 15, 1, 2);
        $this->assertFalse($b->hasValues(1, 2, 3, 4));
        $this->assertTrue($b->hasValues(1, 5));
        $this->assertTrue($b->hasValues(5, 3, 7, 9, 11, 15, 1, 2));
    }

    public function testDeleteLeafNode()
    {
        $b = new BinarySearchTree(5);
        $b->insertMultiple(3, 7, 9, 11, 15, 1, 2);

        $this->assertTrue($b->hasValue(15));
        $b->delete($b->find(15));
        $this->assertFalse($b->hasValue(15));

        $b = new BinarySearchTree(5);
        $this->assertTrue($b->hasValue(5));
        $b->delete($b->find(5));
        $this->assertFalse($b->hasValue(5));
        $this->assertNull($b->getRoot());
    }

    public function testDeleteOneChild()
    {
        $b = new BinarySearchTree(5);
        $b->insertMultiple(3, 1);

        $this->assertTrue($b->hasValues(3, 5, 1));
        $b->delete($b->find(3));
        $this->assertFalse($b->hasValue(3));

        $this->assertTrue($b->hasValue(5, 1));
        $b->delete($b->find(5));
        $this->assertFalse($b->hasValue(5));
        $this->assertTrue($b->hasValue(1));
    }

    public function testDeleteTwoChildren()
    {
        $b = new BinarySearchTree(5);
        $b->insertMultiple(3, 7, 9, 11, 15, 1, 4);

        $this->assertTrue($b->hasValues(3, 7, 9, 11, 15, 1, 4, 5));
        $b->delete($b->find(3));
        $this->assertFalse($b->hasValue(3));
        $this->assertTrue($b->hasValues(7, 9, 11, 15, 1, 4, 5));

        $b->delete($b->find(5));
        $this->assertFalse($b->hasValue(5));
        $this->assertTrue($b->hasValues(7, 9, 11, 15, 1, 4));

        $b = new BinarySearchTree(5);
        $b->insertMultiple(6, 7, 8);
        $b->delete($b->find(6));
        $this->assertTrue($b->hasValue(5, 6, 8));

        $b = new BinarySearchTree(5);
        $b->insertMultiple(4, 3, 2);
        $b->delete($b->find(4));
        $this->assertTrue($b->hasValue(5, 3, 2));
    }

    public function testIteratorOneNodeOrJustRoot()
    {
        $b = new BinarySearchTree();
        foreach($b as $key => $node) {
            $this->fail("nothing should be retrieved here");
        }

        $b->insert(5);
        foreach($b as $key => $node) {
            $this->assertSame($node, 5);
        }
    }

    public function testIteratorStraightLeftNodes()
    {
        $b = new BinarySearchTree(10);
        $b->insertMultiple(5, 3, 2, 1);
        $result = [];
        foreach($b as $node) {
            $result[] = $node;
        }
        $this->assertSame($result, [1, 2, 3, 5, 10]);
    }

    public function testIteratorStraightRightNodes()
    {
        $b = new BinarySearchTree(10);
        $b->insertMultiple(15, 20, 21, 25);
        $result = [];
        foreach($b as $node) {
            $result[] = $node;
        }
        $this->assertSame($result, [10, 15, 20, 21, 25]);
    }

    public function testIteratorAllBranches()
    {
        $b = new BinarySearchTree(10);
        $b->insertMultiple(5, 15, 3, 7, 12, 20, 1, 4, 6, 8, 11, 13, 17, 22);
        $result = [];
        foreach($b as $node) {
            $result[] = $node;
        }
        $this->assertSame($result, [1, 3, 4, 5, 6, 7, 8, 10, 11, 12, 13, 15, 17, 20, 22]);
    }

    public function testClone()
    {
        $b = new BinarySearchTree(10);
        $b->insertMultiple(5, 15, 3, 7, 12, 20, 4, 6, 8, 11, 13, 17, 22);
        $result = [];
        foreach($b as $node) {
            $result[] = $node;
        }
        $this->assertSame($result, [3, 4, 5, 6, 7, 8, 10, 11, 12, 13, 15, 17, 20, 22]);

        $c = clone $b;
        $c->insert(34);
        $c->insert(1);
        $this->assertSame($c->getMinValue(), 1);
        $this->assertSame($b->getMinValue(), 3);
        $this->assertSame($c->getMaxValue(), 34);
        $this->assertSame($b->getMaxValue(), 22);
    }

    public function testComparator()
    {
        $b = new BinarySearchTree("12345",
            fn($val, $val2) : bool => strlen($val) <= strlen($val2)
        );
        $this->assertTrue($b->hasComparator());

        $b = new BinarySearchTree();
        $this->assertFalse($b->hasComparator());
        $cmp = $b->setComparator(
            fn($val, $val2) : bool => strlen($val) <= strlen($val2)
        );
        $this->assertTrue($cmp);

        $b->insertMultiple("12345", "12", "123", "123456", "1");

        $this->assertSame($b->getRoot()->getValue(), "12345");
        $this->assertSame($b->getRoot()->getLeftChild()->getValue(), "12");
        $this->assertSame($b->getRoot()->getLeftChild()->getRightChild()->getValue(), "123");
        $this->assertSame($b->getRoot()->getRightChild()->getValue(), "123456");
        $this->assertSame($b->getRoot()->getLeftChild()->getLeftChild()->getValue(), "1");

        $this->assertNotNull($b->find("12345"));
        $this->assertNotNull($b->find("12"));
        $this->assertNotNull($b->find("123"));
        $this->assertNotNull($b->find("123456"));
        $this->assertNotNull($b->find("1"));
        $this->assertNull($b->find("78"));

        $b = new BinarySearchTree();
        $b->insertMultiple("12345", "12", "123", "123456", "1");
        $cmp = $b->setComparator(fn($val, $val2) : bool => strlen($val) <= strlen($val2));
        $this->assertFalse($cmp);
    }
}
