<?php

namespace App\Providers;

use App\Models\Order;
use App\Observers\OrderObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Yansongda\Pay\Pay;
use Elasticsearch\ClientBuilder as ESClientBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->singleton() 往服务容器中注入一个单例对象，
        // 第一次从容器中取对象时会调用回调函数来生成对应的对象并保存到容器中，之后再去取的时候直接将容器中的对象返回。
        // 往服务容器注入一个名为 alipay 的单例对象
        $this->app->singleton('alipay', function () {
            $config = config('pay.alipay');
            $config['notify_url'] = ngrok_url('payment.alipay.notify');
            $config['return_url'] = route('payment.alipay.return');
            // 判断当前项目运行环境是否为线上环境，app()->environment() 获取当前运行的环境，线上环境会返回 production
            if (app()->environment() !== 'production') {
                $config['mode'] =  'dev';
                $config['log']['level'] = Logger::DEBUG;
            } else {
                $config['log']['level'] = Logger::WARNING;
            }

            // 调用 Yansongda\Pay 来创建一个支付宝支付对象
            return Pay::alipay($config);
        });

        $this->app->singleton('wechat_pay', function () {
            $config = config('pay.wechat');
            $config['notify_url'] = ngrok_url('payment.wechat.notify');
            // 判断当前项目运行环境是否为线上环境
            if (app()->environment() !== 'production') {
                $config['log']['level'] = Logger::DEBUG;
            } else {
                $config['log']['level'] = Logger::WARNING;
            }

            // 调用 Yansongda\Pay 来创建一个微信支付对象
            return Pay::wechat($config);
        });

        // 注册一个名为 es 的单例
        $this->app->singleton('es', function () {
            // 从配置文件读取 Elasticsearch 服务器列表
            $hosts = config('database.elasticsearch.hosts');
            $builder = ESClientBuilder::create()->setHosts($hosts);
            // 如果是开发环境
            if (app()->environment() === 'local') {
                // 配置日志，Elasticsearch 的请求和返回数据将打印到日志文件中，方便调试
                $builder->setLogger(app('log')->getLogger());
            }
            return $builder->build();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap(); // 分页使用 bootstrap
        Order::observe(OrderObserver::class);

        // 当 Laravel 渲染 products.index 和 products.show 模板时，就会使用 CategoryTreeComposer 这个来注入类目树变量
        // 同时 Laravel 还支持通配符，例如 products.* 即代表当渲染 products 目录下的模板时都执行这个 ViewComposer
        \View::composer(['products.index', 'products.show'], \App\Http\ViewComposers\CategoryTreeComposer::class);
    }
}
