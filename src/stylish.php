<?php

namespace GenDiff\Formater;

function formater(array $diffTree): array
{
    $result = array_map(function ($node) {
        switch ($node['type']) {
            case 'deleted':
                $value = $node['value'];
                $stringValue = toString($value);
                return "  - {$node['key']}: {$stringValue}"; // - строка

            case 'added':
                $value = $node['value'];
                $stringValue = toString($value);
                return "  + {$node['key']}: {$stringValue}"; // + строка

            case 'unchanged':
                $value = $node['value'];
                $stringValue = toString($value);
                return "    {$node['key']}: {$stringValue}"; //   строка

            case 'changed':
                $valueOld = $node['valueOld'];
                $stringValueOld = toString($valueOld);
                $valueNew = $node['valueNew'];
                $stringValueNew = toString($valueNew);               // -+ две строки
                return "  - {$node['key']}: {$stringValueOld} " . PHP_EOL . "  + {$node['key']}: {$stringValueNew}";

            case 'nested':
                $stringNested = implode(PHP_EOL, formater($node['children']));
                return "    {$node['key']}:" . PHP_EOL . "{$stringNested}"; // nested - рекурсия

            default:
                throw new \Exception("Incorrect node type");
        }
    }, $diffTree);
    return $result;
}

function toString($value)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (is_null($value)) {
        return 'null';
    }


    if (is_array($value)) {
        $stringArray = implode(PHP_EOL, $value);
        return $stringArray;
    }
    return $value;
}
