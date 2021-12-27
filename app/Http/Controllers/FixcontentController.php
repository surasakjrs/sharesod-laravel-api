<?php

namespace App\Http\Controllers;

use App\Models\Fixcontent;
use Illuminate\Http\Request;
// use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FixcontentController extends ApiController
{

    // public function __construct()
    // {
    //     $this->middleware('auth.admin');
    // }

    public function generate_content(Request $req)
    {
        $content = $req->input('content');
        $words = DB::table('fb_fixcontent_words')->select('*')->get();

        foreach ($words as $key => $value) {
            $content = str_replace($value->old_word, $value->new_word, $content);
        }

        return $this->api_respond($content);
    }

    public function addNewWord(Request $req)
    {
        $word = DB::table('fb_fixcontent_words')
            ->select('old_word')
            ->where('old_word', '=', $req->input('old_word'))
            ->first();
        if (!$word) {
            $addword = DB::table('fb_fixcontent_words')->insert(
                [
                    'old_word' => $req->input('old_word'), 
                    'new_word' => $req->input('new_word')]
            );
            return $this->api_respond($addword);
        }

        return $this->respondError('This word is duplicated');
    }

    // public function index()
    // {
    //     $fixcontents = Fixcontent::paginate(15);
    //     return $this->respond($fixcontents);
    // }

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'old_article' => 'required',
    //         'new_article' => 'required',
    //     ]);
    //     $fixcontent = new Fixcontent();
    //     $fixcontent->old_article = $request->input('old_article');
    //     $fixcontent->new_article = $request->input('new_article');
    //     $fixcontent->save();
    //     return $this->respond($fixcontent);
    // }

    // public function show(Fixcontent $fixcontent)
    // {
    //     //
    //     $element = Fixcontent::where('id', '=', $request->input('id'))->first();
    // }

    // public function update(Request $request, Fixcontent $fixcontent)
    // {
    //     //
    // }

    // public function destroy(Fixcontent $fixcontent)
    // {
    //     //
    // }

    // private function getLimit(Collection $filter): int
    // {
    //     return $filter['limit'] ?? static::FILTER_LIMIT;
    // }

    // private function getOffset(Collection $filter): int
    // {
    //     return $filter['offset'] ?? static::FILTER_OFFSET;
    // }
}
