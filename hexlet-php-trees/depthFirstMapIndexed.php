<?php

/*  Bypass all array elements
    applying the passed handler function
    to each node of the tree
*/

$map = function ($func, $tree) use (&$map) {
    $children = $tree[1] ?? null;
    $newName = $func($tree);

    if (!$children) {
        return [$newName];
    }

    return [$newName, array_map(function ($node) use ($func, $map) {
        return $map($func, $node);
    }, $children)];
};

/* TREE:
       A
     / | \
    B  E  F
   / \   / \
  C  D  G  H
          / \
         I  J
*/

$tree = ['A', [
    ['B', [['C'], ['D']]],
    ['E'],
    ['F', [['G'], ['H', [['I'], ['J']]]]]
]];

$result = $map(function ($node) {
    [$name] = $node;
    return strtolower($name);
}, $tree);

print_r(json_encode($result));
