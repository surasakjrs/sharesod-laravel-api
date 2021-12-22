<?php

namespace App\Http\Controllers;

use App\Models\Facebook\FixcontentWord;
use Illuminate\Http\Request;

class FacebookController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function add_word(Request $request)
    {
        $validatedData = $request->validate([
            'old_word' => 'required',
            'new_word' => 'required',
        ]);
        $model = new FixcontentWord();
        $model->old_word = $request->input('old_word');
        $model->new_word = $request->input('new_word');
        $model->save();
        return $this->respond($model);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_word()
    {
        $list = FixcontentWord::paginate(15);
        return $this->respond($list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Facebook  $facebook
     * @return \Illuminate\Http\Response
     */
    public function show(Facebook $facebook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facebook  $facebook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facebook $facebook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facebook  $facebook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facebook $facebook)
    {
        //
    }
}
