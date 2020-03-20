<?php

/*  Bypass all array elements
    applying the passed handler function
    to each node of the tree
*/

function map(callable $func, array $tree)
{
    $map = function ($func, $node) use (&$map) {
        $children = $node['children'] ?? [];
        $updatedNode = $func($node);

        if (!$children) {
            return $updatedNode;
        }

        $updatedChildren = array_map(function ($node) use ($map, $func) {
            return $map($func, $node);
        }, $children);

        return array_merge($updatedNode, ['children' => $updatedChildren]);
    };

    return $map($func, $tree);
}
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
    'name' => '/',
    'type' => 'directory',
    'meta' => [],
    'children' => [
        [
            'name' => 'ETC',
            'type' => 'directory',
            'meta' => [],
            'children' => [
            [
                'name' => 'NGINX',
                'type' => 'directory',
                'meta' => [],
                'children' => [],
            ],
            [
                'name' => 'CONSUL',
                'type' => 'directory',
                'meta' => [],
                'children' => [['name' => 'CONFIG.JSON', 'type' => 'file', 'meta' => []]],
            ],
            ],
        ],
        ['name' => 'HOSTS', 'type' => 'file', 'meta' => []],
    ],
];

$result = map(function ($n) {
    return array_merge($n, ['name' => strtoupper($n['name'])]);
}, $tree);

print_r($result);
