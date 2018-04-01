<?php
/*
|--------------------------------------------------------------------------
| 项目菜单
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Household;
use App\Http\Model\Householdassets;
use App\Http\Model\Householdbuilding;
use App\Http\Model\Householdbuildingarea;
use App\Http\Model\Householdbuildingdeal;
use App\Http\Model\Householddetail;
use App\Http\Model\Householdright;
use App\Http\Model\Item;
use App\Http\Model\Menu;
use App\Http\Model\Process;
use App\Http\Model\Worknotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaseitemController extends BaseController
{
    public $item_id;
    public $item;
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();

        $this->middleware(function ($request,$next){
            $item_id=$request->input('item');
            if(blank($item_id)){
                $result=['code'=>'error','message'=>'请指定征收项目','sdata'=>null,'edata'=>null,'url'=>null];
                if(request()->ajax()){
                    return response()->json($result);
                }else{
                    return redirect()->route('g_error')->with($result);
                }
            }
            $this->item_id=$item_id;
            $this->item=Item::sharedLock()->find($item_id);

            if(!$request->ajax()){
                $menus=Menu::with(['childs'=>function($query){
                    $query->where('display',1)->orderBy('sort','asc');
                }])
                    ->withCount(['childs'=>function($query){
                        $query->where('display',1);
                    }])
                    ->sharedLock()
                    ->where([
                        ['parent_id',40],
                        ['id','<>',41],
                        ['display',1],
                    ])
                    ->orderBy('sort','asc')
                    ->get();

                $nav_menus=$this->makeMenu2($menus,session('menu.cur_menu.id'),session('menu.cur_pids'),1,41,$item_id);

                view()->share(['nav_menus'=>$nav_menus,'item'=>$this->item]);
            }

            return $next($request);
        });
    }

    public function makeMenu2($menus,$cur_id,$pids,$level=1,$pid=0,$item_id){
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
                $str .= '<li '.$li_class.'><a href="'.$menu->url.'?item='.$item_id.'" '.$a_class.'>'.$icon.$menu_name.$b_in_a.'</a><b class="arrow"></b>';
                $str .=$this->makeMenu2($menu->childs,$cur_id,$pids,$level+1,$menu->id,$item_id);;
            }else{
                $a_class='';
                $b_in_a='';
                $str .= '<li '.$li_class.'><a href="'.$menu->url.'?item='.$item_id.'" '.$a_class.'>'.$icon.$menu_name.'</span>'.$b_in_a.'</a><b class="arrow"></b>';
            }
            $str.='</li>';
        }
        /* ul标签class */
        $ul_class=$level==1?'nav nav-list':'submenu';
        $str ='<ul class="'.$ul_class.'">'.$str.'</ul>';

        return $str;
    }

    /* ========== 是否有工作提醒 ========== */
    public function hasNotice(){
        /* ++++++++++ 流程设置 ++++++++++ */
        $process=Process::sharedLock()->where('menu_id',session('menu.cur_menu.id'))->first();


        /* ++++++++++ 是否有工作推送 ++++++++++ */
        $worknotice=Worknotice::lockForUpdate()
            ->where([
                ['item_id',$this->item->id],
                ['schedule_id',$process->schedule_id],
                ['process_id',$process->id],
                ['menu_id',$process->menu_id],
                ['user_id',session('gov_user.user_id')],
            ])
            ->whereIn('code',['0','20'])
            ->first();
        if(blank($worknotice)){
            throw new \Exception('您没有执行此操作的工作推送',404404);
        }
        /* ++++++++++ 下级未完成数 ++++++++++ */
        $worknotice_subs=Worknotice::sharedLock()
            ->where([
                ['item_id',$this->item->id],
                ['schedule_id',$process->schedule_id],
                ['process_id',$process->id],
                ['menu_id',$process->menu_id],
                ['parent_id',session('gov_user.role_id')],
            ])
            ->whereIn('code',['0','20'])
            ->count();
        if($worknotice_subs){
            throw new \Exception('您的下级未完成此操作，您的操作暂时不能被执行',404404);
        }

        return ['process'=>$process,'worknotice'=>$worknotice];
    }


    /* ++++++++++ [确权确户状态检测] ++++++++++ */
    public function household_status($household_id=0){
        if(!is_numeric($household_id)){
            return false;
        }
        /*----------- 检测被征户状态 ------------*/
        $householddetail = Householddetail::with([
            'household'=>function($query){
                $query->select(['id','code']);
            }])
            ->sharedLock()
            ->where('item_id',$this->item_id)
            ->where('household_id',$household_id)
            ->first();
        if(blank($householddetail)){
            return false;
        }
        /*----------- 检测产权争议 ------------*/
        if($householddetail->getOriginal('dispute')!=0){
            $householdright = Householdright::where('item_id',$this->item_id)->where('household_id',$household_id)->count();
            if($householdright==0){
                return false;
            }
        }
        /*----------- 检测面积争议 ------------*/
        if($householddetail->getOriginal('area_dispute')!=0||$householddetail->getOriginal('area_dispute')!=3){
            if($householddetail->getOriginal('area_dispute')==1||$householddetail->getOriginal('area_dispute')==2||$householddetail->getOriginal('area_dispute')==4){
                return false;
            }
            /*-----有争议[是否已经处理]-----*/
            if($householddetail->getOriginal('area_dispute')==5){
                $householdbuildingarea = Householdbuildingarea::where('item_id',$this->item_id)->where('household_id',$household_id)->count();
                if($householdbuildingarea==0){
                    return false;
                }
            }
        }
        /*----------- 检测违建处理 ------------*/
        $householdbuilding = Householdbuilding::where('item_id',$this->item_id)->where('household_id',$household_id)->distinct()->pluck('id','code');
        $building_ids = [];
        foreach($householdbuilding as $k=>$v){
            /*---房屋未认定或认定非法---*/
            if($k==91||$k==93){
                return false;
            }
            if($k==94||$k==95){
                $building_ids[] = $v;
            }
        }
       $building_count = Householdbuildingdeal::where('item_id',$this->item_id)->where('household_id',$household_id)->whereIn('household_building_id',$building_ids)->count();
        if(count($building_ids)!=$building_count){
            return false;
        }
        /*----------- 检测房产 ------------*/
        if($householddetail->household->code<62){
            return false;
        }
        /*----------- 检测资产 ------------*/
        if($householddetail->getOriginal('has_assets')==1){
             $householdassets = Householdassets::where('item_id',$this->item_id)->where('household_id',$household_id)->pluck('number');
            $householdassets = $householdassets->toArray();
            foreach($householdassets as $k=>$v){
                if(!$v){
                    return false;
                }
            }
        }
        return true;
    }
}
