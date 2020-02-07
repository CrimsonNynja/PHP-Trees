<?php

use PHPUnit\Framework\TestCase;
use PhpTrees\GenericTree;

final class GenericTreeTest extends TestCase
{
    public function testConstruction()
    {
        $g = new GenericTree();
        $this->assertNull($g->getRoot()->getValue());

        $g = new GenericTree("Hello World");
        $this->assertSame($g->getRoot()->getValue(), "Hello World");
    }

    public function testFindNodeByValue()
    {
        $g = new GenericTree('root');
        $g->getRoot()->addChildren('1', '2', 'h', 4, 6, 5.1);
        $g->getRoot()->getChildren()[0]->addChild(9);

        $this->assertNotNull($g->findNodeByValue('1'));
        $this->assertNotNull($g->findNodeByValue(9));
        $this->assertNotNull($g->findNodeByValue('root'));
        $this->assertNull($g->findNodeByValue('NOT IN TREE'));
    }

    public function testFindNode()
    {
        $g = new GenericTree('root');
        $g->getRoot()->addChildren('1', '2', 'h', 4, 6, 5.1);
        $g->getRoot()->getChildren()[0]->addChild(9);

        $this->assertNotNull($g->findNode($g->getRoot()->getID()));
        $this->assertNotNull($g->findNode($g->getRoot()->getChildren()[0]->getID()));
        $this->assertNotNull($g->findNOde($g->getRoot()->getChildren()[0]->getChildren()[0]->getID()));
        $this->assertNull($g->findNode(1005));
    }
}
