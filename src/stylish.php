<?php

namespace GenDiff\Formater;

function formater(array $diffTree, $depth = 0): array
{
    $indent = str_repeat('    ', $depth);
    $result = array_map(function ($node) use ($indent, $depth) {
        switch ($node['type']) {
            case 'deleted':
                $value = $node['value'];
                $stringValue = toString($value, $depth + 1);
                return "{$indent}  - {$node['key']}: {$stringValue}"; // - строка

            case 'added':
                $value = $node['value'];
                $stringValue = toString($value, $depth + 1);
                return "{$indent}  + {$node['key']}: {$stringValue}"; // + строка

            case 'unchanged':
                $value = $node['value'];
                $stringValue = toString($value, $depth + 1);
                return "{$indent}    {$node['key']}: {$stringValue}"; //   строка

            case 'changed':
                $valueOld = $node['valueOld'];
                $stringValueOld = toString($valueOld, $depth + 1);
                $valueNew = $node['valueNew'];
                $stringValueNew = toString($valueNew, $depth + 1);               // -+ две строки
                return "{$indent}  - {$node['key']}: {$stringValueOld}" . PHP_EOL .
                       "{$indent}  + {$node['key']}: {$stringValueNew}";

            case 'nested':
                $stringNested = implode(PHP_EOL, formater($node['children'], $depth + 1));
                return "{$indent}    {$node['key']}:" . PHP_EOL . "{$stringNested}"; // nested - рекурсия

            default:
                throw new \Exception("Incorrect node type");
        }
    }, $diffTree);
    return $result;
}

function toString($value, $depth)
{
    $indent = '    ';

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (is_null($value)) {
        return 'null';
    }

    if (is_array($value)) {
        return arrayToString($value, $indent, $depth);
    }

    return "{$value}";
}

function arrayToString(array $arrayValue, $indent, $depth)
{
    $arrayKeysValue = array_keys($arrayValue);
    $result = array_map(function ($key) use ($arrayValue, $depth, $indent) {
        $depth += 1;
        $val = toString($arrayValue[$key], $depth);
        $resultIndent = str_repeat($indent, $depth);
        $resultString = PHP_EOL . "{$resultIndent}{$key}: {$val}";
        return $resultString;
    }, $arrayKeysValue);
    return implode($result);
}
