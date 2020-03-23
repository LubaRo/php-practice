<?php

/* Count all nodes of the tree */

$reduce = function (callable $func, array $tree, $acc) use (&$reduce) {
    $updatedAcc = $func($acc, $tree);
    $children = $tree[1] ?? null;

    if (!$children) {
        return $updatedAcc;
    }

    return array_reduce($children, function ($acc, $item) use ($func, $reduce) {
        return $reduce($func, $item, $acc);
    }, $updatedAcc);
};

/* TREE:
       A
     / | \
    B  E  F
   / \   / \
  C  D  G  H
          / \
         I  J
           / \
          K   L
*/

$tree = ['A', [
    ['B', [['C'], ['D']]],
    ['E'],
    ['F', [['G'], ['H', [['I'], ['J', [['K'], ['L']]]]]]]
]];

$count = $reduce(function ($acc, $elem) {
    return $acc + 1;
}, $tree, 0);

echo $count;
