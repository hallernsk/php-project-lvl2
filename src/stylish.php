<?php

namespace GenDiff\Formater;

function formater(array $diffTree): array
{
    $result = array_map(function ($node) {
        switch ($node['type']) {
            case 'deleted':
                return "  - {$node['key']}: {$node['value']}"; // - строка

            case 'added':
                return "  + {$node['key']}: {$node['value']}"; // + строка

            case 'unchanged':
                return "    {$node['key']}: {$node['value']}"; //   строка

            case 'changed':                                // -+ две строки
                return "  - {$node['key']}: {$node['valueOld']} " . PHP_EOL . "  + {$node['key']}: {$node['valueNew']}";

            case 'nested':
                $stringNested = implode(PHP_EOL, formater($node['children']));
                return "    {$node['key']}:" . PHP_EOL . "{$stringNested}"; // nested - рекурсия

            default:
                throw new \Exception("Incorrect node type");
        }
    }, $diffTree);
    return $result;
}
