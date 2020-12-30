<?php

namespace GenDiff\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse($data, $format)
{
    if ($format === 'json') {
        $result = json_decode($data, true);
    } elseif ($format === 'yml') {
        $result = Yaml::parse($data);
    } else {
        throw new \Exception("Incorrect file format: $pathFile");
    }
    return $result;
}
