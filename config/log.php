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

return [
    'path'        => '/www/wwwlogs/thinkphplog',
    'type'        => 'File',
    'file_size'   => 1024 * 1024 * 10,
    'apart_level' => ['emergency', 'alert', 'critical', 'error', 'sql'],
];
