<?php

namespace App\Http\Controllers;

use App\Models\Fixcontent;
use Illuminate\Http\Request;
// use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class FixcontentController extends ApiController
{

    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        $fixcontents = Fixcontent::paginate(15);
        return $this->respond($fixcontents);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'old_article' => 'required',
            'new_article' => 'required',
        ]);
        $fixcontent = new Fixcontent();
        $fixcontent->old_article = $request->input('old_article');
        $fixcontent->new_article = $request->input('new_article');
        $fixcontent->save();
        return $this->respond($fixcontent);
    }

    public function show(Fixcontent $fixcontent)
    {
        //
        $element = Fixcontent::where('id', '=', $request->input('id'))->first();
    }

    public function update(Request $request, Fixcontent $fixcontent)
    {
        //
    }

    public function destroy(Fixcontent $fixcontent)
    {
        //
    }

    private function getLimit(Collection $filter): int
    {
        return $filter['limit'] ?? static::FILTER_LIMIT;
    }

    private function getOffset(Collection $filter): int
    {
        return $filter['offset'] ?? static::FILTER_OFFSET;
    }
}
