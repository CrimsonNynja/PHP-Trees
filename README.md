# PHP-Trees

![GitHub Workflow build status badge](https://github.com/CrimsonNynja/PHP-Trees/workflows/Unit%20Tests/badge.svg)


This repo is designed to have all common trees used in an easy to use php way

Current included are implementations of a Binary Search Tree and a Rope, with more to come!

All tests are written in PHP Unit, and all code is written in the PSR-4 standards. Php Trees also requires PHP 7.2 or above

PHP Trees can be installed through composer with

```bash
composer require crimson-nynja/php-trees
```

https://packagist.org/packages/crimson-nynja/php-trees

## Usage

To use the binary search tree, include the correct file and create it as such

```php
use PhpTrees\BinarySearchTree;

$b = new PhpTrees\BinarySearchTree(5);
```

To use the Rope

```php
use PhpTrees\Rope;

$r = new PhpTrees\Rope("This is a Rope!");
```

This will create a binary search tree with a root of the value 5\
For a more detailed description of the features of PHP Trees, check out the wiki\
<https://github.com/CrimsonNynja/PHP-Trees/wiki>

## Coming up

custom comparators for inserting any type (BST)\
tree balancing options\
2-3 tree\
Heep\
B-Tree\
Generic Tree\
search/traversal types (depth first search breadth first search, etc)\
