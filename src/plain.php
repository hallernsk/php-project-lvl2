<?php

namespace GenDiff\FormaterPlain;

function formaterPlain(array $diffTree, string $ancestry = ''): array
{
//    $ancerty = '';
    $result = array_map(function ($node) use ($ancestry) {
        switch ($node['type']) {
            case 'deleted':                         // was removed
                $str = "{$ancestry}.{$node['key']}";
                $newStr = substr($str, 1);
                return "Property '{$newStr}' was removed";

            case 'added':                           // was added
                $value = $node['value'];
                $stringValue = toString($value);
                $str = "{$ancestry}.{$node['key']}";
                $newStr = substr($str, 1);
                return "Property '{$newStr}' was added with value: {$stringValue}";

            case 'unchanged':                       //   ""
                return '';

            case 'changed':                         // was updated
                $valueOld = $node['valueOld'];
                $stringValueOld = toString($valueOld);
                $valueNew = $node['valueNew'];
                $stringValueNew = toString($valueNew);
                $str = "{$ancestry}.{$node['key']}";
                $newStr = substr($str, 1);
                return "Property '{$newStr}' was updated. From {$stringValueOld} to {$stringValueNew}";

            case 'nested':                          // nested - рекурсия
                $ancertyAdd = "{$ancestry}.{$node['key']}";
                $stringNested = implode(PHP_EOL, formaterPlain($node['children'], $ancertyAdd));
                return $stringNested;
            default:
                throw new \Exception("Incorrect node type");
        }
    }, $diffTree);

    $newResult = array_diff($result, array(''));
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
