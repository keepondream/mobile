@extends('layouts.adminchild')
@section('css')
    <link rel="stylesheet" href="{{asset('lib/zTree/v3/css/zTreeStyle/zTreeStyle.css')}}" type="text/css">
@endsection
@section('title','产品分类')
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 产品管理 <span class="c-gray en">&gt;</span> 产品分类 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <table class="table">
        <tr>
            <td width="200" class="va-t"><ul id="treeDemo" class="ztree"></ul></td>
            <td class="va-t"><iframe ID="testIframe" Name="testIframe" FRAMEBORDER=0 SCROLLING=AUTO width=100%  height=390px SRC="{{route('categoryAdd')}}"></iframe></td>
        </tr>
    </table>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('lib/zTree/v3/js/jquery.ztree.all-3.5.min.js') }}"></script>
    <script type="text/javascript">
        var setting = {
            view: {
                dblClickExpand: false,
                showLine: false,
                selectedMulti: false
            },
            data: {
                simpleData: {
                    enable:true,
                    idKey: "id",
                    pIdKey: "pId",
                    rootPId: ""
                }
            },
            callback: {
                beforeClick: function(treeId, treeNode) {
                    // var zTree = $.fn.zTree.getZTreeObj("tree");
                    demoIframe.attr("src",treeNode.file + ".html");

                    // if (treeNode.isParent) {
                    //     zTree.expandNode(treeNode);
                    //     return false;
                    // } else {
                    //     demoIframe.attr("src",treeNode.file + ".html");
                    //     // demoIframe.attr("src","http://www.baidu.com");
                    //     return true;
                    // }
                }
            }
        };
        var zNodes = [];
        var Category = '<?php echo !empty($category) ? $category : ''?>';
        if (Category) {
            zNodes = JSON.parse(Category);
        }
        var code;

        function showCode(str) {
            if (!code) code = $("#code");
            code.empty();
            code.append("<li>"+str+"</li>");
        }

        $(document).ready(function(){
            var t = $("#treeDemo");
            t = $.fn.zTree.init(t, setting, zNodes);
            demoIframe = $("#testIframe");
            // demoIframe.on("load", loadReady);
            var zTree = $.fn.zTree.getZTreeObj("tree");
            // zTree.selectNode(zTree.getNodeByParam("id",'11'));
        });
    </script>
@endsection

