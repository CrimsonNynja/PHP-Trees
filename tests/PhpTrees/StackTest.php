<?php

use PHPUnit\Framework\TestCase;
use PhpTrees\Stack;

final class StackTest extends TestCase
{
    public function testPush()
    {
        $s = new Stack();
        $s->push(1);
        $this->assertSame($s->getAsArray(), [1]);

        $s->push(2, 3, 4, 5);
        $this->assertSame($s->getAsArray(), [1, 2, 3, 4, 5]);
    }

    public function testPop()
    {
        $s = new Stack();
        $s->push(1, 2, 5);
        $this->assertSame($s->pop(), 5);
        $this->assertSame($s->pop(), 2);
        $this->assertSame($s->pop(), 1);
        $this->assertSame($s->pop(), null);
    }

    public function testPeek()
    {
        $s = new Stack();
        $this->assertSame($s->peek(), false);

        $s->push(1, 2, 3, 4);
        $this->assertSame($s->peek(), 4);
    }

    public function testClear()
    {
        $s = new Stack();
        $s->clear();
        $this->assertEmpty($s->getAsArray());

        $s->push(1, 2, 3, 4, 5);
        $s->clear();
        $this->assertEmpty($s->getAsArray());
    }

    public function testGetSize()
    {
        $s = new Stack();
        $this->assertSame($s->getSize(), 0);

        $s->push(1, 2, 3, 4, 5);
        $this->assertSame($s->getSize(), 5);
    }

    public function testIsEmpty()
    {
        $s = new Stack();
        $this->assertTrue($s->isEmpty());

        $s->push(1, 2, 3, 4, 5);
        $this->assertFalse($s->isEmpty());
    }
}
