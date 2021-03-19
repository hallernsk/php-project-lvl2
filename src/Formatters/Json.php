<?php

namespace GenDiff\Formatters\Json;

function format(array $diffTree)
{
    return json_encode($diffTree);
}
