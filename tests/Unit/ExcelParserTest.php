<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\ExcelParser;
use Carbon\Factory;
use Box\Spout\Common\Exception\IOException;

class ExcelParserTest extends TestCase
{

    public function test_search_data_with_all_filters_should_return_list(): void
    {
        $serverList = app()->make(ExcelParser::class)->searchData(
            $filters = [
                'ram' => [32],
                'storageFrom' => '1TB',
                'storageTo' => '12TB',
                'harddiskType' => 'SATA',
                'location' => 'Washington D.C.WDC-01'
            ],
            getcwd() . '/data/file.xlsx'
        );

        $this->assertCount(15, $serverList);
    }

    public function test_search_data_with_no_filters_should_return_all(): void
    {
        $serverList = app()->make(ExcelParser::class)->searchData(
            $filters = [],
            getcwd() . '/data/file.xlsx'
        );

        $this->assertCount(486, $serverList);
    }

    public function test_search_data_with_no_file_should_return_exception(): void
    {
        $this->expectException(IOException::class);
        $this->expectExceptionMessageMatches('/File does not exist/');

        $serverList = app()->make(ExcelParser::class)->searchData(
            $filters = [],
            getcwd() . '/data/no_file.xlsx'
        );
    }

    public function test_search_data_with_few_filters_should_return_list(): void
    {
        $serverList = app()->make(ExcelParser::class)->searchData(
            $filters = [
                'storageFrom' => '500GB',
                'storageTo' => '1TB',
                'harddiskType' => 'SATA',
                'location' => null
            ],
            getcwd() . '/data/file.xlsx'
        );

        $this->assertCount(31, $serverList);
    }
}
