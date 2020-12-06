<?php

namespace GenDiff\DifferFiles;

use function GenDiff\ReadData\readData;

function differ($pathFile1, $pathFile2)
{
    $data1 = readData($pathFile1);  // получаем ассоц. массив1 из файла1
    $data2 = readData($pathFile2);  // получаем ассоц. массив2 из файла2

// сортируем массивы:
    ksort($data1);
    foreach ($data1 as $key => $value) {   // преобразуем значения логическое  true/false
        if (is_bool($value)) {             // в строковое "true"/"false"
            $data1[$key] = (boolval($data1[$key])) ? 'true' : 'false';
        }
    }
    ksort($data2);
    foreach ($data2 as $key => $value) {
        if (is_bool($value)) {
            $data2[$key] = (boolval($data2[$key])) ? 'true' : 'false';
        }
    }

// новый алгоритм: сначала мержим массивы в один:
    $unitedArray = array_merge($data1, $data2);
    ksort($unitedArray);

    $resultArray = []; // итоговый массив

    foreach ($unitedArray as $key => $val) {          // формируем итоговый массив из объединенного(проходя его в цикле)
        if (array_key_exists($key, $data1)) {         // ключ есть в М1
            if (array_key_exists($key, $data2)) {     // ключ есть и в М2
                if ($data1[$key] === $data2[$key]) {  // значения по этому ключу одинаковы в М1 и М2
                    $resultArray[] = "   {$key}: {$val}" . PHP_EOL; // строка без знака
                } else {                                            // значения не равны
                    $resultArray[] = " - {$key}: {$data1[$key]}" . PHP_EOL; // - строка
                    $resultArray[] = " + {$key}: {$val}" . PHP_EOL;         // + строка
                }
            } else {                                               // ключа нет в М2
                $resultArray[] = " - {$key}: {$val}" . PHP_EOL;    // - строка
            }
        } else {                                              // ключа нет в М1
            $resultArray[] = " + {$key}: {$val}" . PHP_EOL;   // + строка
        }
    }
// оформляем результат в соотв-ии с заданием (при этом массив - в строку)
    $resultString = '{' . PHP_EOL . implode($resultArray) . '}' . PHP_EOL;
    return $resultString;
}
