<?php

/*
  Depth first search [обход дерева в глубину]
*/

$dfs = function($tree) use (&$dfs) {
    $name = $tree['name'];
    $childs = $tree['childs'] ?? null;

    echo "Node name is $name\n";

    if ($childs) {
        echo "Node has childs\n\n";
        array_map($dfs, $childs);
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

$tree = [
    'name' => 'A',
    'childs' => [
        ['name' => 'B', 'childs' => [
            ['name' => 'C'],
            ['name' => 'D']
        ]],
        ['name' => 'E'],
        ['name' => 'F', 'childs' => [
            ['name' => 'G'],
            ['name' => 'H', 'childs' => [
                ['name' => 'I'],
                ['name' => 'J', 'childs' => [
                    ['name' => 'K'],
                    ['name' => 'L']
                ]]
            ]]
        ]]
    ]
];

$dfs($tree);
