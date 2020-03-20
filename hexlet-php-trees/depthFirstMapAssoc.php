<?php

/*  Bypass all array elements
    applying the passed handler function
    to each node of the tree
*/

function map(callable $func, array $tree)
{
    $map = function ($node) use (&$map, $func) {
        $children = $node['children'] ?? [];
        $updatedNode = $func($node);

        if (!$children) {
            return $updatedNode;
        }

        $updatedChildren = array_map($map, $children);

        return array_merge($updatedNode, ['children' => $updatedChildren]);
    };

    return $map($tree);
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
    'meta' => [
        'old' => 'root meta'
    ],
    'children' => [
        [
            'name' => 'etc',
            'type' => 'directory',
            'meta' => [],
            'children' => [
            [
                'name' => 'nGinX',
                'type' => 'directory',
                'meta' => [
                    'old' => 'nginx meta'
                ],
                'children' => [],
            ],
            [
                'name' => 'conSUL',
                'type' => 'directory',
                'meta' => [],
                'children' => [['name' => 'CONFIG.JSON', 'type' => 'file', 'meta' => []]],
            ],
            ],
        ],
        ['name' => 'HOsts', 'type' => 'file', 'meta' => []],
    ],
];

$result = map(function ($n) {
    return array_merge($n, ['name' => strtoupper($n['name'])]);
}, $tree);

print_r($result);
