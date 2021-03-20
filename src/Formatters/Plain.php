<?php

namespace GenDiff\Formatters\Plain;

function format(array $diffTree, string $path = ''): array
{
    $result = array_map(function ($node) use ($path) {
        switch ($node['type']) {
            case 'deleted':
                $str = "{$path}{$node['key']}";
                return "Property '{$str}' was removed";

            case 'added':
                $stringValue = toString($node['value']);
                $str = "{$path}{$node['key']}";
                return "Property '{$str}' was added with value: {$stringValue}";

            case 'unchanged':
                return '';

            case 'changed':
                $stringValueOld = toString($node['valueOld']);
                $stringValueNew = toString($node['valueNew']);
                $str = "{$path}{$node['key']}";
                return "Property '{$str}' was updated. From {$stringValueOld} to {$stringValueNew}";

            case 'nested':
                $pathAdd = "{$path}{$node['key']}.";
                $stringNested = implode(PHP_EOL, format($node['children'], $pathAdd));
                return $stringNested;
            default:
                throw new \Exception("Incorrect node type");
        }
    }, $diffTree);

    $newResult = array_filter($result);
//    print_r($newResult);
    return $newResult;
}

function toString($value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (is_null($value)) {
        return 'null';
    }

    if (is_array($value)) {
        return '[complex value]';
    }

    return "'{$value}'";
}
