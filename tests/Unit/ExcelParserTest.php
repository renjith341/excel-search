<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\ExcelParser;
use Carbon\Factory;

class ExcelParserTest extends TestCase
{
    
    public function test_searchDataShouldReturnList(): void
    {
        $excelParser = new ExcelParser();
        $serverList = $excelParser->searchData(
            $filters = [
                'ram' => [64],
                'storage' => '10 TB - 16 TB',
                'harddiskType' => '',
                'location' => ''
            ],
            getcwd() . '/data/file.xlsx'
            );

        $this->assertCount(25, $serverList);
    }
}
