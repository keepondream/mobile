<?php

namespace App\Http\Controllers\Admin;

use App\Common\Common;
use App\http\Model\Brand;
use App\http\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * 分类管理页
     * @param Request $request
     */
    public function category(Request $request)
    {
        //获取所有的分类
        $data['category'] = [];
        $categorys = Category::all()->toArray();
        if (!empty($categorys)) {
            $tempArr = [];
            foreach ($categorys as $v) {
                $tempCategory = [];
                $tempCategory['id'] = $v['id'];
                $tempCategory['pId'] = $v['parent_id'];
                $tempCategory['name'] = $v['name'];
                $tempCategory['file'] = route('categoryAdd',['id'=>$v['id']]);
                if ($v['parent_id'] == 0) {
                    $tempCategory['open'] = true;
                }
               $tempArr[] = $tempCategory;
            }
            $data['category'] = json_encode($tempArr);
        }
        return view('admin/category',$data);
    }

    /**
     * 添加修改产品分类
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function categoryAdd(Request $request)
    {
        //获取数据并验证安全处理
        $param = Common::dataCheck($request->input());
        $data['data'] = '';
        if (!empty($param['id'])) {
            $category = Category::find($param['id']);
            if (!empty($category)) {
                $data['data'] = $category->toArray();
            }
        }
        //如果是post提交判断是否存在ID且不为空 有则更新无则新增
        if($request->isMethod('post')){
            if (!empty($category)) {
                //修改
                $category->name = $param['name'];
                $category->parent_id = $param['parent_id'];
                $category->status = $param['status'];
                !empty($param['sort']) && $category->sort = $param['sort'];
                !empty($param['desc']) && $category->desc = $param['desc'];
                $msg = Common::jsonOutData(201,'编辑失败!~');
                if ($category->save()) {
                    $msg = Common::jsonOutData(200,'编辑成功!');
                }
            } else {
                //新增
                unset($param['id']);
                $res = Category::create($param);
                $msg = Common::jsonOutData(201,'添加失败!~');
                if ($res) {
                    $msg = Common::jsonOutData(200,'添加成功!');
                }
            }
            return response()->json($msg);
        }
        $data['category'] = Common::tree(0,1);
        return view('admin/category_add',$data);
    }

    /**
     * 删除分类
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function categoryDel(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $msg = Common::jsonOutData(201,'非法请求!~');
        if (!empty($param['id'])) {
            //验证是否有父级分类
            if (!empty(Category::where('parent_id',$param['id'])->get()->toArray())) {
                $msg = Common::jsonOutData(201,'请先删除子分类!~');
            } else {
                if (Category::destroy($param['id'])) {
                    $msg = Common::jsonOutData(200,'删除成功!');
                } else {
                    $msg = Common::jsonOutData(201,'删除失败!~');
                }
            }
        }
        return response()->json($msg);
    }

    /**
     * 平台管理页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function paas(Request $request)
    {
        //获取所有的分类
        $data['category'] = Category::all();
        //获取所有的平台
        $data['brands'] = Brand::all();
        return view('admin/paas',$data);
    }

    /**
     * 添加平台
     * @param Request $request
     */
    public function paasAdd(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $brand = Brand::where('name',$param['name'])->get()->toArray();
        $msg = Common::jsonOutData(201,'添加失败!~');
        if ($request->isMethod('post')) {
            if (!empty($brand)) {
                $msg = Common::jsonOutData(201,'该平台已经存在!~');
            } else {
                if (Brand::create($param)) {
                    $msg = Common::jsonOutData(200,'添加成功!');
                }
            }
        }

        return response()->json($msg);
    }

    /**
     * 删除平台
     * @param Request $request
     */
    public function paasDel(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $msg = Common::jsonOutData(201,'非法请求!~');
        if (!empty($param['id'])) {
            Brand::destroy($param['id']);
            $msg = Common::jsonOutData(200,'删除成功!~');
        }
        if (!empty($param['ids'])) {
            Brand::destroy($param['ids']);
            $msg = Common::jsonOutData(200,'删除成功!~');
        }
        return response()->json($msg);
    }


    public function passStatus(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $msg = Common::jsonOutData(201,'非法请求!~');
        if (!empty($param['id'])) {

            $pass = Brand::find($param['id']);
            if (!empty($pass)) {
                $pass->status = $param['status'];
                if ($pass->save()) {
                    $msg = Common::jsonOutData(200,'修改成功!');
                }
            }
        }
        return response()->json($msg);
    }
}
