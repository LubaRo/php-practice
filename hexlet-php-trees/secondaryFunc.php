<?php

function isDirectory($node)
{
    $type = $node['type'] ?? 'undefinded';
    return $type === 'directory';
}

function isFile($node)
{
    $type = $node['type'] ?? 'undefinded';
    return $type === 'file';
}
