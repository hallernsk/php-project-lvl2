<?php

namespace GenDiff\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    /**
     * @dataProvider addDataProvider
     */
    public function testDiffer($file1, $file2, $format, $correctDiff)
    {
        $this->assertEquals($correctDiff, genDiff($file1, $file2, $format));
    }

    public function addDataProvider()
    {
        $filePathJson1 =  $this->getFixtureFilepath('file1.json');
        $filePathJson2 = $this->getFixtureFilepath('file2.json');
        $filePathYml1 = $this->getFixtureFilepath('file1.yml');
        $filePathYml2 = $this->getFixtureFilepath('file2.yml');
        $expectedDiffStylish = file_get_contents($this->getFixtureFilepath('correctDiffStylish'));
        $expectedDiffPlain = file_get_contents($this->getFixtureFilepath('correctDiffPlain'));
        $expectedDiffJson = file_get_contents($this->getFixtureFilepath('correctDiffJson'));

        return [
            [$filePathJson1, $filePathJson2, 'stylish', $expectedDiffStylish],
            [$filePathYml1, $filePathYml2, 'stylish', $expectedDiffStylish],
            [$filePathJson1, $filePathJson2, 'plain', $expectedDiffPlain],
            [$filePathYml1, $filePathYml2, 'plain', $expectedDiffPlain],
            [$filePathJson1, $filePathJson2, 'json', $expectedDiffJson],
            [$filePathYml1, $filePathYml2, 'json', $expectedDiffJson]
        ];
    }

    public function testDifferDefaultJson()
    {
        $correctDiff = (file_get_contents(__DIR__ . '/fixtures/correctDiffStylish'));
        $resultDiff = genDiff(__DIR__ . '/fixtures/file1.json', __DIR__ . '/fixtures/file2.json');
        $this->assertEquals($correctDiff, $resultDiff);
    }

    public function testDifferDefaultYaml()
    {
        $correctDiff = (file_get_contents(__DIR__ . '/fixtures/correctDiffStylish'));
        $resultDiff = genDiff(__DIR__ . '/fixtures/file1.yml', __DIR__ . '/fixtures/file2.yml');
        $this->assertEquals($correctDiff, $resultDiff);
    }

    public function getFixtureFilepath(string $filename): string
    {
        return __DIR__ . "/fixtures/{$filename}";
    }
}
