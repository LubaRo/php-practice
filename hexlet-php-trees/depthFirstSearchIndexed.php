<?php

/*
  Depth first search [обход дерева в глубину]
*/

$dfs = function ($tree) use (&$dfs) {
  $name = $tree[0];
  echo "Node name is $name \n";

  if (isset($tree[1])) {
    echo "node has child\n\n";
    array_map($dfs, $tree[1]);
  }
};

$tree = ['A', [
  ['B', [['C'], ['D']]],
  ['E'],
  ['F', [['G'], ['H', [['I'], ['J', [['K'], ['L']]]]]]]
]];

$dfs($tree);
