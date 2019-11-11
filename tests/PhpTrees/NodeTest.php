<?php

use PHPUnit\Framework\TestCase;
use PhpTrees\Node;

class NodeTest extends TestCase
{
    public function testConstruction()
    {
        $n = new Node(5);
        $this->assertSame($n->getValue(), 5);
        $this->assertNull($n->getLeftChild());
        $this->assertNull($n->getRightChild());
        $this->assertNull($n->getParent());
        $id = $n->getId();

        $n2 = new Node(1);
        $n2 = new Node(1);
        $n2 = new Node(1);

        $this->assertSame($n2->getId(), $id + 3);
    }

    public function testAddChild()
    {
        $n = new Node(5);
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
        $n = new Node(5);
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
        $n = new Node(5);
        $this->assertTrue($n->isLeaf());

        $n->addChild(3);
        $this->assertFalse($n->isLeaf());

        $n->addChild(7);
        $this->assertFalse($n->isLeaf());
    }
}
