<?php

namespace GenDiff\GetFileFormat;

function getFileFormat($pathFile)
{
    // проверка существования файла:
    if (!file_exists($pathFile)) {
        throw new \Exception("Incorrect path to file: $pathFile");
    }
    $format = pathinfo($pathFile, PATHINFO_EXTENSION);// определяем формат
    return $format;
}
