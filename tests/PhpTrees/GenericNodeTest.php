<?php

use PHPUnit\Framework\TestCase;
use PhpTrees\GenericNode;

final class GenericNodeTest extends TestCase
{
    public function testConstruction()
    {
        $n = new GenericNode();
        $this->assertNull($n->getValue());
        $this->assertNull($n->getParent());
        $this->assertEmpty($n->getChildren());
        $this->assertSame($n->getID(), 0);

        $n = new GenericNode(value: "test");
        $this->assertSame($n->getValue(), "test");
        $this->assertNull($n->getParent());
        $this->assertEmpty($n->getChildren());
        $this->assertSame($n->getID(), 1);
    }

    public function testAddChild()
    {
        $n = new GenericNode(value: "test");
        $this->assertSame($n->getChildren(), []);
        $n->addChild(value: 1);
        $this->assertSame(count($n->getChildren()), 1);
        $this->assertSame($n->getChildren()[0]->getValue(), 1);
        $n->addChild(value: "harry");
        $this->assertSame(count($n->getChildren()), 2);
        $this->assertSame($n->getChildren()[0]->getValue(), 1);
        $this->assertSame($n->getChildren()[1]->getValue(), "harry");
    }

    public function testAddChildren()
    {
        $n = new GenericNode(value: "test");
        $n->addChildren(1, "word", 7.8, '4');
        $this->assertSame(count($n->getChildren()), 4);
        $this->assertSame($n->getChildren()[0]->getValue(), 1);
        $this->assertSame($n->getChildren()[1]->getValue(), "word");
        $this->assertSame($n->getChildren()[2]->getValue(), 7.8);
        $this->assertSame($n->getChildren()[3]->getValue(), '4');
    }

    public function testAddChildFromNode()
    {
        $n = new GenericNode(value: "test");
        $n2 = new GenericNode(value: "test2");
        $n->addChildFromNode(node: $n2);
        $this->assertSame($n->getChildren()[0], $n2);
        $this->assertSame($n2->getParent(), $n);

        try {
            $n2->addChildFromNode(node: $n);
            $this->fail("Exception for Cyclic Tree should be thrown");
        } catch (Exception $e) {
            $this->assertEquals("Error: adding this node will create a cycle", $e->getMessage());
        }
    }
}
