<?php

namespace GenDiff\Tests;

use PHPUnit\Framework\TestCase;

use function GenDiff\DifferFiles\differ;
use function GenDiff\ReadData\readData;

class DifferTest extends TestCase
{
    public function testDiffer()
    {
        $correctDiff = (file_get_contents(dirname(__DIR__) . '/' . 'tests/fixtures/correctDiff'));
        $resultDiff = differ('files/file1.json', 'files/file2.json');
        $this->assertEquals($correctDiff, $resultDiff);
    }
}
