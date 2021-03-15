<?php

namespace GenDiff\Tests;

use PHPUnit\Framework\TestCase;

use function GenDiff\DifferMain\differ;

class DifferTest extends TestCase
{
    public function testDifferStylishJson()
    {
        $correctDiff = (file_get_contents(__DIR__ . '/fixtures/correctDiffStylish'));
        $resultDiff = differ('tests/fixtures/file1.json', 'tests/fixtures/file2.json', 'stylish');
        $this->assertEquals($correctDiff, $resultDiff);
    }
    
    public function testDifferStylishYaml()
    {
        $correctDiff = (file_get_contents(__DIR__ . '/fixtures/correctDiffStylish'));
        $resultDiff = differ('tests/fixtures/file1.yml', 'tests/fixtures/file2.yml', 'stylish');
        $this->assertEquals($correctDiff, $resultDiff);
    }

    public function testDifferPlainJson()
    {
        $correctDiff = (file_get_contents(__DIR__ . '/fixtures/correctDiffPlain'));
        $resultDiff = differ('tests/fixtures/file1.json', 'tests/fixtures/file2.json', 'plain');
        $this->assertEquals($correctDiff, $resultDiff);
    }

    public function testDifferPlainYaml()
    {
        $correctDiff = (file_get_contents(__DIR__ . '/fixtures/correctDiffPlain'));
        $resultDiff = differ('tests/fixtures/file1.yml', 'tests/fixtures/file2.yml', 'plain');
        $this->assertEquals($correctDiff, $resultDiff);
    }

    public function testDifferJsonJson()
    {
        $correctDiff = (file_get_contents(__DIR__ . '/fixtures/correctDiffJson'));
        $resultDiff = differ('tests/fixtures/file1.json', 'tests/fixtures/file2.json', 'json');
        $this->assertEquals($correctDiff, $resultDiff);
    }

    public function testDifferJsonYaml()
    {
        $correctDiff = (file_get_contents(__DIR__ . '/fixtures/correctDiffJson'));
        $resultDiff = differ('tests/fixtures/file1.yml', 'tests/fixtures/file2.yml', 'json');
        $this->assertEquals($correctDiff, $resultDiff);
    }    
}
