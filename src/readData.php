<?php

namespace GenDiff\ReadData;

function readData($pathFile)
{
    // проверка существования файла:
    if (!file_exists($pathFile)) {
        throw new \Exception("Incorrect path to file: $pathFile");
    }
    $content = file_get_contents($pathFile);   // считываем содержимое
    return $content;
}
