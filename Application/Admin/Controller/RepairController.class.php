<?php
/**
 * Created by PhpStorm.
 * User: tw
 * Date: 2017/8/10
 * Time: 14:29
 */

namespace Admin\Controller;


class RepairController extends AdminController{
    public function index(){
        $pid = i('get.pid', 0);
        /* 获取频道列表 */
        $map  = array('status' => array('gt', -1), 'pid'=>$pid);
        $list = M('repair')->where($map)->select();
        $this->assign('list', $list);
        $this->assign('pid', $pid);
        $this->meta_title = '导航管理';
        $this->display();
    }
    //>>>>>删除
    public function del(){
        $id = array_unique((array)I('id',0));
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map = array('id' => array('in', $id) );
        if(M('repair')->where($map)->delete()){
            //记录行为
            action_log('update_require', 'repair', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }
    //>>>>>修改功能
    public function edit($id = 0){
        if(IS_POST){
            $Channel = D('repair');
            $data = $Channel->create();
            if($data){

                if($Channel->save()){
                    //记录行为
                    action_log('update_repair', 'repair', $data['id'], UID);
                    $this->success('编辑成功', U('index'));
                } else {
                    $this->error('编辑失败');
                }
            } else {
                $this->error($Channel->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = M('repair')->find($id);
            if(false === $info){
                $this->error('获取配置信息错误');
            }
            $pid = i('get.pid', 0);
            //获取父导航
            if(!empty($pid)){
                $parent = M('repair')->where(array('id'=>$pid))->field('title')->find();
                $this->assign('parent', $parent);
            }
            //分配数据
            $this->assign('pid', $pid);
            $this->assign('info', $info);
            $this->meta_title = '编辑报修';
            $this->display();
        }
    }
    public function add(){
        if(IS_POST){
            $Channel = D('repair');
            $data = $Channel->create();
            if($data){
                $id = $Channel->add();
                if($id){
                    $this->success('新增成功', U('index'));
                    //记录行为
                    action_log('update_repair', 'repair', $id, UID);
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($Channel->getError());
            }
        } else {
            $pid = i('get.pid', 0);
            //获取父导航
            if(!empty($pid)){
                $parent = M('repair')->where(array('id'=>$pid))->field('title')->find();
                $this->assign('parent', $parent);
            }

            $this->assign('pid', $pid);
            $this->assign('info',null);
            $this->meta_title = '新增导航';
            $this->display('edit');
        }
    }


}