<?php

namespace GenDiff\Formatters;

use GenDiff\Formatters\Plain\formaterPlain;
use GenDiff\Formatters\Stylish\formaterStylish;
use GenDiff\Formatters\Json\formaterJson;

function format(array $data, string $format): string
{
    switch ($format) {
        case 'stylish':
            return Stylish\format($data);

        case 'plain':
            return Plain\format($data);

        case 'json':
            return Json\format($data);

        default:
            throw new \Exception("Incorrect format $format");
    }
}
