<?php

namespace Differ\FileReader;

function readFile(string $filePath): array
{
    // проверка существования файла:
    if (!file_exists($filePath)) {
        throw new \Exception("Incorrect path to file: $filePath");
    }
    $content = readFileContent($filePath);
    $format = getFileFormat($filePath);
    return [$content, $format];
}

function readFileContent(string $filePath): string
{
    return file_get_contents($filePath);
}

function getFileFormat(string $filePath): string
{
    return pathinfo($filePath, PATHINFO_EXTENSION);
}
