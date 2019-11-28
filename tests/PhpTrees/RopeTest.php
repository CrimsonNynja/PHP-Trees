<?php

use PHPUnit\Framework\TestCase;
use PhpTrees\Rope;

class RopeTest extends TestCase
{
    public function testConstruct()
    {
        $r = new Rope();
        $this->assertNull($r->getRoot());

        $r = new Rope("test");
        $this->assertSame($r->getRoot()->getValue(), "test");
        $this->assertNull($r->getRoot()->getLeftChild());
        $this->assertNull($r->getRoot()->getRightChild());
    }
}
