<?php

namespace GenDiff\DifferMain;

use function GenDiff\readFileContent\readFileContent;
use function GenDiff\getFileFormat\getFileFormat;
use function GenDiff\Parsers\parse;
use function GenDiff\Diff\diff;

function differ($pathFile1, $pathFile2)
{
    $content1 = readFileContent($pathFile1);    // считываем контент
    $format1 = getFileFormat($pathFile1);       // определяем формат
    $content2 = readFileContent($pathFile2);
    $format2 = getFileFormat($pathFile2);

    $data1 = parse($content1, $format1);    // парсим контент(в зав-ти от формата)
    $data2 = parse($content2, $format2);

    $diffArray = diff($data1, $data2);      // определяем диф

    // оформляем результат в соотв-ии с заданием (при этом массив - в строку)
    $diffString = '{' . PHP_EOL . implode(PHP_EOL, $diffArray) . PHP_EOL . '}' . PHP_EOL;
    return $diffString;
}
