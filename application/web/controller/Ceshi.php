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

        $ip= gethostbyname(temprequest::host());
        Log::error($ip."进来的ip");
        //echo  temprequest::host();

       // $ip=$this->request->param('ip', '');

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
                $result->ceshiresult="IOyt1a07Jw";
                return json_encode($result);
            }
        }else{
            $result->ceshiresult="ceshi";
            return json_encode($result);
        }

        //return json_encode($result);
        //return $adress;
    }

    //不同环境下获取真实的IP
    function get_ip(){
        //判断服务器是否允许$_SERVER
        $ip = $_SERVER["REMOTE_ADDR"];


        return $ip;
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
