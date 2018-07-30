<?php

namespace App\Http\Controllers\Admin;

use App\Common\Common;
use App\http\Model\Brand;
use App\http\Model\Category;
use App\http\Model\Project;
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
//        $data['category'] = Category::all();
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
        $data['brand'] = '';
        if (!empty($param['id'])) {
            $data['brand'] = Brand::find($param['id']);
        }
        if ($request->isMethod('post')) {
            $msg = Common::jsonOutData(201,'添加失败!~');
            if (!empty($data['brand'])) {
                $msg = Common::jsonOutData(201,'编辑失败!~');
                //修改
                $data['brand']->name = $param['name'];
                $data['brand']->status = $param['status'];
                !empty($param['sort']) && $data['brand']->sort = $param['sort'];
                !empty($param['desc']) && $data['brand']->desc = $param['desc'];
                if ($data['brand']->save()) {
                    $msg = Common::jsonOutData(200,'编辑成功!');
                }
            } else {
                $brand = Brand::where('name',$param['name'])->get()->toArray();
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
        return view('admin/pass_add',$data);
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

    /**
     * 修改平台启用状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * 项目管理
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function project(Request $request)
    {
        $param = Common::dataCheck($request->input());
        //获取所有项目的数量
        $data['count'] = Project::count();
        $data['projects'] = Project::all();
        //判断是否有搜索
        if (!empty($param) && isset($param['searchData']) && $request->isMethod('post')) {
            $idOrname = $param['searchData'];
            if (!empty($idOrname)) {
                $res = Project::where(function ($query) use ($idOrname) {
                    $query->where('id',$idOrname)
                        ->orWhere('name','like','%'.$idOrname.'%');
                })->get();
                if (count($res) > 0) {
                    $data['projects'] = $res;
                }
            }
        }
        return view('admin/project',$data);
    }

    /**
     * 添加项目
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function projectAdd(Request $request)
    {
        //获取数据并验证安全处理
        $param = Common::dataCheck($request->input());
        $data['data'] = '';
        //获取平台
        $data['brands'] = Brand::all();
        if (!empty($param['id'])) {
            $project = Project::find($param['id']);
            if (!empty($project)) {
                $data['project'] = $project;
            }
        }
        //如果是post提交判断是否存在ID且不为空 有则更新无则新增
        if($request->isMethod('post')){
            if (!empty($project)) {
                //修改
                $project->name = $param['name'];
                $project->sign = $param['sign'];
                $project->brand_id = $param['brand_id'];
                $project->status = $param['status'];
                !empty($param['sort']) && $project->sort = $param['sort'];
                $project->desc = $param['desc'];
                $msg = Common::jsonOutData(201,'编辑失败!~');
                if ($project->save()) {
                    $msg = Common::jsonOutData(200,'编辑成功!');
                }
            } else {
                //新增
                $msg = Common::jsonOutData(201,'添加失败!~');
                unset($param['id']);
                $brand = Project::where(['name'=>$param['name'],'brand_id'=>$param['brand_id']])->get()->toArray();
                if (!empty($brand)) {
                    $msg = Common::jsonOutData(201,'该项目已经存在!~');
                } else {
                    $res = Project::create($param);
                    if ($res) {
                        $msg = Common::jsonOutData(200,'添加成功!');
                    }
                }

            }
            return response()->json($msg);
        }
        return view('admin/project_add',$data);

    }

    /**
     * 删除项目
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectDel(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $msg = Common::jsonOutData(201,'非法请求!~');
        if (!empty($param['id'])) {
            Project::destroy($param['id']);
            $msg = Common::jsonOutData(200,'删除成功!~');
        }
        if (!empty($param['ids'])) {
            Project::destroy($param['ids']);
            $msg = Common::jsonOutData(200,'删除成功!~');
        }
        return response()->json($msg);
    }

    /**
     * 修改项目状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectStatus(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $msg = Common::jsonOutData(201,'非法请求!~');
        if (!empty($param['id'])) {
            $pass = Project::find($param['id']);
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
