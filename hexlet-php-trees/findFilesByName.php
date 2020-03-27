<?php

require_once __DIR__ . "/secondaryFunc.php";

/* Find empty directories */

function findFilesByName($tree, $substring)
{
    $findFilesByName = function ($node, $filePath, $acc) use (&$findFilesByName, $substring) {
        $name = $node['name'] ?? '';
        if (isFile($node)) {
            if (strpos($name, $substring) !== false) {
                $acc[] = $filePath . $name;
            }
            return $acc;
        }

        $delimetr = $name == '/' ? '' : '/';
        $filePath .= "$name" . $delimetr;

        $children = $node['children'] ?? [];
        if (empty($children)) {
            return $acc;
        }

        return array_reduce($children, function ($childrendAcc, $child) use ($findFilesByName, $filePath) {
            return $findFilesByName($child, $filePath, $childrendAcc);
        }, $acc);
    };

    return $findFilesByName($tree, '', []);
}
/* TREE:
             [/]
      /       |       \
    [etc]   fl1.txt  [hosts]
    /   \           /   |   \
[nginx] [consul]  [d1] [d2] fl2
          / \
        fl3  [dir]
*/

$tree = [
    'name' => '/',
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
                'name' => 'consul',
                'type' => 'directory',
                'meta' => [],
                'children' => [
                    ['name' => 'f3', 'type' => 'file', 'meta' => []],
                    ['name' => 'dir', 'type' => 'directory', 'meta' => []]
                ],
            ],
            ],
        ],
        ['name' => 'fl1.txt', 'type' => 'file', 'meta' => []],
        ['name' => 'hosts', 'type' => 'directory', 'meta' => [], 'children' => [
            ['name' => 'd1', 'type' => 'directory', 'meta' => []],
            ['name' => 'd2', 'type' => 'directory', 'meta' => []],
            ['name' => 'fl2', 'type' => 'file', 'meta' => []]
        ]],
    ],
];

$foundFiles = findFilesByName($tree, 'fl');

print_r($foundFiles);
