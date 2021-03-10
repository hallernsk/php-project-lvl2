<?php

namespace GenDiff\Diff;

function diff($data1, $data2)
{
    // сортируем входные массивы:
    ksort($data1);
    ksort($data2);

    // из массивов данных создаем массивы ключей:
    $keysData1 = array_keys($data1);
    $keysData2 = array_keys($data2);
    $unitedArrayKeys = array_merge($keysData1, $keysData2); //объединенный массив ключей
    $unitedArrayUniqKeys = array_unique($unitedArrayKeys);  // убираем дублирование
    sort($unitedArrayUniqKeys);                           // сортируем массив ключей

    $resultArray = []; // итоговый массив
    // формируем итоговый массив из объединенного(массива ключей):
    foreach ($unitedArrayUniqKeys as $key) {
        if (!array_key_exists($key, $data2)) {            // ключ есть только в М1
            $resultArray[] = "  - {$key}: {$data1[$key]}"; // - строка
            continue;
        }

        if (!array_key_exists($key, $data1)) {         // ключ есть только в М2
            $resultArray[] = "  + {$key}: {$data2[$key]}"; // + строка
            continue;
        }

        if ($data1[$key] === $data2[$key]) {  // значения по ключу равны в М1 и М2
            $resultArray[] = "    {$key}: {$data1[$key]}"; // строка без знака
            continue;
        }
        // значения по ключу не равны:
        $resultArray[] = "  - {$key}: {$data1[$key]}";         // - строка
        $resultArray[] = "  + {$key}: {$data2[$key]}";         // + строка
    }
    return $resultArray;
}
