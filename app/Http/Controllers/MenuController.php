<?php

namespace App\Http\Controllers;

use App\Http\Menus\GetSidebarMenu;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MenuController extends ApiController
{
    //
    public function index(Request $request)
    {
        
        try {
            $user = auth()->user();
            if ($user && !empty($user)) {
                $roles = $user->menuroles;
                
            } else {
                $roles = '';
            }
        } catch (Exception $e) {
            $roles = '';
        }
        
        if ($request->has('menu')) {
            $menuName = $request->input('menu');
        } else {
            $menuName = 'sidebar menu';
        }
        $menus = new GetSidebarMenu();
        return $this->api_respond($menus->get($roles, $menuName));
    }

    public function getMenus(Request $request){
        $email = $request->input('email');
        $roles = DB::table('users')->select('menuroles')->where('email', '=', $email)->value('roles');
        $menus = new GetSidebarMenu();
        $menuName = 'sidebar menu';
        return $this->api_respond($menus->get($roles, $menuName));
    }
}
