<?php

use PHPUnit\Framework\TestCase;
use PhpTrees\BinaryHeap;

final class BinaryHeapTest extends TestCase
{
    public function testConstruct()
    {
        $h = new BinaryHeap();
        $this->assertNull($h->getMinValue());

        $h = new BinaryHeap(5);
        $this->assertSame($h->getMinValue(), 5);
    }

    public function testMinValue()
    {
        $h = new BinaryHeap();
        $h->insert(5);
        $this->assertSame($h->getMinValue(), 5);

        $h->insert(4);
        $this->assertSame($h->getMinValue(), 4);

        $h->insert(1);
        $this->assertSame($h->getMinValue(), 1);

        $h->insert(7);
        $this->assertSame($h->getMinValue(), 1);
    }

    public function testMaxValue()
    {
        $h = new BinaryHeap();
        $this->assertNull($h->getMaxValue());

        $h = new BinaryHeap();
        $h->insert(5);
        $this->assertSame($h->getMaxValue(), 5);

        $h->insert(7);
        $this->assertSame($h->getMaxValue(), 7);

        $h->insert(9);
        $this->assertSame($h->getMaxValue(), 9);

        $h->insert(2);
        $this->assertSame($h->getMaxValue(), 9);
    }

    public function testInsert()
    {
        $h = new BinaryHeap();

        $h->insert(5);
        $h->insert(1);
        $h->insert(9);
        $h->insert(7);

        $this->assertSame($h->getMinValue(1), 1);
        $this->assertContains(5, $h->getInternalArray());
        $this->assertContains(7, $h->getInternalArray());
        $this->assertSame($h->getMaxValue(), 9);
    }

    public function testInsertMultiple()
    {
        $h = new BinaryHeap();
        $h->insertMultiple(1, 5, 6, 2, 4, 8, 6, 3);
        $this->assertContains(1, $h->getInternalArray());
        $this->assertContains(5, $h->getInternalArray());
        $this->assertContains(6, $h->getInternalArray());
        $this->assertContains(2, $h->getInternalArray());
        $this->assertContains(4, $h->getInternalArray());
        $this->assertContains(8, $h->getInternalArray());
        $this->assertContains(6, $h->getInternalArray());
        $this->assertContains(3, $h->getInternalArray());
    }

    public function testConstructAsArray()
    {
        $h = new BinaryHeap();
        $h->constructFromArray([1, 5, 3, 8, 7]);
        $this->assertContains(1, $h->getInternalArray());
        $this->assertContains(5, $h->getInternalArray());
        $this->assertContains(3, $h->getInternalArray());
        $this->assertContains(8, $h->getInternalArray());
        $this->assertContains(7, $h->getInternalArray());
        $this->assertSame($h->getMinValue(), 1);
        $this->assertSame($h->getMaxValue(), 8);

        $h->constructFromArray([5, 3, 7, 15]);
        $this->assertSame($h->getMinValue(), 3);
        $this->assertSame($h->getMaxValue(), 15);
    }

    public function testSize()
    {
        $h = new BinaryHeap();
        $this->assertSame($h->getSize(), 0);

        $h->insert(5);
        $h->insert(1);
        $h->insert(9);

        $this->assertSame($h->getSize(), 3);
    }

    public function testDeleteMin()
    {
        $h = new BinaryHeap();
        $h->deleteMin();
        $this->assertSame($h->getInternalArray(), []);

        $h = new BinaryHeap();
        $h->constructFromArray([5, 2, 6, 3, 1, 7]);
        $oldMin = $h->deleteMin();
        $this->assertSame($oldMin, 1);
        $this->assertSame($h->getMinValue(), 2);
        $this->assertSame($h->getMaxValue(), 7);
    }
}
