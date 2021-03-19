<?php

namespace GenDiff\DifferMain;

use function GenDiff\readFile\readFile;
use function GenDiff\Parsers\parse;
use function GenDiff\BuildDiffTree\buildDiffTree;
use function GenDiff\Formatters\format;

function differ($pathFile1, $pathFile2, $format)
{
    [$content1, $format1] = readFile($pathFile1);    // считываем контент и формат
    [$content2, $format2] = readFile($pathFile2);

    $data1 = parse($content1, $format1);    // парсим контент(в зав-ти от формата)
    $data2 = parse($content2, $format2);

    $diffArray = buildDiffTree($data1, $data2);      // определяем диф
    $formaterString = format($diffArray, $format);           // форматируем диф
    return $formaterString;
}
