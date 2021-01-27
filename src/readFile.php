<?php

namespace GenDiff\ReadFile;

function readFile($pathFile)
{
    // проверка существования файла:
    if (!file_exists($pathFile)) {
        throw new \Exception("Incorrect path to file: $pathFile");
    }
    $content = readFileContent($pathFile);
    $format = getFileFormat($pathFile);
    return [$content, $format];
}

function readFileContent($pathFile)
{
    $content = file_get_contents($pathFile);   // считываем содержимое
    return $content;
}

function getFileFormat($pathFile)
{
    $format = pathinfo($pathFile, PATHINFO_EXTENSION);// определяем формат
    return $format;
}
