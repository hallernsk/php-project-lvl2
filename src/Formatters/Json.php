<?php

namespace GenDiff\Formatters\Json;

function format(array $diffTree): string
{
    return json_encode($diffTree);
}
