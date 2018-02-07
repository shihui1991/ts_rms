<?php
/*
|--------------------------------------------------------------------------
| 工具
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\Houselayoutimg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ToolsController extends BaseController
{
    /* ========== 上传文件 ========== */
    public function upl(Request $request){
        $files=$request->file();
        $keys=array_keys($files);
        $file=$files[$keys[0]];
        if($file->isValid()){
            $path=$file->store(date('ymd'),'public');
            $result=['code'=>'success','message'=>'上传成功','sdata'=>['path'=>'/storage/'.$path],'edata'=>null,'url'=>null];
        }else{
            $result=['code'=>'error','message'=>'文件无效','sdata'=>null,'edata'=>null,'url'=>null];
        }

        return response()->json($result);
    }

}