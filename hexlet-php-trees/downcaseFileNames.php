<?php

function isFile($node)
{
  $type = $node['type'] ?? null;
  return $type == 'file';
}

function downcaseFileNames($tree)
{
    $dfs = function ($tree) use (&$dfs) {
        if (isFile($tree)) {
            $name = $tree['name'] ?? '';
            $tree['name'] = strtolower($name);
            return $tree;
        }
        $children = $tree['children'] ?? [];
        $tree['children'] = array_map($dfs, $children);

        return $tree;
    };

    return $dfs($tree);
}



/* TREE:
              A
       /      |      \
      B     EfIlE    F
   /    \          /    \
cfiLE  dfiLe    GFIle  H
*/

$tree = [
    'name' => 'A',
    'type' => 'dir',
    'children' => [
        ['name' => 'B', 'type' => 'dir', 'children' => [
            ['name' => 'cfiLE', 'type' => 'file'],
            ['name' => 'dfiLe', 'type' => 'file']
        ]],
        ['name' => 'EfIlE', 'type' => 'file'],
        ['name' => 'F', 'type' => 'dir', 'children' => [
            ['name' => 'GFIle', 'type' => 'file'],
            ['name' => 'H', 'type' => 'dir']
        ]]
    ]
];

$result = downcaseFileNames($tree);
print_r($result);
