<?php

namespace Tests\PhpTrees;

use PHPUnit\Framework\TestCase;
use PhpTrees\RopeNode;

final class RopeNodeTest extends TestCase
{
    public function testConstruct()
    {
        $n = new RopeNode(value: "test");
        $this->assertSame($n->getValue(), "test");
        $this->assertNull($n->getRightChild());
        $this->assertNull($n->getLeftChild());
        $this->assertNull($n->getParent());
        $this->assertSame($n->getWeight(), 4);

        $n = new RopeNode();
        $this->assertNull($n->getValue());
        $this->assertNull($n->getRightChild());
        $this->assertNull($n->getLeftChild());
        $this->assertNull($n->getParent());
        $this->assertSame($n->getWeight(), 0);
    }

    public function testAddRightChild()
    {
        $n = new RopeNode(value: "test");
        $this->assertNull($n->getRightChild());
        $this->assertNull($n->getLeftChild());
        $this->assertSame($n->getWeight(), 4);
        $this->assertSame($n->getValue(), "test");

        $n->addRightChild(node: new RopeNode(value: "test2"));
        $this->assertNull($n->getLeftChild());
        $this->assertSame($n->getWeight(), 0);
        $this->assertNull($n->getValue());
        $this->assertSame($n->getRightChild()->getValue(), "test2");
        $this->assertSame($n->getRightChild()->getParent(), $n);


        $n = new RopeNode(value: "test");
        $n->addLeftChild(node: new RopeNode(value: "test2"));
        $n->addRightChild(node: new RopeNode(value: "test2"));
        $this->assertSame($n->getWeight(), 5);
        $this->assertNull($n->getValue());
        $this->assertSame($n->getRightChild()->getValue(), "test2");
    }

    public function testAddLeftChild()
    {
        $n = new RopeNode(value: "test");
        $this->assertNull($n->getRightChild());
        $this->assertNull($n->getLeftChild());
        $this->assertSame($n->getWeight(), 4);
        $this->assertSame($n->getValue(), "test");

        $n->addLeftChild(node: new RopeNode(value: "test2"));
        $this->assertNull($n->getRightChild());
        $this->assertSame($n->getWeight(), 5);
        $this->assertNull($n->getValue());
        $this->assertSame($n->getLeftChild()->getValue(), "test2");
        $this->assertSame($n->getLeftChild()->getParent(), $n);
    }

    public function testGetLeafWeights()
    {
        $n = new RopeNode();
        $this->assertSame($n->getLeafWeights(), 0);

        $n = new RopeNode(value: "test");
        $this->assertSame($n->getLeafWeights(), 4);

        $n = new RopeNode(value: "test");
        $n->addLeftChild(node: new RopeNode(value: "test2"));
        $this->assertSame($n->getLeafWeights(), 5);
        $n->addRightChild(node: new RopeNode(value: "test3"));
        $this->assertSame($n->getLeafWeights(), 10);
    }

    public function testHasChildren()
    {
        $n = new RopeNode();
        $this->assertFalse($n->hasChildren());

        $n = new RopeNode(value: "test");
        $this->assertFalse($n->hasChildren());

        $n = new RopeNode();
        $n->addRightChild(node: new RopeNode(value: "test2"));
        $this->assertTrue($n->hasChildren());

        $n = new RopeNode();
        $n->addLeftChild(node: new RopeNode(value: "test2"));
        $this->assertTrue($n->hasChildren());

        $n = new RopeNode();
        $n->addRightChild(node: new RopeNode(value: "test2"));
        $n->addLeftChild(node: new RopeNode(value: "test2"));
        $this->assertTrue($n->hasChildren());
    }

    public function testSplitAndAddChildren()
    {
        $n = new RopeNode();
        $n->splitAndAddChildren(index: 5);
        $this->assertNull($n->getLeftChild());
        $this->assertNull($n->getRightChild());

        $n = new RopeNode(value: "This is a test");
        $n->splitAndAddChildren(index: 14);
        $this->assertNull($n->getLeftChild());
        $this->assertNull($n->getRightChild());

        $n = new RopeNode(value: "This is a test");
        $n->splitAndAddChildren(index: 5);
        $this->assertSame("This ", $n->getLeftChild()->getValue());
        $this->assertSame("is a test", $n->getRightChild()->getValue());
        $this->assertNull($n->getValue());
        $this->assertSame($n->getWeight(), 5);
    }

    public function testUpdateValue()
    {
        $n = new RopeNode(value: "words");
        $n->updateValue(value: "bob");
        $this->assertSame($n->getValue(), "bob");

        $n = new RopeNode(value: "words");
        $n->addLeftChild(node: new RopeNode(value: "bob"));
        $n->updateValue(value: "bob");
        $this->assertNull($n->getValue());
    }

    public function testRemoveRightChild()
    {
        $n = new RopeNode();
        $c = $n->removeRightChildren();
        $this->assertNull($c);
        $this->assertNull($n->getRightChild());

        $n = new RopeNode();
        $n->addLeftChild(node: new RopeNode(value: "ln"));
        $c = $n->removeRightChildren();
        $this->assertNull($c);
        $this->assertNull($n->getRightChild());

        $n = new RopeNode();
        $n->addRightChild(node: new RopeNode(value: "rn"));
        $c = $n->removeRightChildren();
        $this->assertSame($c->getValue(), "rn");
        $this->assertNull($n->getRightChild());

        $n = new RopeNode();
        $n->addLeftChild(node: new RopeNode(value: "ln"));
        $n->addRightChild(node: new RopeNode(value: "rn"));
        $c = $n->removeRightChildren();
        $this->assertSame($c->getValue(), "rn");
        $this->assertNull($n->getRightChild());
    }
}
