<?php

namespace GenDiff\Formatters\Json;

function formaterJson(array $diffTree)
{
    return json_encode($diffTree);
}
