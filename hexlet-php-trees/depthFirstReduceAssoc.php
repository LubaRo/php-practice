<?php

require_once __DIR__ . "/secondaryFunc.php";

/* Count directories in the tree */

function reduce(callable $func, array $tree, $acc)
{
    $reduce  = function ($acc, $tree) use ($func, &$reduce) {
        $updatedAcc = $func($acc, $tree);
        $children = $tree['children'] ?? [];
    
        if (!$children) {
            return $updatedAcc;
        }

        return array_reduce($children, function ($childAcc, $node) use ($reduce) {
            return $reduce($childAcc, $node);
        }, $updatedAcc);
    };

    return $reduce(0, $tree);
}

/* TREE:
            [root]
      /       |       \
    [etc]   f1.txt  [hosts]
    /   \           /   |   \
[nginx] [consul]  [d1] [d2] f1
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
        ['name' => 'hosts', 'type' => 'directory', 'meta' => [], 'children' => [
            ['name' => 'd1', 'type' => 'directory', 'meta' => []],
            ['name' => 'd2', 'type' => 'directory', 'meta' => []],
            ['name' => 'f1', 'type' => 'file', 'meta' => []]
        ]],
    ],
];

$countDir = reduce(function ($acc, $node) {
    return isDirectory($node) ? $acc + 1 : $acc;
}, $tree, 0);

echo $countDir;
