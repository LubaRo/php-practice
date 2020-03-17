<?php

function isFile($node)
{
  $type = $node['type'] ?? null;
  return $type == 'file';
}

function downcaseFileNames($tree)
{
    $downcaseFileNames = function ($node) use (&$downcaseFileNames) {
        if (isFile($node)) {
            $name = $node['name'] ?? '';
            return array_merge($node, ['name' => strtolower($name)]);
        }
        $children = $node['children'] ?? [];
        $updatedChildren = array_map($downcaseFileNames, $children);

        return array_merge($node, ['children' => $updatedChildren]);
    };

    return $downcaseFileNames($tree);
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
