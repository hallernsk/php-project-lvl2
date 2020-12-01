<?php

namespace GenDiff\DifferFiles;

function differ($pathFile1, $pathFile2)
{
set_include_path(getcwd());
//echo getcwd() . "\n"; // проверка рабочей директории, вывод: /home/vova/php-project-lvl2

$fileJson1 = file_get_contents($pathFile1, FILE_USE_INCLUDE_PATH); // считываем содержимое
$fileJson2 = file_get_contents($pathFile2, FILE_USE_INCLUDE_PATH); // файлов по-другому

$data1 = json_decode($fileJson1, true);  // декодируем из json1 в ассоц. массив1 (true)
$data2 = json_decode($fileJson2, true);  // декодируем из json2 в ассоц. массив2 (true)

// теперь надо сравнивать два массива: $data1 и $data2
ksort($data1);    // сортируем массив 1
foreach ($data1 as $key => $value) {   // преобразуем значения логическое  true/false                        
    if (is_bool($value)) {             // в строковое "true"/"false"
        $data1[$key] = ($data1[$key] == 'true') ? 'true' : 'false';
    }
}

ksort($data2);
foreach ($data2 as $key => $value) {
    if (is_bool($value)) {
        $data2[$key] = ($data2[$key] == 'true') ? 'true' : 'false';
    }
}

$resultArray = []; // итоговый массив

foreach ($data1 as $key1 => $val1) {    // формируем итоговый массив (этап 1 - из массива 1)
    if (array_key_exists($key1, $data2)) {
        if ($data1[$key1] === $data2[$key1]) {
                $resultArray[] = "   {$key1}: {$val1}" . PHP_EOL;     
            } else {
                $resultArray[] = " - {$key1}: {$val1}" . PHP_EOL;
                $resultArray[] = " + {$key1}: {$data2[$key1]}" . PHP_EOL;
            }
    } else {
            $resultArray[] = " - {$key1}: {$val1}" . PHP_EOL;
        }
}

foreach ($data2 as $key2 => $val2) {  //    ... этап 2 - "неохваченные" элементы массива 2
    if (!array_key_exists($key2, $data1)) {
        $resultArray[] = " + {$key2}: {$val2}" . PHP_EOL;   
    }
}
// оформляем результат в соотв-ии с заданием (при этом массив - в строку)
$resultString = '{' . PHP_EOL . implode($resultArray) . '}' . PHP_EOL; 
return $resultString;
} 
