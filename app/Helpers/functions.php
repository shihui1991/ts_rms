<?php
/*
|--------------------------------------------------------------------------
| 自定义函数
|--------------------------------------------------------------------------
*/


/** 获取操作控制器和方法
 * @return array
 */
function get_method(){
    return explode('@',class_basename(request()->route()->getActionName()));
}

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


/** 人民币大写
 * @param $ns
 * @return mixed
 */
function bigRMB($ns) {
    static $cnums=array("零","壹","贰","叁","肆","伍","陆","柒","捌","玖"),
    $cnyunits=array("","圆","角","分"),
    $grees=array("","拾","佰","仟","万","拾","佰","仟","亿");


    @list($ns1,$ns2)=explode(".",$ns,2);

    $ns2=array_filter(array($ns2[1],$ns2[0])); //转为数组

    $arrayTemp=_cny_map_unit(str_split($ns1),$grees);

    $ret=array_merge($ns2,array(implode("",$arrayTemp),"")); //处理整数

    $arrayTemp=_cny_map_unit($ret,$cnyunits);

    $ret=implode("",array_reverse($arrayTemp)); 	//处理小数

    return str_replace(array_keys($cnums),$cnums,$ret);
}

function _cny_map_unit($list,$units) {
    $ul=count($units);
    $xs=array();
    foreach (array_reverse($list) as $x) {
        $l=count($xs);

        if ($x!="0" || !($l%4)) $n=($x=='0'?'':$x).($units[($l)%$ul]);
        else $n=is_numeric(@$xs[0][0])?$x:'';
        array_unshift($xs,$n);
    }
    return $xs;
}
