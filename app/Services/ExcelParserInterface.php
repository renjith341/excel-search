<?php

namespace App\Services;

interface ExcelParserInterface
{

    /*
    * @throws Exception
    */
    public function searchData(array $filters, string $dataSource): array;
}
