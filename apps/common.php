<?php 
use think\Route;
use app\admin\model\Modules;
use app\admin\model\Plugins;

/**
 * 检测是否安装某个模块
 * @param  string $name [description]
 * @return [type] [description]
 * @date   2017-09-17
 * @author 心云间、凝听 <981248356@qq.com>
 */
function check_install_module($name='')
{
    return Modules::checkInstallModule($name);
}

/**
 * 处理插件钩子
 * @param string $hook 钩子名称
 * @param mixed $params 传入参数
 * @return void
 */
function hook($hook, $params = [])
{
    \think\Hook::listen($hook, $params);
}

/**
 * 获取插件类的类名
 * @param  [type] $name [description]
 * @return [type] [description]
 * @date   2017-09-15
 * @author 心云间、凝听 <981248356@qq.com>
 */
function get_plugin_class($name) {
    $class = "\\plugins\\" . $name . "\\Index";
    return $class;
}

/**
 * 获取插件类的配置文件数组
 * @param string $name 插件名
 */
function get_plugin_config($name)
{
    if ($name!='') {
        $class = get_plugin_class($name);
        if (class_exists($class)) {
            $plugin = new $class();
            return $plugin->getConfig();
        } else {
            return [];
        }
    }
    
}

/**
 * 插件显示内容里生成访问插件的url
 * @param string $url url
 * @param array $param 参数
 */
// function plugin_url($url, $param = []) {
//     $url        = parse_url($url);
//     $case       = config('url_case_insensitive');
//     $plugins    = $case ? parse_name($url['scheme']) : $url['scheme'];
//     $controller = $case ? parse_name($url['host']) : $url['host'];
//     $action     = trim($case ? strtolower($url['path']) : $url['path'], '/');

//     /* 解析URL带的参数 */
//     if (isset($url['query'])) {
//         parse_str($url['query'], $query);
//         $param = array_merge($query, $param);
//     }

//     /* 基础参数 */
//     $params = [
//         'ad' => $plugins,
//         'co' => $controller,
//         'ac' => $action,
//     ];
//     $params = array_merge($params, $param); //添加额外参数
//     return \think\Url::build('home/plugin/execute', $params);
// }

/**
 * 获取插件地址
 * @param  [type] $url   [description]
 * @param  [type] $param [description]
 * @return [type]        [description]
 */
function plugin_url($url, $param)
{
    // 拆分URL
    $url        = explode('/', $url);
    $plugin     = $url[0];
    $controller = $url[1];
    $action     = $url[2];

    // 调用u函数
    $param['_plugin']     = $plugin;
    $param['_controller'] = $controller;
    $param['_action']     = $action;
    return url("home/plugin/execute", $param);
}
