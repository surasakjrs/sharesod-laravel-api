<?php

namespace App\Menus;

// use App\Menus\Menubuilder\Menubuilder;
use App\Menus\MenuBuilder\RenderFromDatabaseData;
use App\Models\Menus;

class GetSidebarMenu implements MenuInterface
{
    private $mb;
    private $menu;

    // public function __construct()
    // {
    //     $this->mb = new Menubuilder();
    // }

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

    private function getGuestMenu($menuName)
    {
        $this->getMenuFromDB($menuName, 'guest');
    }

    public function get($roles, $menuName = 'sidebar menu')
    {
        $roles = explode(',', $roles);
        $this->getGuestMenu($menuName);
        $rfd = new RenderFromDatabaseData;
        return $rfd->render($this->menu);
    }
}
