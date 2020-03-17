<?php

/*
  Depth first search [обход дерева в глубину]
*/

$dfs = function($tree) use (&$dfs) {
    $name = $tree['name'];
    $children = $tree['children'] ?? null;

    echo "Node name is $name\n";

    if ($children) {
        echo "Node has children\n\n";
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

$tree = [
    'name' => 'A',
    'children' => [
        ['name' => 'B', 'children' => [
            ['name' => 'C'],
            ['name' => 'D']
        ]],
        ['name' => 'E'],
        ['name' => 'F', 'children' => [
            ['name' => 'G'],
            ['name' => 'H', 'children' => [
                ['name' => 'I'],
                ['name' => 'J', 'children' => [
                    ['name' => 'K'],
                    ['name' => 'L']
                ]]
            ]]
        ]]
    ]
];

$dfs($tree);
