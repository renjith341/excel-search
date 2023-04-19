<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SearchPostRequest;
use App\Services\ExcelParserInterface;
use Config;

class SearchController extends Controller
{

    public function __construct(private ExcelParserInterface $excelParser)
    {
    }

    public function index(Request $request)
    {
        return view('search-filter');
    }

    public function search(SearchPostRequest $request)
    {
        $filters = $request->validated();
        $viewVars = ['serverList' => [], 'error' => ''];

        try {
            $viewVars['serverList'] = $this->excelParser->searchData($filters, getcwd() . config('app.data_source'));
        } catch (\Exception $e) {
            $viewVars['error'] = $e->getMessage();
        }

        return view('search-result', $viewVars);
    }
}
