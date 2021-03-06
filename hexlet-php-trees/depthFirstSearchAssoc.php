<?php

/*
  Depth first search [обход дерева в глубину]
*/

$dfs = function($tree) use (&$dfs) {
    ['name' => $name, 'children' => $children] = $tree;

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
            ['name' => 'C', 'children' => []],
            ['name' => 'D', 'children' => []]
        ]],
        ['name' => 'E', 'children' => []],
        ['name' => 'F', 'children' => [
            ['name' => 'G', 'children' => []],
            ['name' => 'H', 'children' => [
                ['name' => 'I', 'children' => []],
                ['name' => 'J', 'children' => [
                    ['name' => 'K', 'children' => []],
                    ['name' => 'L', 'children' => []]
                ]]
            ]]
        ]]
    ]
];

$dfs($tree);
