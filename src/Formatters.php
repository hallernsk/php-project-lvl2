<?php

namespace GenDiff\Formatters;

use GenDiff\Formatters\Plain\formaterPlain;
use GenDiff\Formatters\Stylish\formaterStylish;
use GenDiff\Formatters\Json\formaterJson;

function format(array $data, string $format): string
{
    switch ($format) {
        case 'stylish':
            $formaterArray = Stylish\format($data);
            $formaterString = '{' . PHP_EOL . implode(PHP_EOL, $formaterArray) . PHP_EOL . '}' . PHP_EOL;
            return $formaterString;

        case 'plain':
            $formaterArray = Plain\format($data);
            $formaterString = implode(PHP_EOL, $formaterArray) . PHP_EOL;
            return $formaterString;

        case 'json':
            $formaterString = Json\format($data);
            return $formaterString;

        default:
            throw new \Exception("Incorrect format");
    }
}
