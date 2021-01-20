<?php

namespace GenDiff\BuildDiffTree;

function buildDiffTree(array $data1, array $data2): array
{
    // сортируем входные массивы:
    ksort($data1);
    foreach ($data1 as $key => $value) {   // преобразуем логическое true/false
        if (is_bool($value)) {             // в строковое "true"/"false"
            $data1[$key] = (bool)$data1[$key] ? 'true' : 'false';
        }
    }
    ksort($data2);
    foreach ($data2 as $key => $value) {
        if (is_bool($value)) {
            $data2[$key] = (bool)$data2[$key] ? 'true' : 'false';
        }
    }

    // из массивов данных создаем массивы ключей:
    $keysData1 = array_keys($data1);
    $keysData2 = array_keys($data2);
    $unitedArrayKeys = array_merge($keysData1, $keysData2); //объединенный массив ключей
    $unitedArrayUniqKeys = array_unique($unitedArrayKeys);  // убираем дублирование
    sort($unitedArrayUniqKeys);                           // сортируем массив ключей

//    var_dump($unitedArrayUniqKeys);

    $diffTree = array_map(function ($key) use ($data1, $data2) {
        if (!array_key_exists($key, $data2)) {            // ключ есть только в М1
            return ['key' => $key, 'type' => 'deleted', 'value' => $data1[$key]];
        }
        if (!array_key_exists($key, $data1)) {            // ключ есть только в М1
            return ['key' => $key, 'type' => 'added', 'value' => $data2[$key]];
        }

        if ($data1[$key] === $data2[$key]) {            // значения равны
            return ['key' => $key, 'type' => 'unchanged', 'value' => $data1[$key]];
        }

        if (is_array($data1[$key]) && is_array($data2[$key])) {
            return ['key' => $key, 'type' => 'nested',
                'children' => buildDiffTree($data1[$key], $data2[$key])];
        } else {
            return ['key' => $key, 'type' => 'changed', 'value1' => $data1[$key], 'value2' => $data2[$key]];
        }
    }, $unitedArrayUniqKeys);
    return $diffTree;
}
