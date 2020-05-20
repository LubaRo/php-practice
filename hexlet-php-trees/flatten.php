<?php

$reduce = function (callable $func, array $tree, $acc) use (&$reduce) {
    $updatedAcc = $func($acc, $tree);
    $children = is_array($tree);

    if (!$children) {
        return $updatedAcc;
    }

    return array_reduce($children, function ($acc, $item) use ($func, $reduce) {
        return $reduce($func, $item, $acc);
    }, $updatedAcc);
};



$list = [1, 2, [3, 5], [[4, 3], 2]];

$count = $reduce(function ($acc, $elem) {
    return $acc + 1;
}, $list, 0);

print_r($count); // [1, 2, 3, 5, 4, 3, 2]
