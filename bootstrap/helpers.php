<?php

use Illuminate\Support\Facades\Route;

/**
 * Created by PhpStorm.
 * Author: Administrator
 * Date: 2021/2/18
 * Time: 15:50
 *
 *                    _ooOoo_
 *                   o8888888o
 *                   88" . "88
 *                   (| -_- |)
 *                    O\ = /O
 *                ____/`---'\____
 *              .   ' \\| |// `.
 *               / \\||| : |||// \
 *             / _||||| -:- |||||- \
 *               | | \\\ - /// | |
 *             | \_| ''\---/'' | |
 *              \ .-\__ `-` ___/-. /
 *           ___`. .' /--.--\ `. . __
 *        ."" '< `.___\_<|>_/___.' >'"".
 *       | | : `- \`.;`\ _ /`;.`/ - ` : | |
 *         \ \ `-. \_ __\ /__ _/ .-` / /
 * ======`-.____`-.___\_____/___.-`____.-'======
 *                    `=---='
 *
 * .............................................
 *          佛祖保佑             永无BUG
 */

/**
 * 将当前请求的路由名称转换为 CSS 类名称
 * @return string|string[]
 */
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

/**
 * 获取 ngrok 域名连接的路由 url
 * @param string $routeName 路由名称
 * @param array $parameters 路由参数
 * @return string
 */
function ngrok_url($routeName, $parameters = [])
{
    // 开发环境，并且配置了 NGROK_URL
    if (app()->environment('local') && $url = config('app.ngrok_url')) {
        // route() 函数第三个参数代表是否绝对路径
        return $url . route($routeName, $parameters, false);
    }

    return route($routeName, $parameters);
}

// 使用 PHP 的官方扩展 bcmath 提供的函数来进行金额计算，这是为了避免浮点数运算不精确的问题。
// 但是 bcmath 函数用起来很不方便，通常会使用 moontoast/math 这个库来作为替代，这个库的底层也是依赖于 bcmath，主要是做了面向对象的封装
// 这个库主要提供了 \Moontoast\Math\BigNumber 这个类，这个类的构造函数接受两个参数，第一个参数就是我们要参与运算的数值，第二个参数是可选参数，用于表示我们希望的计算精度（即精确到小数点后几位）
// 同时这个类提供了许多常见的算术运算方法，比如 加法 add()、减法 subtract()、乘法 multiply()、除法 divide() 等等
// 默认的精度为小数点后两位
function big_number($number, $scale = 2)
{
    return new \Moontoast\Math\BigNumber($number, $scale);
}
