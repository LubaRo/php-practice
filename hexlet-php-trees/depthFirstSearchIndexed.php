<?php

/*
  Depth first search [обход дерева в глубину]
*/

$dfs = function ($tree) use (&$dfs) {
  $name = $tree[0];
  $children = $tree[1] ?? null;

  echo "Node name is $name \n";

  if ($children) {
    echo "node has children\n\n";
    array_map($dfs, $children);
  }
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

$dfs($tree);
