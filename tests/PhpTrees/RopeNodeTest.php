<?php

use PHPUnit\Framework\TestCase;
use PhpTrees\RopeNode;

class RopeNodeTest extends TestCase
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
}
