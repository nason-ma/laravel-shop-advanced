<?php

namespace App\Console\Commands\Elasticsearch;

use App\Models\Product;
use Illuminate\Console\Command;

class SyncProducts extends Command
{
    /**
     * The name and signature of the console command.
     * 添加一个名为 index，默认值为 products 的参数
     * @var string
     */
    protected $signature = 'es:sync-products {--index=products}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '将商品数据同步到 Elasticsearch';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        // 获取 Elasticsearch 对象
        $es = app('es');

        Product::query()
            // 预加载 SKU 和 商品属性数据，避免 N + 1 问题
            ->with(['skus', 'properties'])
            // 使用 chunkById 避免一次性加载过多数据
            ->chunkById(100, function ($products) use ($es) {
                $this->info(sprintf('正在同步 ID 范围为 %s 至 %s 的商品', $products->first()->id, $products->last()->id));
                // 初始化请求体
                $req = ['body' => []];
                // 遍历商品
                foreach ($products as $product) {
                    // 将商品模型转为 Elasticsearch 所用的数组
                    $data = $product->toESArray();

                    $req['body'][] = [
                        'index' => [
                            // 从参数中读取索引名称
                            '_index' => $this->option('index'),
                            '_type'  => '_doc',
                            '_id'    => $data['id'],
                        ],
                    ];
                    $req['body'][] = $data;
                }
                try {
                    // 使用 bulk 方法批量创建，这是 Elasticsearch 提供的一个批量操作接口
                    // 设想一下假如我们系统里有数百万条商品，如果每条商品都单独请求一次 Elasticsearch 的 API，那就是数百万次 的请求，性能肯定是很差的，而 bulk() 方法可以让我们用一次 API 请求完成一批操作，从而减少请求次数的数量级，提高整体性能。
                    // bulk() 方法的参数是一个数组，数组的第一行描述了我们要做的操作，
                    // 第二行则代表这个操作所需要的数据，第三行操作描述，第四行数据，
                    // 依次类推，当然如果是删除操作则没有数据行。我们这个代码里只有创建数据，因此都是每两行一组操作
                    $es->bulk($req);
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                }
            });
        $this->info('同步完成');
    }
}
