<?php

namespace Differ\Formatters\Plain;

function format(array $data): string
{
    $lines = formatToPlain($data);
    return implode(PHP_EOL, $lines) . PHP_EOL;
}

function formatToPlain(array $diffTree, string $path = ''): array
{
    $result = array_map(function ($node) use ($path) {
        switch ($node['type']) {
            case 'deleted':
                $property = "{$path}{$node['key']}";
                return "Property '{$property}' was removed";

            case 'added':
                $formattedValue = toString($node['value']);
                $property = "{$path}{$node['key']}";
                return "Property '{$property}' was added with value: {$formattedValue}";

            case 'unchanged':
                return '';

            case 'changed':
                $formattedValueOld = toString($node['valueOld']);
                $formattedValueNew = toString($node['valueNew']);
                $property = "{$path}{$node['key']}";
                return "Property '{$property}' was updated. From {$formattedValueOld} to {$formattedValueNew}";

            case 'nested':
                $pathAdd = "{$path}{$node['key']}.";
                $stringNested = implode(PHP_EOL, formatToPlain($node['children'], $pathAdd));
                return $stringNested;
            default:
                throw new \Exception("Incorrect node type");
        }
    }, $diffTree);

    return array_filter($result);
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
