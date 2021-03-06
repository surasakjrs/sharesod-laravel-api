<?php

namespace App\Http\Controllers;

use App\Http\Menus\GetSidebarMenu;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ExampleController extends ApiController
{
    //
    public function index(Request $request)
    {
        for($i=1; $i <= 100; $i++){
            print_r('<p>');
            if($i%3 == 0 && $i%5 == 0) print_r('TestApp');
            else if($i%5 == 0) print_r('App');
            else if($i%3 == 0) print_r('Test');
            else print_r($i);
            print_r('</p>');
        }        
    }

    public function imageUploadPost(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $imageName = time().'.'.$request->image->extension();  
     
        $request->image->move(public_path('images'), $imageName);
  
        /* Store $imageName name in DATABASE from HERE */
    
        return back()
            ->with('success','You have successfully upload image.')
            ->with('image',$imageName); 
    }
}
