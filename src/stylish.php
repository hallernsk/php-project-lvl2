<?php

namespace GenDiff\Formater;

const BASE_INDENT = '    ';

function formater(array $diffTree, int $depth = 0): array
{
    $indent = getIndent($depth);
    $result = array_map(function ($node) use ($indent, $depth) {
        $newDepth = $depth + 1;
        switch ($node['type']) {
            case 'deleted':
                $value = $node['value'];
                $stringValue = toString($value, $newDepth);
                return "{$indent}  - {$node['key']}: {$stringValue}"; // - строка

            case 'added':
                $value = $node['value'];
                $stringValue = toString($value, $newDepth);
                return "{$indent}  + {$node['key']}: {$stringValue}"; // + строка

            case 'unchanged':
                $value = $node['value'];
                $stringValue = toString($value, $newDepth);
                return "{$indent}    {$node['key']}: {$stringValue}"; //   строка

            case 'changed':
                $valueOld = $node['valueOld'];
                $stringValueOld = toString($valueOld, $newDepth);
                $valueNew = $node['valueNew'];
                $stringValueNew = toString($valueNew, $newDepth);               // -+ две строки
                return "{$indent}  - {$node['key']}: {$stringValueOld}" . PHP_EOL .
                       "{$indent}  + {$node['key']}: {$stringValueNew}";

            case 'nested':
                $stringNested = implode(PHP_EOL, formater($node['children'], $newDepth));
                return "{$indent}    {$node['key']}: {" . PHP_EOL .
                     "{$stringNested}" . PHP_EOL . "{$indent}    }"; // nested - рекурсия

            default:
                throw new \Exception("Incorrect node type");
        }
    }, $diffTree);
    return $result;
}

function toString($value, int $depth): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (is_null($value)) {
        return 'null';
    }

    if (is_array($value)) {
        $result = arrayToString($value, $depth);
        $indent = getIndent($depth);
        $bracketsResult = "{{$result}" . PHP_EOL . "{$indent}}";
        return $bracketsResult;
    }

    return "{$value}";
}

function arrayToString(array $arrayValue, int $depth): string
{
    $arrayKeysValue = array_keys($arrayValue);
    $inDepth = $depth + 1;
    $result = array_map(function ($key) use ($arrayValue, $inDepth) {
        $val = toString($arrayValue[$key], $inDepth);
        $currentIndent = getIndent($inDepth);
        $resultString = PHP_EOL . "{$currentIndent}{$key}: {$val}";
        return $resultString;
    }, $arrayKeysValue);
    return implode('', $result);
}

function getIndent(int $multiplier): string
{
    return str_repeat(BASE_INDENT, $multiplier);
}
