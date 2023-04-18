<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExcelParser;

class SearchController extends Controller
{

    //should be moved to a configuration DI
    final public const DATA_SOURCE = '/../data/file.xlsx';

    public function __construct(private ExcelParser $excelParser)
    {
    }

    public function index(Request $request)
    {
        return view('search-filter');
    }

    public function search(Request $request)
    {
        $filters = [
            'ram' => $request->input('ram') ?? '',
            'storage' => $request->input('storage') ?? '',
            'harddiskType' => $request->input('harddiskType') ?? '',
            'location' => $request->input('location') ?? ''
        ];

        //implement filter validation service and use here

        try {
            $serverList = $this->excelParser->searchData($filters, getcwd() . self::DATA_SOURCE);
        } catch (\Exception $e) {
            // handle error case here
        }

        return view('search-result', ['serverList' => $serverList]);
    }
}
