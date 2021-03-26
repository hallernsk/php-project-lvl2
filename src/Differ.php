<?php

namespace GenDiff\Differ;

use function GenDiff\FileReader\readFile;
use function GenDiff\Parsers\parse;
use function GenDiff\BuildDiffTree\buildDiffTree;
use function GenDiff\Formatters\format;

function differ(string $filePath1, string $filePath2, string $format): string
{
    [$content1, $format1] = readFile($filePath1);
    [$content2, $format2] = readFile($filePath2);
    $data1 = parse($content1, $format1);
    $data2 = parse($content2, $format2);

    $diffArray = buildDiffTree($data1, $data2);
    return format($diffArray, $format);
}
