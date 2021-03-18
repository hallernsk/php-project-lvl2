<?php

namespace GenDiff\Tests;

use PHPUnit\Framework\TestCase;

use function GenDiff\DifferMain\differ;

class DifferTest extends TestCase
{
    /**
     * @dataProvider addDataProvider
     */

    public function testDiffer($file1, $file2, $format, $correctDiff)
    {
        $this->assertEquals($correctDiff, differ($file1, $file2, $format));
    }

    public function addDataProvider()
    {
        $formatStylish = 'stylish';
        $formatPlain = 'plain';
        $formatJson = 'json';
        $fileJson1 = __DIR__ . '/fixtures/file1.json';
        $fileJson2 = __DIR__ . '/fixtures/file2.json';
        $fileYml1 = __DIR__ . '/fixtures/file1.yml';
        $fileYml2 = __DIR__ . '/fixtures/file2.yml';
        $diffStylish = file_get_contents(__DIR__ . '/fixtures/correctDiffStylish');
        $diffPlain = file_get_contents(__DIR__ . '/fixtures/correctDiffPlain');
        $diffJson = file_get_contents(__DIR__ . '/fixtures/correctDiffJson');

        return [
            [$fileJson1, $fileJson2, $formatStylish, $diffStylish],
            [$fileYml1, $fileYml2, $formatStylish, $diffStylish],
            [$fileJson1, $fileJson2, $formatPlain, $diffPlain],
            [$fileYml1, $fileYml2, $formatPlain, $diffPlain],
            [$fileJson1, $fileJson2, $formatJson, $diffJson],
            [$fileYml1, $fileYml2, $formatJson, $diffJson]
        ];
    }
}
