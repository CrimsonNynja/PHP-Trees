<?php

use PHPUnit\Framework\TestCase;
use PhpTrees\GenericTree;

final class GenericTreeTest extends TestCase
{
    public function testConstruction()
    {
        $g = new GenericTree();
        $this->assertNull($g->getRoot()->getValue());

        $g = new GenericTree(rootValue: "Hello World");
        $this->assertSame($g->getRoot()->getValue(), "Hello World");
    }

    public function testFindNodeByValue()
    {
        $g = new GenericTree(rootValue: 'root');
        $g->getRoot()->addChildren('1', '2', 'h', 4, 6, 5.1);
        $g->getRoot()->getChildren()[0]->addChild(value: 9);

        $this->assertNotNull($g->findNodeByValue(value: '1'));
        $this->assertNotNull($g->findNodeByValue(value: 9));
        $this->assertNotNull($g->findNodeByValue(value: 'root'));
        $this->assertNull($g->findNodeByValue(value: 'NOT IN TREE'));
    }

    public function testFindNode()
    {
        $g = new GenericTree(rootValue: 'root');
        $g->getRoot()->addChildren('1', '2', 'h', 4, 6, 5.1);
        $g->getRoot()->getChildren()[0]->addChild(value: 9);

        $this->assertNotNull($g->findNode(id: $g->getRoot()->getID()));
        $this->assertNotNull($g->findNode(id: $g->getRoot()->getChildren()[0]->getID()));
        $this->assertNotNull($g->findNOde(id: $g->getRoot()->getChildren()[0]->getChildren()[0]->getID()));
        $this->assertNull($g->findNode(id: 1005));
    }
}
