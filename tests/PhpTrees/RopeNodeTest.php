<?php

use PHPUnit\Framework\TestCase;
use PhpTrees\RopeNode;

final class RopeNodeTest extends TestCase
{
    public function testConstruct()
    {
        $n = new PhpTrees\RopeNode("test");
        $this->assertSame($n->getValue(), "test");
        $this->assertNull($n->getRightChild());
        $this->assertNull($n->getLeftChild());
        $this->assertNull($n->getParent());
        $this->assertSame($n->getWeight(), 4);

        $n = new PhpTrees\RopeNode();
        $this->assertNull($n->getValue());
        $this->assertNull($n->getRightChild());
        $this->assertNull($n->getLeftChild());
        $this->assertNull($n->getParent());
        $this->assertSame($n->getWeight(), 0);
    }

    public function testAddRightChild()
    {
        $n = new PhpTrees\RopeNode("test");
        $this->assertNull($n->getRightChild());
        $this->assertNull($n->getLeftChild());
        $this->assertSame($n->getWeight(), 4);
        $this->assertSame($n->getValue(), "test");

        $n->addRightChild(new PhpTrees\RopeNode("test2"));
        $this->assertNull($n->getLeftChild());
        $this->assertSame($n->getWeight(), 0);
        $this->assertNull($n->getValue());
        $this->assertSame($n->getRightChild()->getValue(), "test2");

        $n = new PhpTrees\RopeNode("test");
        $n->addLeftChild(new PhpTrees\RopeNode("test2"));
        $n->addRightChild(new PhpTrees\RopeNode("test2"));
        $this->assertSame($n->getWeight(), 5);
        $this->assertNull($n->getValue());
        $this->assertSame($n->getRightChild()->getValue(), "test2");
    }

    public function testAddLeftChild()
    {
        $n = new PhpTrees\RopeNode("test");
        $this->assertNull($n->getRightChild());
        $this->assertNull($n->getLeftChild());
        $this->assertSame($n->getWeight(), 4);
        $this->assertSame($n->getValue(), "test");

        $n->addLeftChild(new PhpTrees\RopeNode("test2"));
        $this->assertNull($n->getRightChild());
        $this->assertSame($n->getWeight(), 5);
        $this->assertNull($n->getValue());
        $this->assertSame($n->getLeftChild()->getValue(), "test2");
    }

    public function testGetLeafWeights()
    {
        $n = new PhpTrees\RopeNode();
        $this->assertSame($n->getLeafWeights(), 0);

        $n = new PhpTrees\RopeNode("test");
        $this->assertSame($n->getLeafWeights(), 4);

        $n = new PhpTrees\RopeNode("test");
        $n->addLeftChild(new PhpTrees\RopeNode("test2"));
        $this->assertSame($n->getLeafWeights(), 5);
        $n->addRightChild(new PhpTrees\RopeNode("test3"));
        $this->assertSame($n->getLeafWeights(), 10);
    }

    public function testHasChildren()
    {
        $n = new PhpTrees\RopeNode();
        $this->assertFalse($n->hasChildren());

        $n = new PhpTrees\RopeNode("test");
        $this->assertFalse($n->hasChildren());

        $n = new PhpTrees\RopeNode();
        $n->addRightChild(new PhpTrees\RopeNode("test2"));
        $this->assertTrue($n->hasChildren());

        $n = new PhpTrees\RopeNode();
        $n->addLeftChild(new PhpTrees\RopeNode("test2"));
        $this->assertTrue($n->hasChildren());

        $n = new PhpTrees\RopeNode();
        $n->addRightChild(new PhpTrees\RopeNode("test2"));
        $n->addLeftChild(new PhpTrees\RopeNode("test2"));
        $this->assertTrue($n->hasChildren());
    }

    public function testSplitAndAddChildren()
    {
        $n = new PhpTrees\RopeNode();
        $n->splitAndAddChildren(5);
        $this->assertNull($n->getLeftChild());
        $this->assertNull($n->getRightChild());

        $n = new PhpTrees\RopeNode("This is a test");
        $n->splitAndAddChildren(14);
        $this->assertNull($n->getLeftChild());
        $this->assertNull($n->getRightChild());

        $n = new PhpTrees\RopeNode("This is a test");
        $n->splitAndAddChildren(5);
        $this->assertSame("This ", $n->getLeftChild()->getValue());
        $this->assertSame("is a test", $n->getRightChild()->getValue());
        $this->assertNull($n->getValue());
        $this->assertSame($n->getWeight(), 5);
    }
}
