<?php

/*
  Depth first search [обход дерева в глубину]
*/

$dfs = function ($tree) use (&$dfs) {
  $name = $tree[0];
  $childs = $tree[1] ?? null;

  echo "Node name is $name \n";

  if ($childs) {
    echo "node has childs\n\n";
    array_map($dfs, $childs);
  }
};

$tree = ['A', [
  ['B', [['C'], ['D']]],
  ['E'],
  ['F', [['G'], ['H', [['I'], ['J', [['K'], ['L']]]]]]]
]];

$dfs($tree);
