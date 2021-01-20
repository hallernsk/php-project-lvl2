<?php

namespace GenDiff\Tests;

use PHPUnit\Framework\TestCase;

use function GenDiff\DifferMain\differ;

class DifferTest extends TestCase
{
    public function testDifferJson()
    {
        $correctDiff = (file_get_contents(__DIR__ . '/fixtures/correctDiff'));
        $resultDiff = differ('files/file1.json', 'files/file2.json');
        $this->assertEquals($correctDiff, $resultDiff);
    }

    public function testDifferYaml()
    {
        $correctDiff = (file_get_contents(__DIR__ . '/fixtures/correctDiff'));
        $resultDiff = differ('files/file1.yml', 'files/file2.yml');
        $this->assertEquals($correctDiff, $resultDiff);
    }  
    
    public function testDifferTreeJson()
    {
        $correctDiff = (file_get_contents(__DIR__ . '/fixtures/correctDiffTree'));
        $resultDiff = differ('files/fileTree1.json', 'files/fileTree2.json');
        $this->assertEquals($correctDiff, $resultDiff);
    }
}
