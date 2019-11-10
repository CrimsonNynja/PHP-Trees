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
        $this->assertSame($n->getLeftChild()->getValue(), 3);
        $this->assertSame($n->getRightChild()->getValue(), 7);
    }
}
