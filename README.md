# PHP-Trees

![GitHub Workflow build status badge](https://github.com/CrimsonNynja/PHP-Trees/workflows/Unit%20Tests/badge.svg) [![Latest Stable Version](https://poser.pugx.org/crimson-nynja/php-trees/v/stable)](https://packagist.org/packages/crimson-nynja/php-trees)

This repo is designed to have all common trees used in an easy to use php way

Current included are implementations of a Binary Search Tree, Rope, Binary Heap, and a Generic Tree, with more to come!

All tests are written in PHP Unit, and all code is written in the PSR-4 standards. Php Trees also requires PHP 8.1.0 or above, and utilizes all modern features of PHP.

PHP Trees can be installed through composer with

```bash
composer require crimson-nynja/php-trees
```

https://packagist.org/packages/crimson-nynja/php-trees

## Usage

To use the binary search tree, include the correct file and create it as such

```php
use PhpTrees\BinarySearchTree;

$b = new BinarySearchTree(rootValue: 5);
// This will create a binary search tree with a root of the value 5
```

To use the Rope

```php
use PhpTrees\Rope;

$r = new Rope(string: "This is a Rope!");
// This will create a Rope with the initial string, "This is a Rope!"
```

To use the Binary Heap

```php
use PhpTrees\BinaryHeap;

$h = new BinaryHeap();
// This will create an empty binary heap
```

To use the Generic Tree

```php
use PhpTrees\GenericTree;

$g = new GenericTree(rootValue: 4.1);
// This will create a generic tree with root 4.1
```

For a more detailed description of the features of PHP Trees, check out the wiki\
<https://github.com/CrimsonNynja/PHP-Trees/wiki>

## Coming up

tree balancing options\
2-3 tree\
B-Tree\
search/traversal types (depth first search breadth first search, etc)
