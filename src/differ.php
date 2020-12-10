<?php

namespace GenDiff\DifferFiles;

use function GenDiff\ReadData\readData;

function differ($pathFile1, $pathFile2)
{
    $data1 = readData($pathFile1);  // получаем ассоц. массив1 из файла1
    $data2 = readData($pathFile2);  // получаем ассоц. массив2 из файла2

    // сортируем массивы:
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

    // новый алгоритм: сначала мержим массивы в один:
    $unitedArray = array_merge($data1, $data2);
    $unitedArrayKeys = array_keys($unitedArray); // массив ключей из $unitedArray
    sort($unitedArrayKeys);

    $resultArray = []; // итоговый массив
    // формируем итоговый массив из объединенного(массива ключей):
    foreach ($unitedArrayKeys as $key) {
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
    // оформляем результат в соотв-ии с заданием (при этом массив - в строку)
    $resultString = '{' . PHP_EOL . implode(PHP_EOL, $resultArray) . PHP_EOL . '}' . PHP_EOL;
    return $resultString;
}
