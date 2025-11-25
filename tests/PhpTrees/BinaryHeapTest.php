<?php

namespace Tests\PhpTrees;

use PHPUnit\Framework\TestCase;
use PhpTrees\BinaryHeap;

final class BinaryHeapTest extends TestCase
{
    public function testConstruct()
    {
        $h = new BinaryHeap();
        $this->assertNull($h->getMinValue());
        $this->assertFalse($h->hasComparator());

        $h = new BinaryHeap(rootValue: 5);
        $this->assertSame($h->getMinValue(), 5);

        $h = new BinaryHeap(
            rootValue: 6,
            comparator: fn($a, $b) : bool => $a > $b
        );

        $this->assertTrue($h->hasComparator());
    }

    public function testMinValue()
    {
        $h = new BinaryHeap();
        $h->insert(value: 5);
        $this->assertSame($h->getMinValue(), 5);

        $h->insert(value: 4);
        $this->assertSame($h->getMinValue(), 4);

        $h->insert(value: 1);
        $this->assertSame($h->getMinValue(), 1);

        $h->insert(value: 7);
        $this->assertSame($h->getMinValue(), 1);
    }

    public function testMaxValue()
    {
        $h = new BinaryHeap();
        $this->assertNull($h->getMaxValue());

        $h = new BinaryHeap();
        $h->insert(value: 5);
        $this->assertSame($h->getMaxValue(), 5);

        $h->insert(value: 7);
        $this->assertSame($h->getMaxValue(), 7);

        $h->insert(value: 9);
        $this->assertSame($h->getMaxValue(), 9);

        $h->insert(value: 2);
        $this->assertSame($h->getMaxValue(), 9);
    }

    public function testInsert()
    {
        $h = new BinaryHeap();

        $h->insert(value: 5);
        $h->insert(value: 1);
        $h->insert(value: 9);
        $h->insert(value: 7);

        $this->assertSame($h->getMinValue(), 1);
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
        $h->constructFromArray(values: [1, 5, 3, 8, 7]);
        $this->assertContains(1, $h->getInternalArray());
        $this->assertContains(5, $h->getInternalArray());
        $this->assertContains(3, $h->getInternalArray());
        $this->assertContains(8, $h->getInternalArray());
        $this->assertContains(7, $h->getInternalArray());
        $this->assertSame($h->getMinValue(), 1);
        $this->assertSame($h->getMaxValue(), 8);

        $h->constructFromArray(values: [5, 3, 7, 15]);
        $this->assertSame($h->getMinValue(), 3);
        $this->assertSame($h->getMaxValue(), 15);
    }

    public function testSize()
    {
        $h = new BinaryHeap();
        $this->assertSame($h->getSize(), 0);

        $h->insert(value: 5);
        $h->insert(value: 1);
        $h->insert(value: 9);

        $this->assertSame($h->getSize(), 3);
    }

    public function testDeleteMin()
    {
        $h = new BinaryHeap();
        $h->deleteMin();
        $this->assertSame($h->getInternalArray(), []);

        $h = new BinaryHeap();
        $h->constructFromArray(values: [5, 2, 6, 3, 1, 7]);
        $oldMin = $h->deleteMin();
        $this->assertSame($oldMin, 1);
        $this->assertSame($h->getMinValue(), 2);
        $this->assertSame($h->getMaxValue(), 7);
    }

    public function testComparator()
    {
        $h = new BinaryHeap(
            rootValue: "a",
            comparator: fn($a, $b) : bool => strlen($a) <= strlen($b)
        );

        $h->insertMultiple("aa", "aaa", "aaaa", "aaaaa");
        $this->assertSame($h->getSize(), 5);
        $this->assertSame($h->getMinValue(), "aaaaa");
        $h->deleteMin();
        $this->assertSame($h->getMinValue(), "aaaa");

        $h = new BinaryHeap(
            rootValue: null,
            comparator: fn($a, $b) : bool => strlen($a) <= strlen($b)
        );

        $h->constructFromArray(values: ["a", "aa", "aaa", "aaaa"]);
        $this->assertSame($h->getSize(), 4);
        $this->assertSame($h->getMinValue(), "aaaa");
        $h->deleteMin();
        $this->assertSame($h->getMinValue(), "aaa");

        $h = new BinaryHeap(rootValue: "a");
        $cmp = $h->setComparitor(comparator: fn($a, $b) : bool => strlen($a) <= strlen($b));
        $this->assertTrue($cmp);
        $h->insertMultiple("aa", "aaa", "aaaa", "aaaaa");
        $this->assertSame($h->getSize(), 5);
        $this->assertSame($h->getMinValue(), "aaaaa");
        $h->deleteMin();

        $h = new BinaryHeap();
        $h->constructFromArray(values: ["a", "aa", "aaa", "aaaa"]);
        $cmp = $h->setComparitor(comparator: fn($a, $b) : bool => strlen($a) <= strlen($b));
        $this->assertFalse($cmp);
    }
}
