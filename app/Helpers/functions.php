<?php
/*
|--------------------------------------------------------------------------
| 自定义函数
|--------------------------------------------------------------------------
*/


/** 生成导航菜单树
 * @param array $menus      菜单数据
 * @param int $current_id   当前菜单ID
 * @param int $level        菜单层级
 * @param int $parent_id    上级菜单ID
 * @return string           导航菜单树 ul>li
 */
function get_nav_li_list($menus, $current_id,$parents_ids=[], $level=1, $parent_id=0){
    $str='';
    $list=get_childs($menus,$parent_id);
    $childs=$list['childs'];
    $new_list=$list['new_list'];
    if(count($childs)){
        foreach($childs as $child){
            if($level==1){
                $menu_name='<span class="menu-text">'.$child->name.'</span>';
            }else{
                $menu_name=$child->name;
            }
            /* 第二级菜单图标改为箭头 */
            if($level==2){
                $icon='<i class="menu-icon fa fa-caret-right"></i>';
            }else{
                $icon=$child->icon;
            }
            /* li标签class */
            if(in_array($child->id,$parents_ids)){
                $li_class=' class="active open" ';
            }elseif($child->id==$current_id){
                $li_class=' class="active" ';
            }else{
                $li_class='';
            }
            $str_childs=get_nav_li_list($new_list,$current_id,$parents_ids,$level+1,$child->id);
            if($str_childs){
                $a_class=' class="dropdown-toggle" ';
                $b_in_a='<b class="arrow fa fa-angle-down"></b>';
                $str .= '<li '.$li_class.'><a href="'.$child->url.'" '.$a_class.'>'.$icon.$menu_name.$b_in_a.'</a><b class="arrow"></b>';
                $str .=$str_childs;
            }else{
                $a_class='';
                $b_in_a='';
                $str .= '<li '.$li_class.'><a href="'.$child->url.'" '.$a_class.'>'.$icon.$menu_name.'</span>'.$b_in_a.'</a><b class="arrow"></b>';
            }
            $str.='</li>';
        }
        /* ul标签class */
        $ul_class=$level==1?'nav nav-list':'submenu';
        $str ='<ul class="'.$ul_class.'">'.$str.'</ul>';
    }
    return $str;
}
