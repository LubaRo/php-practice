<?php

require_once __DIR__ . "/secondaryFunc.php";
/*  Bypass all array elements
    applying the passed handler function
    to each node of the tree and also filter null elements
*/
function filter(callable $func, array $tree)
{
    $filter = function ($tree) use ($func, &$filter) {
        if (!$func($tree)) {
            return null;
        }
    
        $children = $tree['children'] ?? [];
    
        if (!$children) {
            return $tree;
        }
    
        $filteredChildren = array_map(function ($child) use ($filter) {
            return $filter($child);
        }, $children);

        $cleanChildren = array_filter($filteredChildren, function ($child) {
            return $child !== null;
        });

        return array_merge($tree, ['children' => array_values($cleanChildren)]);
    };

    return $filter($tree);
}

/* TREE:
           [root]
      /      |      \
    [etc]  f1.txt  [hosts]
    /   \           /   \
[nginx] [consul]   f2   f3
           |
           f4
*/

$tree = [
    'name' => 'root',
    'type' => 'directory',
    'meta' => [],
    'children' => [
        [
            'name' => 'etc',
            'type' => 'directory',
            'meta' => [],
            'children' => [
            [
                'name' => 'nginx',
                'type' => 'directory',
                'meta' => [],
                'children' => [],
            ],
            [
                'name' => 'consult',
                'type' => 'directory',
                'meta' => [],
                'children' => [['name' => 'f4', 'type' => 'file', 'meta' => []]],
            ],
            ],
        ],
        ['name' => 'f1.txt', 'type' => 'file', 'meta' => []],
        ['name' => 'hosts', 'type' => 'file', 'meta' => [], 'childred' => [
            ['name' => 'f2', 'type' => 'file', 'meta' => []],
            ['name' => 'f3', 'type' => 'file', 'meta' => []]
        ]],
    ],
];

$result = filter(function ($node) {
    return isDirectory($node);
}, $tree);

print_r($result);
