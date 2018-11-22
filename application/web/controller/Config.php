<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\web\controller;

use controller\BasicAdmin;
use service\LogService;
use service\WechatService;
use think\Db;
use think\facade\Request;

/**
 * 后台参数配置控制器
 * Class Config
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/15 18:05
 */
class Config extends BasicAdmin
{

    /**
     * 指定当前数据表
     * @var string
     */
    public $table = 'WebConfig';

    /**
     * 用户列表
     * @return array|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\Exception
     */
    public function index()
    {
        $this->title = '支付宝参数';

        $db1 =Db::table('web_config')->select();
        $this->assign('list',$db1);
        return $this->fetch();
       // return json_encode($db1);
    }

    /**
     * 授权管理
     * @return array|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\Exception
     */
    public function auth()
    {
        return $this->_form($this->table, 'auth');
    }

    /**
     * 用户添加
     * @return array|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\Exception
     */
    public function add()
    {

        if(Request::has('name','post')){

            $code=Request::param('code');
            $name=Request::param('name');
            $data = ['code' => $code, 'name' => $name];
            $db=Db::name('web_config')->insert($data);

            return "123";

        }else{
            return $this->fetch();
        }



    }
    public function uploadfile1()
    {
        return "uploadfile1";
    }
    public function uploadfile()
    {
        return $this->fetch();
    }


    public function upload_photo()
    {
        return $this->fetch();
    }
    /**
     * 用户编辑
     * @return array|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\Exception
     */
    public function edit()
    {
        if(Request::has('name','post')){
            $id=Request::param('id');
            $code=Request::param('code');
            $name=Request::param('name');
            $isused=Request::param('isused');

            Db::name('web_config')
                ->where('id', $id)
                ->update(['code' => $code,
                    'name' => $name,
                    'isused' => $isused]);
            //$data = ['code' => $code, 'name' => $name];
            //$db=Db::name('web_config')->insert($data);

            return "123";
        }else{
            $id=Request::param('id');
            // $data = ['code' => $code, 'name' => $name];
            $db=Db::name('web_config')->where('id',$id)->find();
            $this->assign('data',$db);
            return $this->fetch();
        };

    }

    //文件上传
    public function uploadfiles()
    {

        // 获取表单上传文件
        $file = request()->file('file1');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'static' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                echo $info->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getFilename();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
        $file2 = request()->file('file2');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file2){
            $info2 = $file2->move(ROOT_PATH . 'static' . DS . 'uploads');
            if($info2){
                // 成功上传后 获取上传信息
                // 输出 jpg
                echo $info2->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                echo $info2->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                echo $info2->getFilename();
            }else{
                // 上传失败获取错误信息
                echo $file2->getError();
            }
        }
    }




    /**
     * 删除用户
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function del()
    {
        $id=Request::param('id');
        Db::table('web_config')->delete($id);
        return $id;

    }

    /**
     * 用户禁用
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function forbid()
    {
        if (in_array('10000', explode(',', $this->request->post('id')))) {
            $this->error('系统超级账号禁止操作！');
        }
        if (DataService::update($this->table)) {
            $this->success("用户禁用成功！", '');
        }
        $this->error("用户禁用失败，请稍候再试！");
    }

    /**
     * 用户禁用
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function resume()
    {
        if (DataService::update($this->table)) {
            $this->success("用户启用成功！", '');
        }
        $this->error("用户启用失败，请稍候再试！");
    }

}
