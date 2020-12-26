<?php

namespace GenDiff\Parsers;

use Symfony\Component\Yaml\Yaml;

use function GenDiff\ReadData\readData;

function parse($pathFile)
{
    $data = readData($pathFile);
    $format = pathinfo($pathFile, PATHINFO_EXTENSION);
    if ($format === 'json') {
        $result = json_decode($data, true);
    } elseif ($format === 'yml') {
        $result = Yaml::parse($data);
    } else {
        throw new \Exception("Incorrect format: $pathFile");
    }
    return $result;
}
