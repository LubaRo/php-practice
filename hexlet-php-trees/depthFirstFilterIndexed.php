<?php

/*
    Find nodes in lower case only
*/
$filter = function (callable $func, array $tree) use (&$filter) {
    if (!$func($tree)) {
        return null;
    }

    [$name] = $tree;
    $children = $tree[1] ?? null;

    if (!$children) {
        return $tree;
    }
    $filteredChildren = array_map(function ($node) use ($func, $filter) {
        return $filter($func, $node);
    }, $children);

    $filteredChildrenWithoutNull = array_filter($filteredChildren, function ($node) {
        return $node !== null;
    });

    return [$name, array_values($filteredChildrenWithoutNull)];
};

$tree = ['a', [
    ['B', [['e'], ['F']]],
    ['C'],
    ['d', [['G'], ['j']]],
]];

//   a *
//    /|\
// B * C * d
//  /|   |\
// e  F  G j

$filtered = $filter(function ($tree) {
        [$name] = $tree;
        return $name === strtolower($name);
}, $tree);

echo json_encode($filtered);
// => '["a",[["d",[["j"]]]]]'
