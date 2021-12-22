<?php

namespace App\Http\Controllers;

use App\Menus\GetSidebarMenu;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

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
        return $this->apiResponse($menus->get($roles, $menuName));
    }
}
