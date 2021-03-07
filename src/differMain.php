<?php

namespace GenDiff\DifferMain;

use function GenDiff\readFile\readFile;
use function GenDiff\Parsers\parse;
use function GenDiff\Diff\diff;
use function GenDiff\BuildDiffTree\buildDiffTree;
//use function GenDiff\Formatters\Plain\formaterPlain;
//use function GenDiff\Formatters\Stylish\formater;
use function GenDiff\Formatters\formater;

function differ($pathFile1, $pathFile2, $format)
{
//    print_r("format = {$format}");
    [$content1, $format1] = readFile($pathFile1);    // считываем контент и формат
    [$content2, $format2] = readFile($pathFile2);
//    print_r("contentFile1: \n" . $content1 . "\n");

    $data1 = parse($content1, $format1);    // парсим контент(в зав-ти от формата)
    $data2 = parse($content2, $format2);
//    var_dump($data2);

    $diffArray = buildDiffTree($data1, $data2);      // определяем диф
    $formaterString = formater($diffArray, $format);           // форматируем диф
//    var_dump($formaterArray);
//    $diffString = json_encode($diffArray);
//    print_r($diffString);
    // оформляем результат в соотв-ии с заданием (при этом массив - в строку)
//    $diffString = '{' . PHP_EOL . implode(PHP_EOL, $formaterArray) . PHP_EOL . '}' . PHP_EOL;
//    $diffString = implode(PHP_EOL, $formaterArray) . PHP_EOL;
    return $formaterString;
}
