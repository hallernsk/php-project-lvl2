<?php

namespace GenDiff\ReadData;

function readData($pathFile)
{
    // проверка существования файла:
    if (!file_exists($pathFile)) {
        throw new \Exception("Incorrect path to file: $pathFile");
    }
    $fileJson = file_get_contents($pathFile);   // считываем содержимое
    $dataArray = json_decode($fileJson, true);  // декодируем из json1 в ассоц. массив1 (true)
    return $dataArray;
}
