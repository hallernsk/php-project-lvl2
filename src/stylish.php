<?php

namespace GenDiff\Formater;

function formater(array $diffTree): array
{
    $result = array_map(function ($node) {
        if ($node['type'] === 'deleted') {
            return "  - {$node['key']}: {$node['value']}"; // - строка
        }
        if ($node['type'] === 'added') {
            return "  + {$node['key']}: {$node['value']}"; // + строка
        }
        if ($node['type'] === 'unchanged') {
            return "    {$node['key']}: {$node['value']}"; //   строка
        }
        if ($node['type'] === 'changed') {
            return "  - {$node['key']}: {$node['valueOld']} . EOL .  + {$node['key']}: {$node['valueNew']}";
        } else {
            return (formater($node['children'])); // nested - рекурсия
        }
    }, $diffTree);
    return $result;
}
