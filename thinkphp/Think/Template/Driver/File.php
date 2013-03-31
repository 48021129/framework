<?php
// +----------------------------------------------------------------------
// | TOPThink [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://topthink.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

namespace Think\Template\Driver;
class File {
    // 写入编译缓存
    public function write($cacheFile,$content){
        // 检测模板目录
        $dir     =  dirname($cacheFile);
        if(!is_dir($dir))
            mkdir($dir,0755,true);
        // 生成模板缓存文件
        if( false === file_put_contents($cacheFile,$content))
            E('_CACHE_WRITE_ERROR_:'.$cacheFile);
    }
    
    // 读取编译编译
    public function read($cacheFile,$vars){
        // 模板阵列变量分解成为独立变量
        extract($vars, EXTR_OVERWRITE);
        //载入模版缓存文件
        include $cacheFile;
    }

    // 检查编译缓存是否有效
    public function check($template,$cacheFile,$cacheTime){
        if(!is_file($cacheFile)|| (is_file($template) && filemtime($template) > filemtime($cacheFile))) {
            // 模板文件如果有更新则缓存需要更新
            return false;
        }elseif ($cacheTime != 0 && time() > filemtime($cacheFile)+$cacheTime) {
            // 缓存是否在有效期
            return false;
        }
        return true;
    }
}