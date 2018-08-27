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
use service\DataService;
use service\NodeService;
use service\ToolsService;
use think\Db;
use \think\Request;
use think\facade\Request as temprequest;
use think\facade\Log;


/**
 * 系统权限管理控制器
 * Class Auth
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/02/15 18:13
 */
class Ceshi extends BasicAdmin
{

    public $code = "";
    public $ceshiresult  = "";
    public $time  = "";
    //public $birthdate = "";
    public $AK="PjQ7chsRSzOMX6AbGiNnicv9";
    /**
     * @return \think\App
     */
    public function index()
    {
        return "ceshi";
    }

    /**
     * @return \think\App
     */
    public function getcode()
    {

        $result=new Ceshi();
        $result->code="200";


        $ip=$this->getIP();
        Log::error($ip."进来的ip");
        //echo $ip;
        $post_data = array(
            'ip' => $ip,
            'ak' => $this->AK,
            'data_digest' => '签名'
        );

        $url='http://api.map.baidu.com/location/ip';
       // $html = file_get_contents($url);
        $html=$this->send_post($url,$post_data);
        $result->ceshiresult=$html;
        $de_json = json_decode($html,TRUE);
       // $count_json = count($de_json);
        //echo $html;
        Log::error($de_json);
        if(strpos($html,'address')!==false){
            $adress=$de_json["address"];
            if(strpos($adress,'广州') !== false){
                $result->ceshiresult="ceshi";
                return json_encode($result);
            }else{
                $db1 =Db::table('web_config')->where('isused','1')->select();
                $result->ceshiresult=$db1[0]['code'];
                return json_encode($result);
               // $result->ceshiresult="CeEV7H074d";
               // (r竹e彩静TN垒J静儒菁泰)
               // $result->ceshiresult="(r竹e彩静TN垒J静儒菁泰)";
             //   return json_encode($result);
            }
        }else{
            $result->ceshiresult="ceshi";
            return json_encode($result);
        }
    }




    public function getcode1()
    {

        $result=new Ceshi();
        $result->code="200";


        $ip=$this->getIP();
        Log::error($ip."进来的ip");
        //echo $ip;
        $post_data = array(
            'ip' => $ip,
            'ak' => $this->AK,
            'data_digest' => '签名'
        );

        //保存orders数据

       // $name=Request::param('name');
      //  $configdata = ['ip' => $code, 'name' => $name];
      //  $db=Db::name('web_config')->insert($data);

        $url='http://api.map.baidu.com/location/ip';
        // $html = file_get_contents($url);
        $html=$this->send_post($url,$post_data);
        $result->ceshiresult=$html;
        $de_json = json_decode($html,TRUE);
        // $count_json = count($de_json);
        //echo $html;
        Log::error($de_json);
        if(strpos($html,'address')!==false){
            $adress=$de_json["address"];
            if(strpos($adress,'广州') !== false){
                $result->ceshiresult="ceshi";
                return json_encode($result);
            }else{
                //1  100次    2   10000
                $db1 =Db::table('web_config')->where('isused','1')->select();
                // $result->ceshiresult=$db1[0]['code'];
                //循环db
                for ($i=0; $i<count($db1); $i++)
                {
                    //echo  'SELECT * FROM web_configorders WHERE DATEDIFF(time,NOW())=0 AND configid='.$db1[$i]['id'];
                    $orderidcount = Db::query('SELECT * FROM web_configorders WHERE DATEDIFF(time,NOW())=0 AND configid='.$db1[$i]['id']);
                    // $ordersbyconfigid =Db::table('web_configorders')->where('configid',$db1[$i]['id'])->select();
                    echo  count($orderidcount).'/br';
                    if(count($orderidcount)<=100){
                        $result->ceshiresult=$db1[$i]['code'];
                        //保存一次
                        $this->saveConfigorders($db1[$i]['id'],$ip);
                        return json_encode($result);
                    }
                }

                $db2 =Db::table('web_config')->where('isused','2')->select();
                // $result->ceshiresult=$db1[0]['code'];
                //循环db
                for ($i=0; $i<count($db2); $i++)
                {
                    //echo  'SELECT * FROM web_configorders WHERE DATEDIFF(time,NOW())=0 AND configid='.$db1[$i]['id'];
                    $orderidcount = Db::query('SELECT * FROM web_configorders WHERE DATEDIFF(time,NOW())=0 AND configid='.$db2[$i]['id']);
                    // $ordersbyconfigid =Db::table('web_configorders')->where('configid',$db1[$i]['id'])->select();
                   // echo  count($orderidcount).'/br';
                    if(count($orderidcount)<=5000){
                        $result->ceshiresult=$db2[$i]['code'];
                        //保存一次
                        $this->saveConfigorders($db2[$i]['id'],$ip);
                        return json_encode($result);
                    }
                }

                $db0 =Db::table('web_config')->where('isused','0')->select();
                $result->ceshiresult=$db0[0]['code'];
                $this->saveConfigorders($db0[0]['id'],$ip);
                return json_encode($result);

            }
        }else{
            $result->ceshiresult="ceshi";
            return json_encode($result);
        }
    }


    /**
     * @return string
     */
    public function saveConfigorders($configid,$ip)
    {

          $configdata = ['ip' => $ip, 'configid' => $configid];
          $db=Db::name('web_configorders')->insert($configdata);

    }


    public function getcode2()
    {

        $result=new Ceshi();
        $result->code="200";


        $ip=$this->getIP();
        Log::error($ip."进来的ip");
        //echo $ip;
        $post_data = array(
            'ip' => $ip,
            'ak' => $this->AK,
            'data_digest' => '签名'
        );

        //保存orders数据

        // $name=Request::param('name');
        //  $configdata = ['ip' => $code, 'name' => $name];
        //  $db=Db::name('web_config')->insert($data);

        $url='http://api.map.baidu.com/location/ip';
        // $html = file_get_contents($url);
        $html=$this->send_post($url,$post_data);
        $result->ceshiresult=$html;
        $de_json = json_decode($html,TRUE);
        // $count_json = count($de_json);
        //echo $html;
        Log::error($de_json);
                //1  100次    2   10000
                $db1 =Db::table('web_config')->where('isused','1')->select();
                // $result->ceshiresult=$db1[0]['code'];
                //循环db
                for ($i=0; $i<count($db1); $i++)
                {
                    //echo  'SELECT * FROM web_configorders WHERE DATEDIFF(time,NOW())=0 AND configid='.$db1[$i]['id'];
                    $orderidcount = Db::query('SELECT * FROM web_configorders WHERE DATEDIFF(time,NOW())=0 AND configid='.$db1[$i]['id']);
                    // $ordersbyconfigid =Db::table('web_configorders')->where('configid',$db1[$i]['id'])->select();
                    echo  count($orderidcount).'/br';
                    if(count($orderidcount)<=100){
                        $result->ceshiresult=$db1[$i]['code'];
                        //保存一次
                        $this->saveConfigorders($db1[$i]['id'],$ip);
                        return json_encode($result);
                    }
                }

                $db2 =Db::table('web_config')->where('isused','2')->select();
                // $result->ceshiresult=$db1[0]['code'];
                //循环db
                for ($i=0; $i<count($db2); $i++)
                {
                    //echo  'SELECT * FROM web_configorders WHERE DATEDIFF(time,NOW())=0 AND configid='.$db1[$i]['id'];
                    $orderidcount = Db::query('SELECT * FROM web_configorders WHERE DATEDIFF(time,NOW())=0 AND configid='.$db2[$i]['id']);
                    // $ordersbyconfigid =Db::table('web_configorders')->where('configid',$db1[$i]['id'])->select();
                    echo  count($orderidcount).'/br';
                    if(count($orderidcount)<=5000){
                        $result->ceshiresult=$db2[$i]['code'];
                        //保存一次
                        $this->saveConfigorders($db2[$i]['id'],$ip);
                        return json_encode($result);
                    }
                }

                $db0 =Db::table('web_config')->where('isused','0')->select();
                $result->ceshiresult=$db0[0]['code'];
                $this->saveConfigorders($db0[0]['id'],$ip);
                return json_encode($result);



    }

    function getIP()
    {
        static $realip;
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $realip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
    }
        return $realip;
    }


    /****
     * @param $url
     * @param $post_data
     * @return bool|string
     * 第三方物流接口请求
     */
    function send_post($url,$post_data)
    {


        $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);



        return $result;
    }


    /**
     * $str 原始中文字符串
     * $encoding 原始字符串的编码，默认GBK
     * $prefix 编码后的前缀，默认"&#"
     * $postfix 编码后的后缀，默认";"
     */
    function unicode_encode($str, $encoding = 'GBK', $prefix = '&#', $postfix = ';') {
        $str = iconv($encoding, 'UCS-2', $str);
        $arrstr = str_split($str, 2);
        $unistr = '';
        for($i = 0, $len = count($arrstr); $i < $len; $i++) {
            $dec = hexdec(bin2hex($arrstr[$i]));
            $unistr .= $prefix . $dec . $postfix;
        }
        return $unistr;
    }

    /**
     * $str Unicode编码后的字符串
     * $decoding 原始字符串的编码，默认GBK
     * $prefix 编码字符串的前缀，默认"&#"
     * $postfix 编码字符串的后缀，默认";"
     */
    function unicode_decode($unistr, $encoding = 'GBK', $prefix = '&#', $postfix = ';') {
        $arruni = explode($prefix, $unistr);
        $unistr = '';
        for($i = 1, $len = count($arruni); $i < $len; $i++) {
            if (strlen($postfix) > 0) {
                $arruni[$i] = substr($arruni[$i], 0, strlen($arruni[$i]) - strlen($postfix));
            }
            $temp = intval($arruni[$i]);
            $unistr .= ($temp < 256) ? chr(0) . chr($temp) : chr($temp / 256) . chr($temp % 256);
        }
        return iconv('UCS-2', $encoding, $unistr);
    }

}
