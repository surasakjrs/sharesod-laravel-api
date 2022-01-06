<?php

namespace App\Menus;

use App\Menus\Menubuilder;
use App\Menus\RenderFromDatabaseData;
use App\Models\Menus;

class GetSidebarMenu implements MenuInterface
{
    private $mb;
    private $menu;

    public function __construct(){
        $this->mb = new MenuBuilder();
    }

    private function getMenuFromDB($menuName, $role)
    {
        $this->menu = Menus::join('menu_role', 'menus.id', '=', 'menu_role.menus_id')
            ->join('menulist', 'menulist.id', '=', 'menus.menu_id')
            ->select('menus.*')
            ->where('menulist.name', '=', $menuName)
            ->where('menu_role.role_name', '=', $role)
            ->orderBy('menus.sequence', 'asc')
            ->get();
    }

    private function getGuestMenu($menuName){
        $this->getMenuFromDB($menuName, 'guest');
    }

    private function getUserMenu($menuName){
        $this->getMenuFromDB($menuName, 'user');
    }

    private function getAdminMenu($menuName){
        $this->getMenuFromDB($menuName, 'admin');
    }

    public function get($roles, $menuName = 'sidebar menu'){
        $roles = explode(',', $roles);
        if(empty($roles)){
            $this->getGuestMenu($menuName);
        }elseif(in_array('admin', $roles)){
            $this->getAdminMenu($menuName);
        }elseif(in_array('user', $roles)){
            $this->getUserMenu($menuName);
        }else{
            $this->getGuestMenu($menuName);
        }
        $rfd = new RenderFromDatabaseData;
        return $rfd->render($this->menu);
    }

    public function getAll( $menuId = 1 ){
        $this->menu = Menus::select('menus.*')
            ->where('menus.menu_id', '=', $menuId)
            ->orderBy('menus.sequence', 'asc')->get();  
        $rfd = new RenderFromDatabaseData;
        return $rfd->render($this->menu);
    }
}
