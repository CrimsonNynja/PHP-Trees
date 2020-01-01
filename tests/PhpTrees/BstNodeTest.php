<?php

use PHPUnit\Framework\TestCase;
use PhpTrees\BstNode;

final class BstNodeTest extends TestCase
{
    public function testConstruction()
    {
        $n = new BstNode(5);
        $this->assertSame($n->getValue(), 5);
        $this->assertNull($n->getLeftChild());
        $this->assertNull($n->getRightChild());
        $this->assertNull($n->getParent());
        $id = $n->getId();

        $n2 = new BstNode(1);
        $n2 = new BstNode(1);
        $n2 = new BstNode(1);

        $this->assertSame($n2->getId(), $id + 3);
    }

    public function testAddChild()
    {
        $n = new BstNode(5);
        $n->addChild(3);
        $n->addChild(7);
        $this->assertNull($n->getParent());
        $this->assertSame($n->getLeftChild()->getValue(), 3);
        $this->assertSame($n->getLeftChild()->getParent()->getValue(), 5);
        $this->assertSame($n->getRightChild()->getValue(), 7);
        $this->assertSame($n->getLeftChild()->getParent()->getValue(), 5);
    }

    public function testRemoveChild()
    {
        $n = new BstNode(5);
        $id = $n->getId();

        $n->removeChild(6);
        $this->assertNull($n->getLeftChild());
        $this->assertNull($n->getLeftChild());

        $n->addChild(3);
        $n->addChild(7);
        $n->removeChild($id+1);
        $this->assertNull($n->getLeftChild());
        $this->assertNotNull($n->getRightChild());

        $n->removeChild($id+2);
        $this->assertNull($n->getLeftChild());
        $this->assertNull($n->getLeftChild());
    }

    public function testIsLeaf()
    {
        $n = new BstNode(5);
        $this->assertTrue($n->isLeaf());

        $n->addChild(3);
        $this->assertFalse($n->isLeaf());

        $n->addChild(7);
        $this->assertFalse($n->isLeaf());
    }

    public function testHasChild()
    {
        $n = new BstNode(5);
        $this->assertFalse($n->hasChild(new BstNode(6)));

        $n->addChild(8);
        $this->assertFalse($n->hasChild(new BstNode(9)));
        $this->assertTrue(($n->hasChild($n->getRightChild())));

        $n->addChild(2);
        $this->assertFalse($n->hasChild(new BstNode(2)));
        $this->assertTrue(($n->hasChild($n->getLeftChild())));
    }

    public function testAddComparator()
    {
        $n = new BstNode("12345");
        $n->setComparator(function($val, $val2) {
            return (strlen($val) <= strlen($val2));
        });
        $n->addChild("1234");
        $n->addChild("12345678");
        $n->addChild("12");
        $n->addChild("1234");

        $this->assertSame($n->getValue(), "12345");
        $this->assertSame($n->getLeftChild()->getValue(), "1234");
        $this->assertSame($n->getRightChild()->getValue(), "12345678");
        $this->assertSame($n->getLeftChild()->getLeftChild()->getValue(), "12");
        $this->assertSame($n->getLeftChild()->getRightChild()->getValue(), "1234");
    }

    public function testHasComparator()
    {
        $n = new BstNode("12345");
        $this->assertFalse($n->hasComparator());

        $n->setComparator(function($v, $v2){
            return true;
        });
        $this->assertTrue($n->hasComparator());
    }
}
