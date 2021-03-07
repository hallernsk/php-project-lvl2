<?php

namespace GenDiff\Formatters;

use GenDiff\Formatters\Plain\formaterPlain;
use GenDiff\Formatters\Stylish\formaterStylish;

function formater(array $data, string $format): string
{
    switch ($format) {
        case 'stylish':
            $formaterArray = Stylish\formaterStylish($data);
            $formaterString = '{' . PHP_EOL . implode(PHP_EOL, $formaterArray) . PHP_EOL . '}' . PHP_EOL;
            return $formaterString;

        case 'plain':
            $formaterArray = Plain\formaterPlain($data);
            $formaterString = implode(PHP_EOL, $formaterArray) . PHP_EOL;
            return $formaterString;

        default:
            throw new \Exception("Incorrect format");
    }
}
