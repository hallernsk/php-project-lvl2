<?php

namespace GenDiff\Tests;

use PHPUnit\Framework\TestCase;

use function GenDiff\DifferMain\differ;

class DifferTest extends TestCase
{
    public function testDifferStylishJson()
    {
        $correctDiff = (file_get_contents(__DIR__ . '/fixtures/correctDiffStylish'));
        $resultDiff = differ('files/fileTree1.json', 'files/fileTree2.json', 'stylish');
        $this->assertEquals($correctDiff, $resultDiff);
    }
    
    public function testDifferStylishYaml()
    {
        $correctDiff = (file_get_contents(__DIR__ . '/fixtures/correctDiffStylish'));
        $resultDiff = differ('files/fileTree1.yml', 'files/fileTree2.yml', 'stylish');
        $this->assertEquals($correctDiff, $resultDiff);
    }

    public function testDifferPlainJson()
    {
        $correctDiff = (file_get_contents(__DIR__ . '/fixtures/correctDiffPlain'));
        $resultDiff = differ('files/fileTree1.json', 'files/fileTree2.json', 'plain');
        $this->assertEquals($correctDiff, $resultDiff);
    }

    public function testDifferPlainYaml()
    {
        $correctDiff = (file_get_contents(__DIR__ . '/fixtures/correctDiffPlain'));
        $resultDiff = differ('files/fileTree1.yml', 'files/fileTree2.yml', 'plain');
        $this->assertEquals($correctDiff, $resultDiff);
    }
}
