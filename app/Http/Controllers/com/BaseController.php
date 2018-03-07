<?php
/*
|--------------------------------------------------------------------------
| 基础控制器
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\com;

use App\Http\Controllers\Controller;
use App\Http\Model\Menu;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        if(!request()->ajax()){
            /* ++++++++++ 一级菜单 ++++++++++ */
            $top_menus=Menu::sharedLock()
                ->where([
                    ['parent_id',0],
                    ['module',1],
                    ['login',1],
                    ['display',1],
                ])
                ->orderBy('sort','asc')
                ->get();

            view()->share(['top_menus'=>$top_menus]);
        }
    }


    public function makeMenu($menus,$cur_id,$pids,$level=1,$pid=0){
        $str='';

        foreach($menus as $menu){
            if($level==1){
                $menu_name='<span class="menu-text">'.$menu->name.'</span>';
            }else{
                $menu_name=$menu->name;
            }
            /* 第二级菜单图标改为箭头 */
            if($level==2){
                $icon='<i class="menu-icon fa fa-caret-right"></i>';
            }else{
                $icon=$menu->icon;
            }
            /* li标签class */
            if(in_array($menu->id,$pids)){
                $li_class=' class="active open" ';
            }elseif($menu->id==$cur_id){
                $li_class=' class="active" ';
            }else{
                $li_class='';
            }

            if($menu->childs_count){
                $a_class=' class="dropdown-toggle" ';
                $b_in_a='<b class="arrow fa fa-angle-down"></b>';
                $str .= '<li '.$li_class.'><a href="'.$menu->url.'" '.$a_class.'>'.$icon.$menu_name.$b_in_a.'</a><b class="arrow"></b>';
                $str .=$this->makeMenu($menu->childs,$cur_id,$pids,$level+1,$menu->id);;
            }else{
                $a_class='';
                $b_in_a='';
                $str .= '<li '.$li_class.'><a href="'.$menu->url.'" '.$a_class.'>'.$icon.$menu_name.'</span>'.$b_in_a.'</a><b class="arrow"></b>';
            }
            $str.='</li>';
        }
        /* ul标签class */
        $ul_class=$level==1?'nav nav-list':'submenu';
        $str ='<ul class="'.$ul_class.'">'.$str.'</ul>';

        return $str;
    }
}
